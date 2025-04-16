<?php

namespace App\Interfaces;

interface WalletInterface
{
    public function deposit(string $userId, float $amount);
    public function withdraw(string $userId, float $amount);
}
