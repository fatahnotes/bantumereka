import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { Heart, Upload, ArrowRight, ArrowLeft, Check } from 'lucide-react'
import api from '@/services/api'

const PROVINSI_LIST = [
  'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
  'Banten', 'DI Yogyakarta', 'Bali', 'Aceh', 'Sumatera Utara',
  'Sumatera Barat', 'Riau', 'Kepulauan Riau', 'Jambi',
  'Sumatera Selatan', 'Bangka Belitung', 'Bengkulu', 'Lampung',
  'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan',
  'Kalimantan Timur', 'Kalimantan Utara', 'Sulawesi Utara',
  'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara',
  'Gorontalo', 'Sulawesi Barat', 'Maluku', 'Maluku Utara',
  'Papua', 'Papua Barat', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
]

export default function RelawanPage() {
  const navigate = useNavigate()
  const [step, setStep] = useState(1)
  const [loading, setLoading] = useState(false)
  const [success, setSuccess] = useState(false)
  const [waLink, setWaLink] = useState('')
  const [error, setError] = useState('')

  const [form, setForm] = useState({
    nama_lengkap: '', email: '', no_hp: '', bulan_tahun_lahir: '',
    jenis_kelamin: '', kontak_darurat: '', provinsi: '', kabupaten: '',
    kecamatan: '', kelurahan: '', kelurahan_manual: '', alamat_detail: '',
    motivasi: '', pengalaman_relawan: '', riwayat_pekerjaan: '', keahlian: '',
    riwayat_kesehatan: '', hobi: '', organisasi: '', pendidikan_terakhir: '',
    prodi: '', pernyataan: false,
  })
  const [foto, setFoto] = useState<File | null>(null)
  const [sosial, setSosial] = useState<{ jenis: string; url: string }[]>([{ jenis: 'instagram', url: '' }])

  function updateField(field: string, value: any) {
    setForm((prev) => ({ ...prev, [field]: value }))
  }

  const finalKelurahan = form.kelurahan || form.kelurahan_manual

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    setLoading(true)

    const formData = new FormData()
    Object.entries(form).forEach(([k, v]) => formData.append(k, String(v)))
    formData.set('kelurahan', finalKelurahan)
    if (foto) formData.append('foto', foto)
    sosial.forEach((s, i) => {
      if (s.jenis && s.url) {
        formData.append('sosial_jenis', s.jenis)
        formData.append('sosial_url', s.url)
      }
    })

    try {
      const res = await api.post('/relawan/register', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      setSuccess(true)
      setWaLink(res.data.wa_group_link || '')
    } catch (err: any) {
      setError(err.response?.data?.detail || 'Gagal mendaftar. Coba lagi.')
    } finally {
      setLoading(false)
    }
  }

  if (success) {
    return (
      <div className="container-custom py-16 text-center max-w-lg mx-auto">
        <div className="text-6xl mb-4">🎉</div>
        <h1 className="text-2xl font-extrabold text-deep mb-2">Pendaftaran Berhasil!</h1>
        <p className="text-gray-600 mb-6">Data Anda sedang diverifikasi oleh tim kami.</p>
        {waLink && (
          <a
            href={waLink}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-block bg-green-500 text-white px-6 py-3 rounded-full font-bold mb-4 hover:bg-green-600"
          >
            💬 Gabung WhatsApp Group
          </a>
        )}
        <br />
        <button onClick={() => navigate('/')} className="btn-primary mt-4">Kembali ke Beranda</button>
      </div>
    )
  }

  return (
    <div className="container-custom py-8 md:py-12 max-w-2xl mx-auto">
      <h1 className="text-3xl font-extrabold text-deep mb-2">Daftar Relawan</h1>
      <p className="text-gray-500 mb-8">Isi data diri Anda untuk bergabung sebagai relawan Bantu Mereka.</p>

      {/* Step Indicator */}
      <div className="flex items-center gap-2 mb-8">
        {[1, 2, 3].map((s) => (
          <div key={s} className="flex items-center gap-2 flex-1">
            <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold ${
              step >= s ? 'bg-primary text-white' : 'bg-gray-200 text-gray-400'
            }`}>
              {step > s ? <Check size={14} /> : s}
            </div>
            <div className={`flex-1 h-1 rounded ${step > s ? 'bg-primary' : 'bg-gray-200'}`} />
          </div>
        ))}
        <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold ${
          step >= 3 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-400'
        }`}>
          {step > 3 ? <Check size={14} /> : 3}
        </div>
      </div>

      <form onSubmit={handleSubmit}>
        {/* Step 1: Data Diri */}
        {step === 1 && (
          <div className="space-y-4">
            <h2 className="text-xl font-bold text-deep">Data Diri</h2>
            <InputField label="Nama Lengkap *" value={form.nama_lengkap} onChange={(v) => updateField('nama_lengkap', v)} />
            <InputField label="Email *" type="email" value={form.email} onChange={(v) => updateField('email', v)} />
            <InputField label="Nomor HP *" type="tel" value={form.no_hp} onChange={(v) => updateField('no_hp', v)} />
            <InputField label="Bulan & Tahun Lahir" type="month" value={form.bulan_tahun_lahir} onChange={(v) => updateField('bulan_tahun_lahir', v)} />
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Jenis Kelamin</label>
              <select
                value={form.jenis_kelamin}
                onChange={(e) => updateField('jenis_kelamin', e.target.value)}
                className="w-full border border-gray-300 rounded-lg px-4 py-3"
              >
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <InputField label="Kontak Darurat" value={form.kontak_darurat} onChange={(v) => updateField('kontak_darurat', v)} />
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Upload Foto</label>
              <input type="file" accept="image/*" onChange={(e) => setFoto(e.target.files?.[0] || null)} className="w-full" />
              <p className="text-xs text-gray-400 mt-1">JPG/PNG, max 2MB</p>
            </div>
          </div>
        )}

        {/* Step 2: Alamat */}
        {step === 2 && (
          <div className="space-y-4">
            <h2 className="text-xl font-bold text-deep">Alamat</h2>
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Provinsi *</label>
              <select value={form.provinsi} onChange={(e) => updateField('provinsi', e.target.value)} className="w-full border border-gray-300 rounded-lg px-4 py-3">
                <option value="">Pilih Provinsi</option>
                {PROVINSI_LIST.map((p) => <option key={p} value={p}>{p}</option>)}
              </select>
            </div>
            <InputField label="Kabupaten/Kota *" value={form.kabupaten} onChange={(v) => updateField('kabupaten', v)} />
            <InputField label="Kecamatan *" value={form.kecamatan} onChange={(v) => updateField('kecamatan', v)} />
            <InputField label="Kelurahan" value={form.kelurahan} onChange={(v) => updateField('kelurahan', v)} />
            {!form.kelurahan && (
              <InputField label="Kelurahan (Manual)" value={form.kelurahan_manual} onChange={(v) => updateField('kelurahan_manual', v)} />
            )}
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Alamat Detail</label>
              <textarea value={form.alamat_detail} onChange={(e) => updateField('alamat_detail', e.target.value)} rows={2} className="w-full border border-gray-300 rounded-lg px-4 py-3" />
            </div>
          </div>
        )}

        {/* Step 3: Motivasi & Data Tambahan */}
        {step === 3 && (
          <div className="space-y-4">
            <h2 className="text-xl font-bold text-deep">Motivasi & Data Tambahan</h2>
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Motivasi Bergabung *</label>
              <textarea value={form.motivasi} onChange={(e) => updateField('motivasi', e.target.value)} rows={3} className="w-full border border-gray-300 rounded-lg px-4 py-3" placeholder="Ceritakan motivasi Anda..." />
            </div>
            <InputField label="Pengalaman Relawan" value={form.pengalaman_relawan} onChange={(v) => updateField('pengalaman_relawan', v)} />
            <InputField label="Riwayat Pekerjaan" value={form.riwayat_pekerjaan} onChange={(v) => updateField('riwayat_pekerjaan', v)} />
            <InputField label="Keahlian" value={form.keahlian} onChange={(v) => updateField('keahlian', v)} />
            <InputField label="Riwayat Kesehatan" value={form.riwayat_kesehatan} onChange={(v) => updateField('riwayat_kesehatan', v)} />
            <InputField label="Hobi" value={form.hobi} onChange={(v) => updateField('hobi', v)} />
            <InputField label="Organisasi" value={form.organisasi} onChange={(v) => updateField('organisasi', v)} />
            <InputField label="Pendidikan Terakhir" value={form.pendidikan_terakhir} onChange={(v) => updateField('pendidikan_terakhir', v)} />
            <InputField label="Program Studi" value={form.prodi} onChange={(v) => updateField('prodi', v)} />

            {/* Media Sosial */}
            <div>
              <label className="block text-sm font-semibold text-deep mb-2">Media Sosial</label>
              {sosial.map((s, i) => (
                <div key={i} className="flex gap-2 mb-2">
                  <select value={s.jenis} onChange={(e) => {
                    const updated = [...sosial]; updated[i].jenis = e.target.value; setSosial(updated)
                  }} className="w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="instagram">Instagram</option>
                    <option value="facebook">Facebook</option>
                    <option value="twitter">Twitter</option>
                    <option value="tiktok">TikTok</option>
                    <option value="linkedin">LinkedIn</option>
                  </select>
                  <input type="url" value={s.url} onChange={(e) => {
                    const updated = [...sosial]; updated[i].url = e.target.value; setSosial(updated)
                  }} placeholder="URL profil" className="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm" />
                  {i === sosial.length - 1 && (
                    <button type="button" onClick={() => setSosial([...sosial, { jenis: 'instagram', url: '' }])} className="text-primary text-sm">+ Tambah</button>
                  )}
                </div>
              ))}
            </div>

            {/* Pernyataan */}
            <label className="flex items-start gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer">
              <input type="checkbox" checked={form.pernyataan} onChange={(e) => updateField('pernyataan', e.target.checked)} className="mt-1" />
              <span className="text-sm text-gray-600">Saya menyatakan siap berkontribusi sebagai relawan Bantu Mereka dan data yang saya isi adalah benar.</span>
            </label>
          </div>
        )}

        {error && <div className="bg-red-50 text-red-600 p-3 rounded-lg text-sm mt-4">{error}</div>}

        {/* Navigation Buttons */}
        <div className="flex justify-between mt-8">
          {step > 1 && (
            <button type="button" onClick={() => setStep(step - 1)} className="btn-outline">
              <ArrowLeft size={16} className="inline mr-1" /> Sebelumnya
            </button>
          )}
          <div className="flex-1" />
          {step < 3 ? (
            <button type="button" onClick={() => setStep(step + 1)} className="btn-primary">
              Selanjutnya <ArrowRight size={16} className="inline ml-1" />
            </button>
          ) : (
            <button type="submit" disabled={loading} className="btn-primary">
              {loading ? 'Mengirim...' : 'Daftar Sekarang'}
            </button>
          )}
        </div>
      </form>
    </div>
  )
}

function InputField({ label, value, onChange, type = 'text', placeholder }: {
  label: string
  value: string
  onChange: (v: string) => void
  type?: string
  placeholder?: string
}) {
  return (
    <div>
      <label className="block text-sm font-semibold text-deep mb-1">{label}</label>
      <input
        type={type}
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder={placeholder}
        className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
      />
    </div>
  )
}
