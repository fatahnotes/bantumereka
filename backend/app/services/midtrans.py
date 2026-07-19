"""Midtrans Payment Service"""

import hashlib
import json
import httpx
from app.config import settings


class MidtransService:
    """Service untuk integrasi Midtrans Snap"""

    @staticmethod
    def _get_auth_header() -> str:
        from base64 import b64encode
        server_key = settings.MIDTRANS_SERVER_KEY
        encoded = b64encode(f"{server_key}:".encode()).decode()
        return f"Basic {encoded}"

    @staticmethod
    async def create_transaction(
        order_id: str,
        gross_amount: float,
        customer_name: str,
        customer_email: str,
        customer_phone: str = "",
        program_name: str = "Donasi Bantu Mereka",
    ) -> dict:
        """Create Midtrans Snap transaction"""
        payload = {
            "transaction_details": {
                "order_id": order_id,
                "gross_amount": int(gross_amount),
            },
            "credit_card": {"secure": True},
            "customer_details": {
                "first_name": customer_name,
                "email": customer_email,
                "phone": customer_phone,
            },
            "item_details": [
                {
                    "id": order_id,
                    "price": int(gross_amount),
                    "quantity": 1,
                    "name": program_name,
                }
            ],
            "callbacks": {
                "finish": f"{settings.FRONTEND_URL}/donasi/sukses?order_id={order_id}",
                "error": f"{settings.FRONTEND_URL}/donasi/gagal?order_id={order_id}",
                "pending": f"{settings.FRONTEND_URL}/donasi/pending?order_id={order_id}",
            },
        }

        async with httpx.AsyncClient(timeout=30.0) as client:
            response = await client.post(
                settings.midtrans_api_url,
                json=payload,
                headers={
                    "Authorization": MidtransService._get_auth_header(),
                    "Content-Type": "application/json",
                },
            )

            if response.status_code not in (200, 201):
                raise Exception(f"Midtrans error: {response.text}")

            return response.json()

    @staticmethod
    def verify_signature_key(
        order_id: str,
        status_code: str,
        gross_amount: str,
        signature_key: str,
    ) -> bool:
        """Verify Midtrans webhook signature"""
        server_key = settings.MIDTRANS_SERVER_KEY
        raw = f"{order_id}{status_code}{gross_amount}{server_key}"
        computed = hashlib.sha512(raw.encode()).hexdigest()
        return computed == signature_key
