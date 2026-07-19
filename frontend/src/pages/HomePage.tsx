import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { Heart, Users, Globe, HandHeart, ArrowRight, Play, ArrowLeft, ArrowRight as ArrowRightIcon } from 'lucide-react'
import api from '@/services/api'
import { ProgramCard, ProgramCardSkeleton } from '@/components/ProgramCard'

interface Program {
  id: string
  nama: string
  deskripsi: string
  gambar?: string
  target_donasi: number
  total_terkumpul: number
  kategori_id?: string
  kategori_nama?: string
  is_prioritas: boolean
  is_urgent: boolean
  is_verified: boolean
}

interface Stats {
  total_program_aktif: number
  total_penerima: number
  total_donatur_unik: number
}

export default function HomePage() {
  const navigate = useNavigate()
  const [prioritas, setPrioritas] = useState<Program[]>([])
  const [terbaru, setTerbaru] = useState<Program[]>([])
  const [stats, setStats] = useState<Stats | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    async function fetchData() {
      try {
        const [pRes, tRes, sRes] = await Promise.all([
          api.get('/programs/prioritas'),
          api.get('/programs/terbaru?limit=8'),
          api.get('/programs/stats'),
        ])
        setPrioritas(pRes.data)
        setTerbaru(tRes.data)
        setStats(sRes.data)
      } catch (err) {
        console.error('Failed to load data:', err)
      } finally {
        setLoading(false)
      }
    }
    fetchData()
  }, [])

  const statsItems = stats ? [
    { icon: Globe, number: '6', label: 'Negara Program', sub: 'Jangkauan Global' },
    { icon: Users, number: stats.total_penerima, label: 'Penerima Manfaat', sub: 'Kehidupan Tersentuh' },
    { icon: HandHeart, number: stats.total_program_aktif, label: 'Program Aktif', sub: 'Aksi Berkelanjutan' },
    { icon: Heart, number: stats.total_donatur_unik, label: 'Donatur Tergabung', sub: 'Komunitas Tumbuh' },
  ] : []

  return (
    <div>
      {/* Hero Section */}
      <section className="bg-gradient-to-b from-cream to-white py-16 md:py-24">
        <div className="container-custom text-center">
          <h1 className="text-4xl md:text-6xl font-extrabold text-deep mb-6 leading-tight">
            Platform Kebaikan<br />
            <span className="text-primary">Transparan & Akuntabel</span>
          </h1>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            Donasi Anda 100% tersalurkan tanpa potongan. Setiap transaksi tercatat transparan
            dan dapat dilacak kapan saja.
          </p>
          <div className="flex flex-wrap gap-4 justify-center">
            <button onClick={() => navigate('/transparansi')} className="btn-primary text-lg px-8 py-3.5">
              <Heart size={20} className="inline mr-2" />
              Mulai Donasi
            </button>
            <button onClick={() => navigate('/relawan')} className="btn-outline text-lg px-8 py-3.5">
              <Users size={20} className="inline mr-2" />
              Jadi Relawan
            </button>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      {statsItems.length > 0 && (
        <section className="py-12 bg-white">
          <div className="container-custom">
            <h2 className="section-title mb-2">Dampak Nyata Kami</h2>
            <p className="section-subtitle mb-10">Setiap angka adalah cerita, setiap statistik adalah kehidupan yang telah Anda sentuh.</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
              {statsItems.map((stat, i) => (
                <div key={i} className="card p-6 text-center hover:shadow-md transition-shadow">
                  <stat.icon className="w-10 h-10 text-primary mx-auto mb-3" />
                  <div className="text-2xl md:text-3xl font-extrabold text-deep">
                    {typeof stat.number === 'number' ? stat.number.toLocaleString('id-ID') : stat.number}
                  </div>
                  <div className="font-semibold text-gray-700 text-sm">{stat.label}</div>
                  <div className="text-xs text-gray-400 mt-1">{stat.sub}</div>
                </div>
              ))}
            </div>
          </div>
        </section>
      )}

      {/* Program Prioritas */}
      <section className="py-16 bg-white">
        <div className="container-custom">
          <h2 className="section-title mb-2"># Program Prioritas</h2>
          <p className="section-subtitle mb-8">Bergabunglah dalam Aksi Cepat! Setiap Donasi Memberi Harapan Baru</p>

          {loading ? (
            <div className="grid md:grid-cols-3 gap-6">
              {[1, 2, 3].map((i) => <ProgramCardSkeleton key={i} />)}
            </div>
          ) : prioritas.length > 0 ? (
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
              {prioritas.map((p) => (
                <ProgramCard key={p.id} {...p} onDonate={(id) => navigate(`/donasi/${id}`)} />
              ))}
            </div>
          ) : (
            <p className="text-center text-gray-400">Belum ada program prioritas.</p>
          )}
        </div>
      </section>

      {/* Program Terbaru */}
      <section className="py-16 bg-cream">
        <div className="container-custom">
          <h2 className="section-title mb-2"># Program Terbaru</h2>
          <p className="section-subtitle mb-8">Satu Langkah Lebih Dekat, Donasi Sekarang untuk Kampanye Terbaru Kami</p>

          {loading ? (
            <div className="grid md:grid-cols-4 gap-6">
              {[1, 2, 3, 4].map((i) => <ProgramCardSkeleton key={i} />)}
            </div>
          ) : (
            <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {terbaru.map((p) => (
                <ProgramCard key={p.id} {...p} onDonate={(id) => navigate(`/donasi/${id}`)} />
              ))}
            </div>
          )}

          <div className="text-center mt-8">
            <button onClick={() => navigate('/transparansi')} className="text-primary font-bold hover:underline">
              Lihat Semua Program <ArrowRight size={16} className="inline" />
            </button>
          </div>
        </div>
      </section>

      {/* Volunteer CTA */}
      <section className="py-20 bg-deep text-white">
        <div className="container-custom text-center">
          <h2 className="text-3xl md:text-4xl font-extrabold mb-4">
            Siap Menjadi Bagian dari Perubahan?
          </h2>
          <p className="text-gray-300 mb-8 max-w-xl mx-auto">
            Tidak semua bisa berdonasi, tapi semua bisa peduli. Laporkan mereka yang membutuhkan, atau terjun langsung sebagai relawan.
          </p>
          <div className="flex flex-wrap gap-4 justify-center">
            <button onClick={() => navigate('/relawan')} className="btn-gold text-lg px-8 py-3.5">
              <Users size={20} className="inline mr-2" />
              Jadi Relawan
            </button>
            <button onClick={() => navigate('/kirim-data')} className="border-2 border-white text-white text-lg px-8 py-3.5 rounded-full font-bold hover:bg-white hover:text-deep transition-all">
              Kirim Data Penerima
            </button>
          </div>
        </div>
      </section>
    </div>
  )
}
