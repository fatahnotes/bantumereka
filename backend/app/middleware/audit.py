"""Audit logging utilities"""

from typing import Optional
from fastapi import Request
from app.models.audit import AuditLog


async def log_audit(
    request: Request,
    action: str,
    entity_type: str,
    entity_id: Optional[str] = None,
    user_id: Optional[str] = None,
    user_name: Optional[str] = None,
    detail: Optional[dict] = None,
):
    """Create an audit log entry"""
    try:
        audit = AuditLog(
            action=action,
            entity_type=entity_type,
            entity_id=entity_id,
            user_id=user_id,
            user_name=user_name,
            ip_address=request.client.host if request.client else None,
            user_agent=request.headers.get("user-agent", ""),
            detail=detail,
        )
        await audit.insert()
    except Exception as e:
        # Don't fail the main request if audit logging fails
        print(f"Audit log error: {e}")


def audit_action(action: str, entity_type: str):
    """
    Decorator factory for audit logging.
    Usage: @audit_action("donasi_created", "donasi")
    """
    def decorator(func):
        async def wrapper(*args, **kwargs):
            # Find request object in args
            request = None
            for arg in args:
                if isinstance(arg, Request):
                    request = arg
                    break

            result = await func(*args, **kwargs)

            if request:
                await log_audit(
                    request=request,
                    action=action,
                    entity_type=entity_type,
                )

            return result
        return wrapper
    return decorator
