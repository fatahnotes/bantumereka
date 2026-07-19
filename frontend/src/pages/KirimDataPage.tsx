import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { Upload } from 'lucide-react'
import api from '@/services/api'

const PROVINSI_LIST = [
  'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
  'Banten', 'DI Yogyakarta', 'Bali', 'Aceh', 'Sumatera Utara',
  'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Lampung',
  'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Timur',
  'Sulawesi Utara', 'Sulawesi Selatan', 'Papua', 'NTB', 'NTT',
]

const URGENSI_LEVELS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

export default function KirimDataPage() {
  const navigate = useNavigate()
  const [loading, setLoading] = useState(false)
  const [success, setSuccess] = useState(false)
  const [error, setError] = useState('')

  const [form, setForm] = useState({
    nama_pelapor: '', kontak_pelapor: '', ketua_rt: '', kontak_rt: '',
    nama_sasaran: '', provinsi: '', kabupaten: '', kecamatan: '',
    kelurahan: '', kelurahan_manual: '', alamat_detail: '',
    permasalahan: '', link_pendukung: '', tingkat_urgensi: 5,
  })
  const [fileProposal, setFileProposal] = useState<File | null>(null)
  const [filePendukung, setFilePendukung] = useState<File | null>(null)

  function update(field: string, value: any) {
    setForm((prev) => ({ ...prev, [field]: value }))
  }

  const finalKelurahan = form.kelurahan || form.kelurahan_manual

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    setLoading(true)

    const fd = new FormData()
    Object.entries(form).forEach(([k, v]) => fd.append(k, String(v)))
    fd.set('kelurahan', finalKelurahan)
    if (fileProposal) fd.append('file_proposal', fileProposal)
    if (filePendukung) fd.append('file_pendukung', filePendukung)

    try {
      await api.post('/laporan/kirim', fd, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      setSuccess(true)
    } catch (err: any) {
      setError(err.response?.data?.detail || 'Gagal mengirim laporan')
    } finally {
      setLoading(false)
    }
  }

  if (success) {
    return (
      <div className="container-custom py-16 text-center max-w-lg mx-auto">
        <div className="text-6xl mb-4">📋</div>
        <h1 className="text-2xl font-extrabold text-deep mb-2">Laporan Terkirim!</h1>
        <p className="text-gray-600 mb-6">Tim kami akan meninjau data yang Anda kirimkan. Terima kasih telah peduli!</p>
        <button onClick={() => navigate('/')} className="btn-primary">Kembali ke Beranda</button>
      </div>
    )
  }

  return (
    <div className="container-custom py-8 md:py-12 max-w-2xl mx-auto">
      <h1 className="text-3xl font-extrabold text-deep mb-2">Kirim Data Penerima Manfaat</h1>
      <p className="text-gray-500 mb-8">
        Laporkan orang atau komunitas di sekitar Anda yang membutuhkan bantuan.
        Tim kami akan menindaklanjuti laporan Anda.
      </p>

      <form onSubmit={handleSubmit} className="space-y-5">
        {/* Pelapor */}
        <fieldset className="border border-gray-200 rounded-xl p-5">
          <legend className="text-lg font-bold text-deep px-2">Data Pelapor</legend>
          <div className="space-y-4">
            <InputField label="Nama Pelapor *" value={form.nama_pelapor} onChange={(v) => update('nama_pelapor', v)} />
            <InputField label="Kontak Pelapor" value={form.kontak_pelapor} onChange={(v) => update('kontak_pelapor', v)} />
            <InputField label="Nama Ketua RT" value={form.ketua_rt} onChange={(v) => update('ketua_rt', v)} />
            <InputField label="Kontak RT" value={form.kontak_rt} onChange={(v) => update('kontak_rt', v)} />
          </div>
        </fieldset>

        {/* Sasaran */}
        <fieldset className="border border-gray-200 rounded-xl p-5">
          <legend className="text-lg font-bold text-deep px-2">Data Penerima Manfaat</legend>
          <div className="space-y-4">
            <InputField label="Nama Sasaran" value={form.nama_sasaran} onChange={(v) => update('nama_sasaran', v)} />
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Provinsi *</label>
              <select value={form.provinsi} onChange={(e) => update('provinsi', e.target.value)} className="w-full border border-gray-300 rounded-lg px-4 py-3">
                <option value="">Pilih Provinsi</option>
                {PROVINSI_LIST.map((p) => <option key={p} value={p}>{p}</option>)}
              </select>
            </div>
            <InputField label="Kabupaten/Kota *" value={form.kabupaten} onChange={(v) => update('kabupaten', v)} />
            <InputField label="Kecamatan *" value={form.kecamatan} onChange={(v) => update('kecamatan', v)} />
            <InputField label="Kelurahan" value={form.kelurahan} onChange={(v) => update('kelurahan', v)} />
            {!form.kelurahan && <InputField label="Kelurahan (Manual)" value={form.kelurahan_manual} onChange={(v) => update('kelurahan_manual', v)} />}
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Alamat Detail</label>
              <textarea value={form.alamat_detail} onChange={(e) => update('alamat_detail', e.target.value)} rows={2} className="w-full border border-gray-300 rounded-lg px-4 py-3" />
            </div>
          </div>
        </fieldset>

        {/* Detail Masalah */}
        <fieldset className="border border-gray-200 rounded-xl p-5">
          <legend className="text-lg font-bold text-deep px-2">Detail Permasalahan</legend>
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Permasalahan</label>
              <textarea value={form.permasalahan} onChange={(e) => update('permasalahan', e.target.value)} rows={3} className="w-full border border-gray-300 rounded-lg px-4 py-3" placeholder="Deskripsikan permasalahan..." />
            </div>

            <div>
              <label className="block text-sm font-semibold text-deep mb-1">Tingkat Urgensi: {form.tingkat_urgensi}/10</label>
              <input type="range" min="1" max="10" value={form.tingkat_urgensi} onChange={(e) => update('tingkat_urgensi', parseInt(e.target.value))} className="w-full" />
              <div className="flex justify-between text-xs text-gray-400">
                <span>Rendah</span><span>Tinggi</span>
              </div>
            </div>

            <InputField label="Link Pendukung" value={form.link_pendukung} onChange={(v) => update('link_pendukung', v)} placeholder="Link berita, video, dll." />
          </div>
        </fieldset>

        {/* File Upload */}
        <fieldset className="border border-gray-200 rounded-xl p-5">
          <legend className="text-lg font-bold text-deep px-2">Dokumen Pendukung</legend>
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">File Proposal (PDF, max 2MB)</label>
              <input type="file" accept=".pdf" onChange={(e) => setFileProposal(e.target.files?.[0] || null)} className="w-full" />
            </div>
            <div>
              <label className="block text-sm font-semibold text-deep mb-1">File Pendukung (PDF, max 2MB)</label>
              <input type="file" accept=".pdf" onChange={(e) => setFilePendukung(e.target.files?.[0] || null)} className="w-full" />
            </div>
          </div>
        </fieldset>

        {error && <div className="bg-red-50 text-red-600 p-3 rounded-lg text-sm">{error}</div>}

        <button type="submit" disabled={loading} className="w-full btn-primary text-lg py-4">
          {loading ? 'Mengirim...' : 'Kirim Laporan'}
        </button>
      </form>
    </div>
  )
}

function InputField({ label, value, onChange, type = 'text', placeholder }: {
  label: string; value: string; onChange: (v: string) => void; type?: string; placeholder?: string
}) {
  return (
    <div>
      <label className="block text-sm font-semibold text-deep mb-1">{label}</label>
      <input type={type} value={value} onChange={(e) => onChange(e.target.value)} placeholder={placeholder} className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" />
    </div>
  )
}
