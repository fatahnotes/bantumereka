import { useState } from 'react'
import { Link, useLocation } from 'react-router-dom'
import { Menu, X, Heart } from 'lucide-react'

const NAV_LINKS = [
  { to: '/', label: 'Beranda' },
  { to: '/tentang', label: 'Tentang' },
  { to: '/transparansi', label: 'Transparansi' },
  { to: '/relawan', label: 'Relawan' },
  { to: '/kirim-data', label: 'Kirim Data' },
]

export default function Navbar() {
  const [open, setOpen] = useState(false)
  const location = useLocation()

  // Hide on admin pages
  if (location.pathname.startsWith('/admin')) {
    return null
  }

  return (
    <nav className="bg-white/97 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-gray-100">
      <div className="container-custom flex items-center justify-between h-16 md:h-18">
        {/* Logo */}
        <Link to="/" className="flex items-center gap-2 text-xl font-extrabold text-deep no-underline">
          <Heart className="text-primary" size={24} fill="#C62828" />
          <span>Bantu Mereka</span>
        </Link>

        {/* Desktop Nav */}
        <div className="hidden md:flex items-center gap-6">
          {NAV_LINKS.map((link) => (
            <Link
              key={link.to}
              to={link.to}
              className={`text-sm font-semibold transition-colors hover:text-primary ${
                location.pathname === link.to ? 'text-primary' : 'text-deep'
              }`}
            >
              {link.label}
            </Link>
          ))}
        </div>

        {/* CTA */}
        <div className="hidden md:flex items-center gap-3">
          <Link to="/relawan" className="btn-gold text-sm px-4 py-2">
            <Heart size={16} className="inline mr-1" />
            Jadi Relawan
          </Link>
        </div>

        {/* Mobile Toggle */}
        <button
          className="md:hidden text-deep"
          onClick={() => setOpen(!open)}
          aria-label="Toggle menu"
        >
          {open ? <X size={24} /> : <Menu size={24} />}
        </button>
      </div>

      {/* Mobile Menu */}
      {open && (
        <div className="md:hidden bg-white border-t border-gray-100 px-4 py-4 space-y-3">
          {NAV_LINKS.map((link) => (
            <Link
              key={link.to}
              to={link.to}
              onClick={() => setOpen(false)}
              className="block py-2 font-semibold text-deep hover:text-primary"
            >
              {link.label}
            </Link>
          ))}
          <Link
            to="/relawan"
            onClick={() => setOpen(false)}
            className="btn-gold block text-center"
          >
            Jadi Relawan
          </Link>
        </div>
      )}
    </nav>
  )
}
