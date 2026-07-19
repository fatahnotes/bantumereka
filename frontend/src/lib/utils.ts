import { clsx, type ClassValue } from 'clsx'
import { twMerge } from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export function formatRupiah(amount: number): string {
  return 'Rp ' + amount.toLocaleString('id-ID')
}

export function getProgressPercent(terkumpul: number, target: number): number {
  if (target <= 0) return 0
  return Math.min(100, Math.round((terkumpul / target) * 100))
}
