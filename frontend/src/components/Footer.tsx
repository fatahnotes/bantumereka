import { Link } from 'react-router-dom'
import { Heart } from 'lucide-react'

export default function Footer() {
  return (
    <footer className="bg-deep text-white py-10 mt-auto">
      <div className="container-custom">
        <div className="grid md:grid-cols-3 gap-8 mb-8">
          <div>
            <div className="flex items-center gap-2 text-xl font-extrabold mb-3">
              <Heart size={20} className="text-gold" fill="#D4AF37" />
              Bantu Mereka
            </div>
            <p className="text-sm text-gray-300 leading-relaxed">
              Platform donasi transparan. Donasi 100% tersalurkan tanpa potongan.
              Operasional dari bisnis mandiri.
            </p>
          </div>
          <div>
            <h4 className="font-bold mb-3">Tautan</h4>
            <div className="space-y-2 text-sm text-gray-300">
              <Link to="/" className="block hover:text-gold">Beranda</Link>
              <Link to="/tentang" className="block hover:text-gold">Tentang Kami</Link>
              <Link to="/transparansi" className="block hover:text-gold">Transparansi</Link>
              <Link to="/relawan" className="block hover:text-gold">Jadi Relawan</Link>
              <Link to="/kirim-data" className="block hover:text-gold">Kirim Data</Link>
            </div>
          </div>
          <div>
            <h4 className="font-bold mb-3">Kontak</h4>
            <p className="text-sm text-gray-300">
              Email: info@bantumereka.org<br />
              Telepon: +62 812-3456-7890<br />
              Jakarta, Indonesia
            </p>
          </div>
        </div>
        <div className="border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
          &copy; {new Date().getFullYear()} Bantu Mereka Foundation. Platform donasi transparan Indonesia.
        </div>
      </div>
    </footer>
  )
}
