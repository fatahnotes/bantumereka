import { useState, useEffect } from 'react'
import { Routes, Route, Link, useNavigate, useLocation } from 'react-router-dom'
import {
  LayoutDashboard, FolderOpen, Users, FileText, Heart,
  LogOut, Menu, X, Shield, ArrowLeft
} from 'lucide-react'
import api from '@/services/api'

interface DashboardStats {
  total_program: number
  total_program_aktif: number
  total_donasi: number
  total_donasi_berhasil: number
  total_relawan: number
  total_relawan_pending: number
  total_laporan: number
  total_laporan_pending: number
  total_donasi_amount?: { total: number }[]
}

export default function AdminDashboard() {
  const navigate = useNavigate()
  const location = useLocation()
  const [sidebarOpen, setSidebarOpen] = useState(true)
  const [user, setUser] = useState<any>(null)

  useEffect(() => {
    const token = localStorage.getItem('token')
    const storedUser = localStorage.getItem('user')
    if (!token) {
      navigate('/admin/login')
      return
    }
    if (storedUser) setUser(JSON.parse(storedUser))
  }, [navigate])

  function logout() {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    navigate('/admin/login')
  }

  const menuItems = [
    { to: '/admin', icon: LayoutDashboard, label: 'Dashboard', exact: true },
    { to: '/admin/programs', icon: FolderOpen, label: 'Program' },
    { to: '/admin/relawan', icon: Users, label: 'Relawan' },
    { to: '/admin/laporan', icon: FileText, label: 'Laporan' },
    { to: '/admin/donations', icon: Heart, label: 'Donasi' },
  ]

  return (
    <div className="flex min-h-screen bg-gray-50">
      {/* Sidebar */}
      <aside className={`${sidebarOpen ? 'w-64' : 'w-20'} bg-deep text-white transition-all duration-300 flex flex-col`}>
        <div className="p-4 flex items-center justify-between border-b border-white/10">
          {sidebarOpen && <span className="font-extrabold text-gold">BantuMereka</span>}
          <button onClick={() => setSidebarOpen(!sidebarOpen)} className="text-white/70 hover:text-white">
            {sidebarOpen ? <X size={20} /> : <Menu size={20} />}
          </button>
        </div>

        <nav className="flex-1 p-3 space-y-1">
          {menuItems.map((item) => {
            const active = item.exact ? location.pathname === item.to : location.pathname.startsWith(item.to)
            return (
              <Link
                key={item.to}
                to={item.to}
                className={`flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors ${
                  active ? 'bg-primary text-white' : 'text-white/70 hover:bg-white/10'
                }`}
              >
                <item.icon size={18} />
                {sidebarOpen && <span>{item.label}</span>}
              </Link>
            )
          })}
        </nav>

        <div className="p-3 border-t border-white/10">
          <Link to="/" className="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/70 hover:bg-white/10 mb-1">
            <ArrowLeft size={18} />
            {sidebarOpen && 'Ke Website'}
          </Link>
          <button onClick={logout} className="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-400 hover:bg-white/10 w-full">
            <LogOut size={18} />
            {sidebarOpen && 'Logout'}
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <div className="flex-1 overflow-auto">
        <header className="bg-white border-b border-gray-200 p-4 flex justify-between items-center">
          <h1 className="text-xl font-bold text-deep">Admin Panel</h1>
          {user && <span className="text-sm text-gray-500">{user.nama}</span>}
        </header>

        <div className="p-6">
          <Routes>
            <Route index element={<DashboardOverview />} />
            <Route path="programs" element={<ProgramsManager />} />
            <Route path="relawan" element={<RelawanManager />} />
            <Route path="laporan" element={<LaporanManager />} />
            <Route path="donations" element={<DonationsManager />} />
          </Routes>
        </div>
      </div>
    </div>
  )
}

// ── Dashboard Overview ────────────────────

