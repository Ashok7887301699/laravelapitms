<?php

// <project_root>/app/Feature/User/Services/AuthService.php

namespace App\Feature\User\Services;

use App\Feature\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // public function attemptAuthByLoginId($data)
    // {
    //     Log::info('Attempting authentication by login ID', ['login_id' => $data['login_id']]);

    //     $user = $this->userRepository->findByLoginIdAndTenant($data['login_id'], $data['tenant_id']);

    //     if ($user && Hash::check($data['password'], $user->password)) {
    //         try {
    //             if (!$token = JWTAuth::fromUser($user)) {
    //                 return response()->json(['error' => 'Unauthorized'], 401);
    //             }
    //         } catch (JWTException $e) {
    //             return response()->json(['error' => 'Could not create token'], 500);
    //         }
    //         return response()->json(compact('token'));
    //     }

    //     return response()->json(['error' => 'Invalid credentials'], 401);
    // }

    public function attemptAuthByLoginId($data)
    {
        Log::info('Attempting authentication by login ID', ['login_id' => $data['login_id']]);

        // Find the user based on login_id and tenant_id
        $user = $this->userRepository->findByLoginIdAndTenant($data['login_id'], $data['tenant_id']);

        if (! $user) {
            Log::warning('User not found or invalid tenant', ['login_id' => $data['login_id']]);

            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check if the provided password matches the hashed password in the database
        if (Hash::check($data['password'], $user->password_hash)) {
            try {
                // Create a JWT token for the user
                $token = JWTAuth::fromUser($user);
                if (! $token) {
                    Log::error('Failed to create JWT token', ['login_id' => $data['login_id']]);

                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                Log::info('User authenticated successfully', ['login_id' => $data['login_id']]);

                return response()->json(compact('token'));
            } catch (JWTException $e) {
                Log::error('JWT Exception', ['login_id' => $data['login_id'], 'exception' => $e->getMessage()]);

                return response()->json(['error' => 'Could not create token'], 500);
            }
        } else {
            Log::warning('Invalid password attempt', ['login_id' => $data['login_id']]);

            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    // Define similar methods for other login types (by mobile, by email, etc.)
}
