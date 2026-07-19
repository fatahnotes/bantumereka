"""Auth Router — Login/Register untuk Admin"""

from fastapi import APIRouter, Depends, HTTPException, status
from pydantic import BaseModel, EmailStr
from app.models.user import User
from app.utils.auth import (
    hash_password,
    verify_password,
    create_access_token,
    get_current_user,
    get_admin_user,
)

router = APIRouter(prefix="/api/auth", tags=["Auth"])


class LoginRequest(BaseModel):
    username: str
    password: str


class RegisterRequest(BaseModel):
    username: str
    password: str
    nama: str
    email: str | None = None


class TokenResponse(BaseModel):
    access_token: str
    token_type: str = "bearer"
    user: dict


@router.post("/login", response_model=TokenResponse)
async def login(data: LoginRequest):
    """Login admin / moderator"""
    user = await User.find_one(User.username == data.username)
    if not user or not verify_password(data.password, user.password_hash):
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Username atau password salah",
        )
    if not user.is_active:
        raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail="Akun dinonaktifkan")

    token = create_access_token({"sub": str(user.id), "role": user.role})

    # Update last login
    from datetime import datetime
    user.last_login = datetime.utcnow()
    await user.save()

    return TokenResponse(
        access_token=token,
        user={
            "id": str(user.id),
            "username": user.username,
            "nama": user.nama,
            "role": user.role,
            "email": user.email,
        },
    )


@router.post("/register")
async def register(data: RegisterRequest, admin: User = Depends(get_admin_user)):
    """Register admin baru (hanya superadmin/admin yang bisa)"""
    existing = await User.find_one(User.username == data.username)
    if existing:
        raise HTTPException(status_code=status.HTTP_400_BAD_REQUEST, detail="Username sudah digunakan")

    user = User(
        username=data.username,
        password_hash=hash_password(data.password),
        nama=data.nama,
        email=data.email,
        role="moderator",
    )
    await user.insert()

    return {"message": "User berhasil dibuat", "user_id": str(user.id)}


@router.get("/me")
async def get_me(user: User = Depends(get_current_user)):
    """Get current user profile"""
    return {
        "id": str(user.id),
        "username": user.username,
        "nama": user.nama,
        "email": user.email,
        "role": user.role,
        "is_active": user.is_active,
        "last_login": user.last_login.isoformat() if user.last_login else None,
    }


@router.post("/change-password")
async def change_password(
    old_password: str,
    new_password: str,
    user: User = Depends(get_current_user),
):
    """Change password"""
    if not verify_password(old_password, user.password_hash):
        raise HTTPException(status_code=status.HTTP_400_BAD_REQUEST, detail="Password lama salah")

    user.password_hash = hash_password(new_password)
    await user.save()

    return {"message": "Password berhasil diubah"}