function DashboardOverview() {
  const [stats, setStats] = useState<DashboardStats | null>(null)

  useEffect(() => {
    api.get('/admin/dashboard').then((res) => setStats(res.data)).catch(console.error)
  }, [])

  if (!stats) return <div className="animate-pulse space-y-4">{/* skeleton */}</div>

  const totalAmount = stats.total_donasi_amount?.[0]?.total || 0
  const cards = [
    { label: 'Program Aktif', value: stats.total_program_aktif, icon: FolderOpen, color: 'text-blue-600 bg-blue-50' },
    { label: 'Total Donasi', value: stats.total_donasi_berhasil, icon: Heart, color: 'text-green-600 bg-green-50' },
    { label: 'Relawan Pending', value: stats.total_relawan_pending, icon: Users, color: 'text-orange-600 bg-orange-50' },
    { label: 'Laporan Pending', value: stats.total_laporan_pending, icon: FileText, color: 'text-purple-600 bg-purple-50' },
  ]

  return (
    <div>
      <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {cards.map((card, i) => (
          <div key={i} className="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div className="flex items-center gap-3 mb-3">
              <div className={`p-2 rounded-lg ${card.color}`}>
                <card.icon size={20} />
              </div>
            </div>
            <div className="text-2xl font-extrabold text-deep">{card.value}</div>
            <div className="text-sm text-gray-500">{card.label}</div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <h2 className="text-lg font-bold text-deep mb-4">Total Donasi Masuk</h2>
        <div className="text-3xl font-extrabold text-primary">Rp {totalAmount.toLocaleString('id-ID')}</div>
      </div>
    </div>
  )
}

// ── Programs Manager ──────────────────────

function ProgramsManager() {
  const [programs, setPrograms] = useState<any[]>([])
  useEffect(() => {
    api.get('/programs?limit=50').then((res) => setPrograms(res.data.data)).catch(console.error)
  }, [])

  return (
    <div>
      <h2 className="text-xl font-bold text-deep mb-4">Kelola Program</h2>
      <div className="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table className="w-full">
          <thead className="bg-gray-50">
            <tr>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Nama</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Target</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Terkumpul</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Status</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100">
            {programs.map((p) => (
              <tr key={p.id} className="hover:bg-gray-50">
                <td className="p-3 text-sm font-medium">{p.nama}</td>
                <td className="p-3 text-sm">Rp {p.target_donasi?.toLocaleString('id-ID')}</td>
                <td className="p-3 text-sm">Rp {p.total_terkumpul?.toLocaleString('id-ID')}</td>
                <td className="p-3">
                  <span className={`text-xs font-bold px-2 py-0.5 rounded-full ${
                    p.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400'
                  }`}>
                    {p.is_active ? 'Aktif' : 'Nonaktif'}
                  </span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

// ── Relawan Manager ───────────────────────

function RelawanManager() {
  const [relawan, setRelawan] = useState<any[]>([])
  const [page, setPage] = useState(1)
  const [total, setTotal] = useState(0)

  useEffect(() => {
    api.get(`/admin/relawan?page=${page}&limit=20`).then((res) => {
      setRelawan(res.data.data)
      setTotal(res.data.total)
    }).catch(console.error)
  }, [page])

  async function updateStatus(id: string, status: string) {
    const fd = new FormData()
    fd.append('admin_status', status)
    await api.put(`/relawan/${id}/status`, fd)
    setRelawan((prev) => prev.map((r) => r.id === id ? { ...r, admin_status: status } : r))
  }

  return (
    <div>
      <h2 className="text-xl font-bold text-deep mb-4">Kelola Relawan ({total})</h2>
      <div className="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table className="w-full">
          <thead className="bg-gray-50">
            <tr>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Nama</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Email</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Provinsi</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Status</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100">
            {relawan.map((r) => (
              <tr key={r.id} className="hover:bg-gray-50">
                <td className="p-3 text-sm font-medium">{r.nama_lengkap}</td>
                <td className="p-3 text-sm text-gray-500">{r.email}</td>
                <td className="p-3 text-sm">{r.provinsi}</td>
                <td className="p-3">
                  <span className={`text-xs font-bold px-2 py-0.5 rounded-full ${
                    r.admin_status === 'approve' ? 'bg-green-100 text-green-700' :
                    r.admin_status === 'tolak' ? 'bg-red-100 text-red-600' :
                    'bg-yellow-100 text-yellow-700'
                  }`}>{r.admin_status}</span>
                </td>
                <td className="p-3">
                  <div className="flex gap-1">
                    <button onClick={() => updateStatus(r.id, 'approve')} className="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Approve</button>
                    <button onClick={() => updateStatus(r.id, 'tolak')} className="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">Tolak</button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

// ── Laporan Manager ───────────────────────

function LaporanManager() {
  const [laporan, setLaporan] = useState<any[]>([])
  useEffect(() => {
    api.get('/admin/laporan?limit=50').then((res) => setLaporan(res.data.data)).catch(console.error)
  }, [])

  async function updateStatus(id: string, status: string) {
    const fd = new FormData()
    fd.append('admin_status', status)
    await api.put(`/laporan/${id}/status`, fd)
    setLaporan((prev) => prev.map((l) => l.id === id ? { ...l, admin_status: status } : l))
  }

  return (
    <div>
      <h2 className="text-xl font-bold text-deep mb-4">Kelola Laporan</h2>
      <div className="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table className="w-full">
          <thead className="bg-gray-50">
            <tr>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Pelapor</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Sasaran</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Urgensi</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Status</th>
              <th className="text-left p-3 text-sm font-semibold text-gray-600">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100">
            {laporan.map((l) => (
              <tr key={l.id} className="hover:bg-gray-50">
                <td className="p-3 text-sm font-medium">{l.nama_pelapor}</td>
                <td className="p-3 text-sm">{l.nama_sasaran || '-'}</td>
                <td className="p-3 text-sm">{l.tingkat_urgensi}/10</td>
                <td className="p-3">
                  <span className={`text-xs font-bold px-2 py-0.5 rounded-full ${
                    l.admin_status === 'approve' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'
                  }`}>{l.admin_status}</span>
                </td>
                <td className="p-3">
                  <div className="flex gap-1">
                    <button onClick={() => updateStatus(l.id, 'approve')} className="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Approve</button>
                    <button onClick={() => updateStatus(l.id, 'tolak')} className="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">Tolak</button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

// ── Donations Manager ─────────────────────

function DonationsManager() {
  const [donations, setDonations] = useState<any[]>([])
  const [csv, setCsv] = useState('')

  useEffect(() => {
    api.get('/admin/export/donasi').then((res) => {
      setCsv(res.data.csv)
    }).catch(console.error)
  }, [])

  return (
    <div>
      <h2 className="text-xl font-bold text-deep mb-4">Data Donasi</h2>
      <div className="bg-white rounded-xl border border-gray-100 p-6">
        <button
          onClick={() => {
            const blob = new Blob([csv], { type: 'text/csv' })
            const url = URL.createObjectURL(blob)
            const a = document.createElement('a')
            a.href = url
            a.download = 'donasi_bantumereka.csv'
            a.click()
          }}
          className="btn-primary mb-4"
        >
          📥 Export CSV
        </button>

        {csv ? (
          <pre className="bg-gray-50 p-4 rounded-lg text-xs overflow-x-auto max-h-96">
            {csv.slice(0, 5000)}
            {csv.length > 5000 && '\n... (data lengkap di file export)'}
          </pre>
        ) : (
          <p className="text-gray-400">Memuat data...</p>
        )}
      </div>
    </div>
  )
}
