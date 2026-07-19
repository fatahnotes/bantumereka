import { useState, useEffect } from 'react'
import { Heart, Shield, Award } from 'lucide-react'
import api from '@/services/api'

interface TeamMember {
  id: string
  nama: string
  jabatan: string
  bio?: string
  foto?: string
}

interface Partner {
  id: string
  nama: string
  logo?: string
  website_url?: string
}

export default function AboutPage() {
  const [teams, setTeams] = useState<TeamMember[]>([])
  const [partners, setPartners] = useState<Partner[]>([])

  useEffect(() => {
    Promise.all([
      api.get('/admin/teams'),
      api.get('/admin/partners'),
    ]).then(([tRes, pRes]) => {
      setTeams(tRes.data)
      setPartners(pRes.data)
    }).catch(console.error)
  }, [])

  return (
    <div className="container-custom py-8 md:py-12">
      {/* Hero */}
      <section className="text-center mb-16">
        <Heart size={48} className="text-primary mx-auto mb-4" fill="#C62828" />
        <h1 className="text-4xl md:text-5xl font-extrabold text-deep mb-4">
          Tentang <span className="text-primary">Bantu Mereka</span>
        </h1>
        <p className="text-lg text-gray-600 max-w-2xl mx-auto">
          Platform donasi transparan yang menghubungkan kebaikan Anda dengan mereka yang membutuhkan.
          Donasi 100% tersalurkan tanpa potongan.
        </p>
      </section>

      {/* Visi Misi */}
      <section className="grid md:grid-cols-2 gap-8 mb-16">
        <div className="card p-8">
          <h3 className="text-xl font-bold text-deep mb-3">🎯 Visi</h3>
          <p className="text-gray-600">Ekosistem donasi modern, tepercaya, tanpa perantara, memberdayakan langsung penerima manfaat.</p>
        </div>
        <div className="card p-8">
          <h3 className="text-xl font-bold text-deep mb-3">🚀 Misi</h3>
          <ul className="space-y-2 text-gray-600">
            <li>• Menyalurkan 100% donasi ke penerima manfaat</li>
            <li>• Transparansi penuh setiap transaksi</li>
            <li>• Memberdayakan komunitas lokal</li>
            <li>• Teknologi untuk kebaikan sosial</li>
          </ul>
        </div>
      </section>

      {/* Legalitas */}
      <section className="bg-gray-50 rounded-2xl p-8 mb-16">
        <div className="flex items-center gap-4 mb-4">
          <Shield size={32} className="text-green-600" />
          <h2 className="text-2xl font-bold text-deep">Legalitas & Keamanan</h2>
        </div>
        <p className="text-gray-600 mb-4">
          Yayasan Bantu Mereka terdaftar resmi di Kementerian Hukum dan HAM RI. Seluruh transaksi
          tercatat dalam public ledger yang transparan dan dapat diaudit kapan saja.
        </p>
        <div className="flex items-center gap-2 text-green-600 font-semibold">
          <Award size={20} /> Terdaftar & Terverifikasi
        </div>
      </section>

      {/* Team */}
      {teams.length > 0 && (
        <section className="mb-16">
          <h2 className="section-title mb-2">Tim Kami</h2>
          <p className="section-subtitle mb-8">Dipimpin oleh para profesional yang berdedikasi untuk misi kemanusiaan.</p>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {teams.map((t) => (
              <div key={t.id} className="card p-6 text-center">
                <img
                  src={t.foto || 'https://via.placeholder.com/200x200?text=No+Photo'}
                  alt={t.nama}
                  className="w-24 h-24 rounded-full mx-auto mb-4 object-cover"
                />
                <h4 className="font-bold text-deep">{t.nama}</h4>
                <div className="text-sm text-primary font-semibold mb-2">{t.jabatan}</div>
                {t.bio && <p className="text-xs text-gray-500">{t.bio}</p>}
              </div>
            ))}
          </div>
        </section>
      )}

      {/* Partners */}
      {partners.length > 0 && (
        <section>
          <h2 className="section-title mb-2">Partner & Pendukung</h2>
          <p className="section-subtitle mb-8">Bersama kita bisa menjangkau lebih banyak yang membutuhkan.</p>
          <div className="flex flex-wrap justify-center gap-8 items-center">
            {partners.map((p) => (
              <a key={p.id} href={p.website_url || '#'} target="_blank" rel="noopener noreferrer" className="opacity-70 hover:opacity-100 transition-opacity">
                <img src={p.logo || 'https://via.placeholder.com/150x50?text=No+Logo'} alt={p.nama} className="h-12 object-contain" />
              </a>
            ))}
          </div>
        </section>
      )}
    </div>
  )
}
