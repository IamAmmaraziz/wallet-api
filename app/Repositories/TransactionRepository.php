<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionInterface
{
    public function transferFunds($senderId, $recipientId, $amount)
    {
        DB::beginTransaction();

        try {
            $senderWallet = Wallet::where('user_id', $senderId)->first();
            $recipientWallet = Wallet::where('user_id', $recipientId)->first();

            if ($senderWallet->balance < $amount) {
                throw new Exception("Insufficient funds in sender's wallet");
            }

            $senderWallet->balance -= $amount;
            $senderWallet->save();

            $recipientWallet->balance += $amount;
            $recipientWallet->save();

            $transaction = new Transaction([
                'user_id' => $senderId,
                'receiver_id' => $recipientId,
                'amount' => $amount,
                'status' => 'completed',
            ]);
            $transaction->save();

            DB::commit();

            return $transaction;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserTransactions($userId)
    {
        return Transaction::where('user_id', $userId)
                          ->orWhere('receiver_id', $userId)
                          ->get();
    }
    
}
