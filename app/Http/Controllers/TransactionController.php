<?php

namespace App\Http\Controllers;

use App\Interfaces\TransactionInterface;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function transfer(Request $request, $senderId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'recipient_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:1',
            ]);
            $validator->validate();

            $recipientId = $request->recipient_id;
            $amount = $request->amount;

            $transaction = $this->transactionRepository->transferFunds($senderId, $recipientId, $amount);

            return response()->json([
                'message' => 'Funds transferred successfully',
                'data' => $transaction
            ], 200);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }

    public function getUserTransactions($userId)
    {
        try {
            $transactions = $this->transactionRepository->getUserTransactions($userId);

            return response()->json([
                'message' => 'Transactions retrieved successfully',
                'data' => $transactions
            ], 200);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }
}
