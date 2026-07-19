import { formatRupiah, getProgressPercent } from '@/lib/utils'

interface ProgramCardProps {
  id: string
  nama: string
  deskripsi: string
  gambar?: string
  target_donasi: number
  total_terkumpul: number
  kategori_nama?: string
  is_urgent?: boolean
  is_verified?: boolean
  onDonate?: (id: string) => void
}

export function ProgramCard({
  id,
  nama,
  deskripsi,
  gambar,
  target_donasi,
  total_terkumpul,
  kategori_nama,
  is_urgent,
  is_verified,
  onDonate,
}: ProgramCardProps) {
  const progress = getProgressPercent(total_terkumpul, target_donasi)
  const imgSrc = gambar || 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80'

  return (
    <div className="card group hover:shadow-lg transition-all duration-300">
      <div className="relative overflow-hidden">
        <img
          src={imgSrc}
          alt={nama}
          className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
        />
        {is_urgent && (
          <span className="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">
            🔴 Urgent
          </span>
        )}
        {is_verified && (
          <span className="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
            ✅ Terverifikasi
          </span>
        )}
        {kategori_nama && (
          <span className="absolute bottom-3 left-3 bg-white/90 text-deep text-xs font-semibold px-3 py-1 rounded-full">
            {kategori_nama}
          </span>
        )}
      </div>
      <div className="p-4">
        <h3 className="font-bold text-deep mb-2 line-clamp-2">{nama}</h3>
        <p className="text-sm text-gray-500 mb-3 line-clamp-2">{deskripsi}</p>

        {/* Progress Bar */}
        <div className="mb-2">
          <div className="flex justify-between text-xs mb-1">
            <span className="font-semibold text-primary">{formatRupiah(total_terkumpul)}</span>
            <span className="text-gray-400">dari {formatRupiah(target_donasi)}</span>
          </div>
          <div className="w-full bg-gray-200 rounded-full h-2">
            <div
              className="bg-primary h-2 rounded-full transition-all duration-500"
              style={{ width: `${progress}%` }}
            />
          </div>
          <div className="text-right text-xs text-gray-400 mt-1">{progress}% tercapai</div>
        </div>

        <button
          onClick={() => onDonate?.(id)}
          className="w-full btn-primary text-sm py-2.5 mt-2"
        >
          Donasi Sekarang
        </button>
      </div>
    </div>
  )
}

export function ProgramCardSkeleton() {
  return (
    <div className="card animate-pulse">
      <div className="w-full h-48 bg-gray-200" />
      <div className="p-4 space-y-3">
        <div className="h-5 bg-gray-200 rounded w-3/4" />
        <div className="h-4 bg-gray-100 rounded w-full" />
        <div className="h-2 bg-gray-200 rounded w-full" />
        <div className="h-10 bg-gray-200 rounded-full w-full" />
      </div>
    </div>
  )
}
