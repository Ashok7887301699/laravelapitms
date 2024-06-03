<?php
namespace App\Feature\User\Repositories;

use App\Feature\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    public function findByLoginIdAndTenant($loginId, $tenantId)
    {
        return User::where('login_id', $loginId)
            ->where('tenant_id', $tenantId)
            ->first();
    }

    public function findByMobileAndTenant($mobile, $tenantId)
    {
        return User::where('mobile_no', $mobile)
            ->where('tenant_id', $tenantId)
            ->first();
    }

    public function findByEmailAndTenant($email, $tenantId)
    {
        return User::where('email_id', $email)
            ->where('tenant_id', $tenantId)
            ->first();
    }

    public function getAll(array $filters, string $sortBy, string $sortOrder, int $perPage): LengthAwarePaginator
{
    Log::debug('Fetching all users from the database', ['filters' => $filters]);

    $query = User::query();
  // Apply filters
//   if (isset($filters['login_id'])) {
//     $query->where('login_id', 'like', '%' . $filters['login_id'] . '%');

    // Apply general filters
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            switch ($key) {
                case 'login_id':
                    $query->where('login_id', 'like', "%$value%");
                    break;
                case 'tenant_id':
                    $query->where('tenant_id', 'like', "%$value%");
                    break;
                case 'displayname':
                    $query->where('displayname', 'like', "%$value%");
                    break;
                case 'user_type':
                    $query->where('user_type', 'like', "%$value%");
                    break;
                case 'status':
                    $query->where('status', 'like', "%$value%");
                    break;
                case 'created_from':
                    $query->whereDate('created_at', '>=', $value);
                    break;
                case 'created_to':
                    $query->whereDate('created_at', '<=', $value);
                    break;
                case 'updated_from':
                    $query->whereDate('updated_at', '>=', $value);
                    break;
                case 'updated_to':
                    $query->whereDate('updated_at', '<=', $value);
                    break;
                  
 
                default:
                    $query->where($key, 'like', "%$value%");
                    break;
            }
        }
    }

    // Apply sorting
    $query->orderBy($sortBy ?: 'updated_at', $sortOrder ?: 'desc');

    // Return the paginated result
    return $query->paginate($perPage);
}


    public function create(array $data): User
    {
        Log::debug('Creating a new User', $data);
        return User::create($data);
    }

    public function find(int $id): ?User
    {
        Log::debug('Finding a User with ID', ['id' => $id]);
        return User::find($id);
    }

    public function update(User $user, array $data): User
    {
        Log::debug('Updating a User', ['id' => $user->id]);
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        Log::debug('Deleting a User', ['id' => $user->id]);
        return $user->delete();
    }
}
