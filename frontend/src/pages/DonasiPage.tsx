import { useState, useEffect } from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import { Heart, Shield } from 'lucide-react'
import api from '@/services/api'
import { formatRupiah } from '@/lib/utils'

interface Program {
  id: string
  nama: string
  target_donasi: number
  total_terkumpul: number
  is_verified: boolean
}

const NOMINAL_OPTIONS = [10000, 25000, 50000, 100000, 250000, 500000, 1000000]

declare global {
  interface Window {
    snap?: {
      pay: (token: string, options?: object) => void
    }
  }
}

export default function DonasiPage() {
  const { programId } = useParams<{ programId: string }>()
  const navigate = useNavigate()
  const [program, setProgram] = useState<Program | null>(null)
  const [nama, setNama] = useState('')
  const [email, setEmail] = useState('')
  const [noHp, setNoHp] = useState('')
  const [jumlah, setJumlah] = useState(50000)
  const [customJumlah, setCustomJumlah] = useState('')
  const [isAnonim, setIsAnonim] = useState(false)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')

  useEffect(() => {
    if (!programId) return
    api.get(`/programs/${programId}`)
      .then((res) => setProgram(res.data))
      .catch(console.error)

    // Load Midtrans Snap script
    const script = document.createElement('script')
    script.src = 'https://app.sandbox.midtrans.com/snap/snap.js'
    script.setAttribute('data-client-key', import.meta.env.VITE_MIDTRANS_CLIENT_KEY || 'SB-Mid-client-xxxxxxxx')
    document.body.appendChild(script)
    return () => { document.body.removeChild(script) }
  }, [programId])

  const finalJumlah = customJumlah ? parseInt(customJumlah) : jumlah

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    setLoading(true)

    if (!nama.trim() && !isAnonim) {
      setError('Silakan isi nama atau pilih donasi anonim')
      setLoading(false)
      return
    }

    try {
      const res = await api.post('/donations', {
        program_id: programId,
        jumlah: finalJumlah,
        nama: isAnonim ? 'Anonim' : nama,
        email: email || undefined,
        no_hp: noHp || undefined,
        is_anonim: isAnonim,
      })

      const { token } = res.data

      if (token && window.snap) {
        window.snap.pay(token, {
          onSuccess: () => navigate('/donasi/sukses'),
          onPending: () => navigate('/donasi/sukses'),
          onError: () => setError('Pembayaran gagal. Silakan coba lagi.'),
          onClose: () => setError('Pembayaran dibatalkan.'),
        })
      } else {
        navigate('/donasi/sukses')
      }
    } catch (err: any) {
      setError(err.response?.data?.detail || 'Gagal memproses donasi')
    } finally {
      setLoading(false)
    }
  }

  if (!program) {
    return (
      <div className="container-custom py-20 text-center">
        <div className="animate-pulse space-y-4 max-w-md mx-auto">
          <div className="h-8 bg-gray-200 rounded w-1/2 mx-auto" />
          <div className="h-4 bg-gray-100 rounded w-3/4 mx-auto" />
        </div>
      </div>
    )
  }

  return (
    <div className="container-custom py-8 md:py-12">
      <div className="max-w-lg mx-auto">
        <h1 className="text-2xl md:text-3xl font-extrabold text-deep mb-2">Donasi</h1>
        <p className="text-gray-500 mb-6">{program.nama}</p>

        {program.is_verified && (
          <div className="flex items-center gap-2 text-green-600 text-sm mb-6 bg-green-50 p-3 rounded-lg">
            <Shield size={16} /> Program ini sudah terverifikasi
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-5">
          {/* Nama */}
          <div>
            <label className="block text-sm font-semibold text-deep mb-1">Nama *</label>
            <input
              type="text"
              value={nama}
              onChange={(e) => setNama(e.target.value)}
              disabled={isAnonim}
              placeholder="Nama lengkap Anda"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none disabled:bg-gray-100 disabled:text-gray-400"
            />
            <label className="flex items-center gap-2 mt-2 text-sm text-gray-500 cursor-pointer">
              <input type="checkbox" checked={isAnonim} onChange={(e) => setIsAnonim(e.target.checked)} />
              Donasi sebagai Anonim (Hamba Allah)
            </label>
          </div>

          {/* Email */}
          <div>
            <label className="block text-sm font-semibold text-deep mb-1">Email</label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="email@anda.com"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
            />
            <p className="text-xs text-gray-400 mt-1">Bukti donasi akan dikirim ke email ini</p>
          </div>

          {/* Nomor HP */}
          <div>
            <label className="block text-sm font-semibold text-deep mb-1">Nomor HP</label>
            <input
              type="tel"
              value={noHp}
              onChange={(e) => setNoHp(e.target.value)}
              placeholder="0812-3456-7890"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
            />
          </div>

          {/* Nominal */}
          <div>
            <label className="block text-sm font-semibold text-deep mb-2">Nominal Donasi *</label>
            <div className="grid grid-cols-4 gap-2 mb-3">
              {NOMINAL_OPTIONS.map((n) => (
                <button
                  key={n}
                  type="button"
                  onClick={() => { setJumlah(n); setCustomJumlah('') }}
                  className={`py-2.5 rounded-lg text-sm font-semibold border transition-all ${
                    jumlah === n && !customJumlah
                      ? 'bg-primary text-white border-primary'
                      : 'border-gray-300 text-deep hover:border-primary'
                  }`}
                >
                  {n >= 1000000 ? `${n / 1000000}jt` : n >= 1000 ? `${n / 1000}rb` : n}
                </button>
              ))}
            </div>
            <input
              type="number"
              value={customJumlah}
              onChange={(e) => { setCustomJumlah(e.target.value); setJumlah(0) }}
              placeholder="Atau masukkan nominal sendiri"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
            />
          </div>

          {/* Total */}
          <div className="bg-gray-50 rounded-xl p-4">
            <div className="flex justify-between items-center">
              <span className="text-gray-600">Total Donasi</span>
              <span className="text-2xl font-extrabold text-primary">{formatRupiah(finalJumlah || 0)}</span>
            </div>
            <p className="text-xs text-gray-400 mt-1">Donasi 100% tersalurkan tanpa potongan</p>
          </div>

          {error && (
            <div className="bg-red-50 text-red-600 p-3 rounded-lg text-sm">{error}</div>
          )}

          <button
            type="submit"
            disabled={loading || (!finalJumlah)}
            className="w-full btn-primary text-lg py-4 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {loading ? (
              <span className="flex items-center justify-center gap-2">
                <span className="animate-spin w-5 h-5 border-2 border-white border-t-transparent rounded-full" />
                Memproses...
              </span>
            ) : (
              <>
                <Heart size={20} className="inline mr-2" />
                Donasi Sekarang
              </>
            )}
          </button>
        </form>
      </div>
    </div>
  )
}
