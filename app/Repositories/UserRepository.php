<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Models\Wallet;

class UserRepository implements UserInterface
{

    public function createUser(array $data)
    {

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->save();

        $userWallet = new Wallet([
            'user_id' => $user->id,
            'balance' => 0
        ]);
        $userWallet->save();
        return $user->load('wallet');
    }
    public function getUserDetails($id)
    {
        return User::with('wallet')->findOrFail($id);
    }
}
