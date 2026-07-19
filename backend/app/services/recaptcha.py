"""reCAPTCHA verification service"""

import httpx
from app.config import settings


async def verify_recaptcha(token: str) -> bool:
    """Verify Google reCAPTCHA v3 token"""
    if not settings.RECAPTCHA_SECRET_KEY:
        return True  # Skip if not configured (development)

    async with httpx.AsyncClient(timeout=10.0) as client:
        response = await client.post(
            "https://www.google.com/recaptcha/api/siteverify",
            data={
                "secret": settings.RECAPTCHA_SECRET_KEY,
                "response": token,
            },
        )
        result = response.json()
        # reCAPTCHA v3 returns score 0.0 - 1.0
        return result.get("success", False) and result.get("score", 0) >= 0.5
