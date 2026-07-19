import { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'
import { Shield, ArrowDown, ArrowUp, Search } from 'lucide-react'
import api from '@/services/api'
import { formatRupiah } from '@/lib/utils'

interface LedgerRecord {
  type: string
  id: string
  tanggal: string
  jumlah: number
  nama?: string
  keterangan?: string
  hash: string
  prev_hash: string
}

export default function TransparansiPage() {
  const { programId } = useParams<{ programId: string }>()
  const [records, setRecords] = useState<LedgerRecord[]>([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    if (programId) {
      api.get(`/programs/${programId}/ledger`)
        .then((res) => setRecords(res.data.records))
        .catch(console.error)
        .finally(() => setLoading(false))
    } else {
      setLoading(false)
    }
  }, [programId])

  return (
    <div className="container-custom py-8 md:py-12">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-10">
          <Shield size={48} className="text-primary mx-auto mb-4" />
          <h1 className="text-3xl md:text-4xl font-extrabold text-deep mb-3">Transparansi Dana</h1>
          <p className="text-gray-600 max-w-xl mx-auto">
            Setiap donasi dan penyaluran dana tercatat transparan.
            Seluruh transaksi dapat dilacak dan diverifikasi.
          </p>
        </div>

        {programId && (
          <>
            <h2 className="text-xl font-bold text-deep mb-6">Ledger Transaksi</h2>
            {loading ? (
              <div className="space-y-4">
                {[1, 2, 3].map((i) => (
                  <div key={i} className="animate-pulse h-20 bg-gray-100 rounded-xl" />
                ))}
              </div>
            ) : records.length > 0 ? (
              <div className="space-y-3">
                {records.map((r, i) => (
                  <div key={i} className="card p-4 flex items-center gap-4">
                    <div className={`w-10 h-10 rounded-full flex items-center justify-center ${
                      r.type === 'donasi' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600'
                    }`}>
                      {r.type === 'donasi' ? <ArrowDown size={18} /> : <ArrowUp size={18} />}
                    </div>
                    <div className="flex-1 min-w-0">
                      <div className="font-semibold text-deep">
                        {r.type === 'donasi' ? (r.nama || 'Anonim') : r.keterangan || 'Penyaluran Dana'}
                      </div>
                      <div className="text-xs text-gray-400">
                        {new Date(r.tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
                      </div>
                      <div className="text-xs text-gray-300 truncate font-mono mt-0.5" title={r.hash}>
                        🔗 {r.hash?.slice(0, 16)}...
                      </div>
                    </div>
                    <div className={`font-bold text-right ${r.type === 'donasi' ? 'text-green-600' : 'text-red-500'}`}>
                      {r.type === 'donasi' ? '+' : '-'}{formatRupiah(r.jumlah)}
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-center text-gray-400">Belum ada transaksi tercatat.</p>
            )}
          </>
        )}

        {/* Public Ledger Explanation */}
        <div className="mt-12 bg-deep text-white rounded-2xl p-8">
          <h2 className="text-2xl font-bold mb-4">🔗 Public Ledger — Transparansi Maksimal</h2>
          <p className="text-gray-300 mb-4">
            Setiap transaksi memiliki hash kriptografis yang terhubung ke transaksi sebelumnya,
            menciptakan rantai yang tidak dapat dimanipulasi. Ini memberikan transparansi
            tingkat tinggi tanpa kompleksitas blockchain.
          </p>
          <div className="grid sm:grid-cols-3 gap-4 text-center">
            <div className="bg-white/10 rounded-xl p-4">
              <div className="text-2xl font-extrabold text-gold">100%</div>
              <div className="text-sm text-gray-300">Transparan</div>
            </div>
            <div className="bg-white/10 rounded-xl p-4">
              <div className="text-2xl font-extrabold text-gold">SHA-256</div>
              <div className="text-sm text-gray-300">Hash Kriptografis</div>
            </div>
            <div className="bg-white/10 rounded-xl p-4">
              <div className="text-2xl font-extrabold text-gold">Real-time</div>
              <div className="text-sm text-gray-300">Dapat Dilacak</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
