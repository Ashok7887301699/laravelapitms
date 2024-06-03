<?php

namespace App\Feature\User\Services;

use App\Feature\Branch\Models\Branch;
use App\Feature\User\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use App\Feature\User\Models\User;



class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(array $filters, string $sortBy, string $sortOrder, int $perPage): LengthAwarePaginator
    {
        return $this->userRepository->getAll($filters, $sortBy, $sortOrder, $perPage);
    }
    // public function getAllUsers(array $filters, string $sortBy, string $sortOrder, int $perPage): LengthAwarePaginator
    // {
    //     Log::debug('Fetching all users with filters in UserService', $filters);
    //     return $this->userRepository->getAll($filters, $sortBy, $sortOrder, $perPage);
    // }

    public function createUser(array $data)
    {
        Log::debug('Creating User in UserService', $data);
        return $this->userRepository->create($data);
    }

    public function getUserById(int $id)
    {
        Log::debug('Fetching User by ID in UserService', ['id' => $id]);
        return $this->userRepository->find($id);
    }

    public function updateUser(int $id, array $data)
    {
        Log::debug('Updating User in UserService', ['id' => $id, 'data' => $data]);
        $user = $this->getUserById($id);
        if ($user) {
            return $this->userRepository->update($user, $data);
        }
        return null;
    }

    public function deactivateUser($id)
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            $user->update(['status' => 'DEACTIVATED']);

            return $user;
        }

        return null; // Handle the case where the packagetype is not found
    }
    public function deleteUser(int $id)
    {
        Log::debug('Deleting User in UserService', ['id' => $id]);
        $user = $this->getUserById($id);
        if ($user) {
            return $this->userRepository->delete($user);
        }
        return false;
    }
    public function depot_code()
    {
        return Branch::groupBy('BranchCode')->pluck('BranchCode')->toArray();
    }
}
