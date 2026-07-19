"""Email Service using Resend"""

from typing import Optional
import httpx
from app.config import settings


class EmailService:
    """Service untuk mengirim email via Resend"""

    @staticmethod
    async def send(
        to_email: str,
        subject: str,
        html_content: str,
        to_name: Optional[str] = None,
    ) -> bool:
        """Send email via Resend API"""
        if not settings.RESEND_API_KEY:
            print(f"[EMAIL MOCK] To: {to_email} | Subject: {subject}")
            return True

        payload = {
            "from": f"{settings.EMAIL_FROM_NAME} <{settings.EMAIL_FROM}>",
            "to": [to_email],
            "subject": subject,
            "html": html_content,
        }

        async with httpx.AsyncClient(timeout=15.0) as client:
            response = await client.post(
                "https://api.resend.com/emails",
                json=payload,
                headers={
                    "Authorization": f"Bearer {settings.RESEND_API_KEY}",
                    "Content-Type": "application/json",
                },
            )
            return response.status_code == 200

    @staticmethod
    async def send_donation_receipt(
        to_email: str,
        to_name: str,
        program_name: str,
        amount: float,
        order_id: str,
        payment_method: str,
        donation_date: str,
    ) -> bool:
        """Kirim bukti donasi via email"""
        html = f"""
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <div style="background: #C62828; padding: 24px; text-align: center;">
                <h1 style="color: white; margin: 0;">🤝 Bantu Mereka</h1>
            </div>
            <div style="padding: 24px; background: #fff;">
                <h2>Terima Kasih, {to_name}!</h2>
                <p>Donasi Anda telah kami terima:</p>
                <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Program</strong></td><td style="padding: 8px; border-bottom: 1px solid #eee;">{program_name}</td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Jumlah</strong></td><td style="padding: 8px; border-bottom: 1px solid #eee;">Rp {amount:,.0f}</td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Order ID</strong></td><td style="padding: 8px; border-bottom: 1px solid #eee;">{order_id}</td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Metode</strong></td><td style="padding: 8px; border-bottom: 1px solid #eee;">{payment_method}</td></tr>
                    <tr><td style="padding: 8px;"><strong>Tanggal</strong></td><td style="padding: 8px;">{donation_date}</td></tr>
                </table>
                <p style="color: #666; font-size: 14px;">Donasi Anda 100% tersalurkan tanpa potongan. Kami transparan dan akuntabel.</p>
                <div style="text-align: center; margin-top: 24px;">
                    <a href="{settings.FRONTEND_URL}/transparansi" style="background: #C62828; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px;">Lihat Transparansi Dana</a>
                </div>
            </div>
        </body>
        </html>
        """
        return await EmailService.send(to_email, "Bukti Donasi — Bantu Mereka", html, to_name)

    @staticmethod
    async def send_tax_receipt(
        to_email: str,
        to_name: str,
        year: int,
        total_amount: float,
        receipt_url: str,
    ) -> bool:
        """Kirim tax receipt (laporan donasi tahunan)"""
        html = f"""
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <div style="background: #0A2540; padding: 24px; text-align: center;">
                <h1 style="color: #D4AF37; margin: 0;">🧾 Laporan Donasi Tahunan</h1>
            </div>
            <div style="padding: 24px;">
                <p>Halo <strong>{to_name}</strong>,</p>
                <p>Berikut rekap donasi Anda untuk tahun <strong>{year}</strong>:</p>
                <p style="font-size: 24px; font-weight: bold; color: #C62828;">Total: Rp {total_amount:,.0f}</p>
                <p>Dokumen resmi dapat diunduh di link berikut:</p>
                <a href="{receipt_url}" style="display: inline-block; background: #D4AF37; color: #0A2540; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;">Unduh Laporan</a>
            </div>
        </body>
        </html>
        """
        return await EmailService.send(to_email, f"Laporan Donasi {year} — Bantu Mereka", html, to_name)
