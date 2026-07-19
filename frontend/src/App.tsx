import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Navbar from './components/Navbar'
import Footer from './components/Footer'
import HomePage from './pages/HomePage'
import ProgramDetail from './pages/ProgramDetail'
import DonasiPage from './pages/DonasiPage'
import RelawanPage from './pages/RelawanPage'
import KirimDataPage from './pages/KirimDataPage'
import TransparansiPage from './pages/TransparansiPage'
import AboutPage from './pages/AboutPage'
import AdminLogin from './pages/admin/AdminLogin'
import AdminDashboard from './pages/admin/AdminDashboard'

export default function App() {
  return (
    <BrowserRouter>
      <div className="flex flex-col min-h-screen">
        <Navbar />
        <main className="flex-1">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/program/:id" element={<ProgramDetail />} />
            <Route path="/donasi/:programId" element={<DonasiPage />} />
            <Route path="/donasi/sukses" element={<DonasiSukses />} />
            <Route path="/relawan" element={<RelawanPage />} />
            <Route path="/kirim-data" element={<KirimDataPage />} />
            <Route path="/transparansi" element={<TransparansiPage />} />
            <Route path="/transparansi/:programId" element={<TransparansiPage />} />
            <Route path="/tentang" element={<AboutPage />} />
            <Route path="/admin/login" element={<AdminLogin />} />
            <Route path="/admin/*" element={<AdminDashboard />} />
          </Routes>
        </main>
        <Footer />
      </div>
    </BrowserRouter>
  )
}

function DonasiSukses() {
  return (
    <div className="container-custom py-20 text-center">
      <div className="text-6xl mb-4">✅</div>
      <h1 className="text-3xl font-extrabold text-deep mb-4">Terima Kasih!</h1>
      <p className="text-gray-600 mb-8">
        Donasi Anda sedang diproses. Bukti donasi akan dikirim ke email Anda.
      </p>
      <a href="/" className="btn-primary inline-block">Kembali ke Beranda</a>
    </div>
  )
}
