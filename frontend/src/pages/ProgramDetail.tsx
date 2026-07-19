import { useState, useEffect } from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import { Heart, MapPin, Calendar, Shield, Users } from 'lucide-react'
import api from '@/services/api'
import { formatRupiah, getProgressPercent } from '@/lib/utils'

interface Program {
  id: string
  nama: string
  deskripsi: string
  deskripsi_lengkap: string
  gambar?: string
  target_donasi: number
  total_terkumpul: number
  total_disalurkan: number
  jumlah_donatur: number
  kategori_nama?: string
  provinsi?: string
  lokasi?: string
  is_verified: boolean
  is_urgent: boolean
  created_at: string
  donatur: { nama: string; jumlah: number; tanggal: string }[]
}

export default function ProgramDetail() {
  const { id } = useParams<{ id: string }>()
  const navigate = useNavigate()
  const [program, setProgram] = useState<Program | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    if (!id) return
    api.get(`/programs/${id}`)
      .then((res) => setProgram(res.data))
      .catch(console.error)
      .finally(() => setLoading(false))
  }, [id])

  if (loading) {
    return (
      <div className="container-custom py-16 animate-pulse">
        <div className="h-8 bg-gray-200 rounded w-2/3 mb-4" />
        <div className="h-64 bg-gray-200 rounded-xl mb-6" />
        <div className="h-4 bg-gray-100 rounded w-full mb-2" />
        <div className="h-4 bg-gray-100 rounded w-3/4 mb-2" />
      </div>
    )
  }

  if (!program) {
    return (
      <div className="container-custom py-20 text-center">
        <h1 className="text-3xl font-extrabold text-deep mb-4">Program Tidak Ditemukan</h1>
        <button onClick={() => navigate('/')} className="btn-primary">Kembali ke Beranda</button>
      </div>
    )
  }

  const progress = getProgressPercent(program.total_terkumpul, program.target_donasi)
  const imgSrc = program.gambar || 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=800&q=80'

  return (
    <div className="container-custom py-8 md:py-12">
      <div className="grid lg:grid-cols-3 gap-8">
        {/* Main Content */}
        <div className="lg:col-span-2">
          <img src={imgSrc} alt={program.nama} className="w-full h-64 md:h-96 object-cover rounded-2xl mb-6" />

          <div className="flex flex-wrap gap-2 mb-4">
            {program.is_urgent && (
              <span className="bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full">🔴 Urgent</span>
            )}
            {program.is_verified && (
              <span className="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                <Shield size={12} /> Terverifikasi
              </span>
            )}
            {program.kategori_nama && (
              <span className="bg-deep/10 text-deep text-xs font-bold px-3 py-1 rounded-full">{program.kategori_nama}</span>
            )}
          </div>

          <h1 className="text-3xl md:text-4xl font-extrabold text-deep mb-4">{program.nama}</h1>

          <div className="flex flex-wrap gap-4 text-sm text-gray-500 mb-6">
            {program.provinsi && (
              <span className="flex items-center gap-1"><MapPin size={14} /> {program.provinsi}</span>
            )}
            {program.lokasi && (
              <span className="flex items-center gap-1"><MapPin size={14} /> {program.lokasi}</span>
            )}
            <span className="flex items-center gap-1"><Users size={14} /> {program.jumlah_donatur} Donatur</span>
            <span className="flex items-center gap-1"><Calendar size={14} /> {new Date(program.created_at).toLocaleDateString('id-ID')}</span>
          </div>

          <div className="prose max-w-none text-gray-700" dangerouslySetInnerHTML={{ __html: program.deskripsi_lengkap || program.deskripsi }} />

          {/* Donatur List */}
          {program.donatur && program.donatur.length > 0 && (
            <div className="mt-8">
              <h3 className="text-xl font-bold text-deep mb-4">Donatur ({program.donatur.length})</h3>
              <div className="space-y-3 max-h-96 overflow-y-auto">
                {program.donatur.map((d, i) => (
                  <div key={i} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                      <div className="font-semibold text-deep">{d.nama}</div>
                      <div className="text-xs text-gray-400">{new Date(d.tanggal).toLocaleDateString('id-ID')}</div>
                    </div>
                    <div className="font-bold text-primary">{formatRupiah(d.jumlah)}</div>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>

        {/* Sidebar */}
        <div className="lg:col-span-1">
          <div className="card p-6 sticky top-24">
            <div className="mb-4">
              <div className="text-3xl font-extrabold text-primary mb-1">{formatRupiah(program.total_terkumpul)}</div>
              <div className="text-sm text-gray-500">terkumpul dari {formatRupiah(program.target_donasi)}</div>
            </div>

            <div className="w-full bg-gray-200 rounded-full h-3 mb-4">
              <div className="bg-primary h-3 rounded-full" style={{ width: `${progress}%` }} />
            </div>
            <div className="text-sm text-gray-500 mb-6">{progress}% tercapai</div>

            <div className="grid grid-cols-2 gap-3 mb-6 text-center text-sm">
              <div className="bg-gray-50 rounded-lg p-3">
                <div className="font-extrabold text-deep">{formatRupiah(program.total_disalurkan)}</div>
                <div className="text-gray-400 text-xs">Tersalurkan</div>
              </div>
              <div className="bg-gray-50 rounded-lg p-3">
                <div className="font-extrabold text-deep">{program.jumlah_donatur}</div>
                <div className="text-gray-400 text-xs">Donatur</div>
              </div>
            </div>

            <button
              onClick={() => navigate(`/donasi/${program.id}`)}
              className="w-full btn-primary text-lg py-3.5"
            >
              <Heart size={20} className="inline mr-2" />
              Donasi Sekarang
            </button>

            <button
              onClick={() => navigate(`/transparansi/${program.id}`)}
              className="w-full mt-3 text-primary font-semibold text-sm hover:underline"
            >
              Lihat Transparansi Dana →
            </button>
          </div>
        </div>
      </div>
    </div>
  )
}
