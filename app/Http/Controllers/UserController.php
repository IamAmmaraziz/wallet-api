<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Exception;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function store(Request $request)
    {
        try {
            $validator = validator::make($request->all(), [
                'name'   => 'required|string|max:255',
                'email'  => 'required|email|unique:users,email',
                'password'  => 'required|min:8',
                'balance' => 'nullable|numeric|min:0',
            ]);
            $validator->validate();


            $user = $this->userRepository->createUser($request->all());

            return response()->json([
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }


    public function show($id)
    {
        try {
            $user = $this->userRepository->getUserDetails($id);

            return response()->json([
                'message' => 'User details fetched successfully',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }
    }
}
