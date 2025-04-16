<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Interfaces\WalletInterface;
use App\Models\Wallet;
use Exception;

class WalletRepository implements WalletInterface
{

    public function deposit(string $userId, float $amount)
    {
        $wallet = Wallet::where('user_id', $userId)->firstOrFail();
        $wallet->balance += $amount;
        $wallet->save();

        return $wallet;
    }

    public function withdraw(string $userId, float $amount)
    {
        $wallet = Wallet::where('user_id', $userId)->firstOrFail();

        if ($wallet->balance < $amount) {
            throw new Exception("Insufficient balance.");
        }

        $wallet->balance -= $amount;
        $wallet->save();

        return $wallet;
    }
}
