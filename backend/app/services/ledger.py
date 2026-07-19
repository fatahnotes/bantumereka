"""Public Ledger — simple hash chain untuk transparansi"""

import hashlib
import json
from typing import Optional


class LedgerService:
    """
    Simple hash-chain ledger untuk memberi rasa transparansi
    seperti blockchain tanpa kompleksitas smart contract.
    Setiap donasi & pencairan memiliki hash yang terhubung ke record sebelumnya.
    """

    @staticmethod
    def compute_hash(data: dict) -> str:
        """Compute SHA-256 hash dari data"""
        data_str = json.dumps(data, sort_keys=True, default=str)
        return hashlib.sha256(data_str.encode()).hexdigest()

    @staticmethod
    def compute_chained_hash(prev_hash: str, data: dict) -> str:
        """Compute hash yang terhubung ke hash sebelumnya"""
        data["prev_hash"] = prev_hash
        return LedgerService.compute_hash(data)

    @staticmethod
    def verify_chain(records: list) -> bool:
        """Verify bahwa chain hash valid"""
        prev_hash = None
        for record in records:
            record_hash = record.get("ledger_hash", "")
            record_prev = record.get("ledger_prev_hash", "")
            if prev_hash and record_prev != prev_hash:
                return False
            prev_hash = record_hash
        return True
