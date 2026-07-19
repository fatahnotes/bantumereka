"""Rate limiting middleware menggunakan slowapi"""

from slowapi import Limiter
from slowapi.util import get_remote_address
from slowapi.middleware import SlowAPIMiddleware

limiter = Limiter(key_func=get_remote_address, default_limits=["100/minute"])


def setup_rate_limit(app):
    """Setup rate limiting for FastAPI app"""
    app.state.limiter = limiter
    app.add_middleware(SlowAPIMiddleware)
