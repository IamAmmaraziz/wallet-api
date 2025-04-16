<?php

namespace App\Http\Controllers;

use App\Interfaces\WalletInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletRepository;

    public function __construct(WalletInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function deposit(Request $request, $userId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:0.01',
            ]);

            $validator->validate();

            $wallet = $this->walletRepository->deposit($userId, $request->amount);

            return response()->json([
                'message' => 'Funds deposited successfully',
                'data' => $wallet
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function withdraw(Request $request, $userId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:0.01',
            ]);

            $validator->validate();

            $wallet = $this->walletRepository->withdraw($userId, $request->amount);

            return response()->json([
                'message' => 'Funds withdrawn successfully',
                'data' => $wallet
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
