<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function transferFunds($senderId, $recipientId, $amount);
    public function getUserTransactions($userId);
}
