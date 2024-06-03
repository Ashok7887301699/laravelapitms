<?php

namespace App\Feature\User\Models;

use App\Feature\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Feature\Branch\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'tenant_id',
        'login_id',
        'mobile_no',
        'email_id',
        'password_hash',
        'displayname',
        'profile_pic_url',
        'user_type',
        'role_id',
        'status'
    ];

    /**
     * Get the tenant that owns the user.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the role that the user belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // You can add accessors and mutators here for attributes like password_hash

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';  // 'id' is the primary key
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password_hash;  // 'password_hash' stores the password
    }

    /**
     * Get the privileges associated with the user's role.
     *
     * @return \Illuminate\Support\Collection
     */
    public function privileges()
    {
        $role = $this->role()->with('privileges')->first(); // Eager load role with privileges

        if ($role) {
            return $role->privileges->pluck('name');
        } else {
            return collect(); // Return empty collection if no role found
        }
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        $tenant = $this->tenant; // Assuming there is a tenant relationship
        $role = $this->role;     // Assuming there is a role relationship

        // Eager load branches relationship
        $this->load('branches');

        // $branches = $this->branches;
        // Log::info("Branches");
        // Log::debug($branches);

        //Array 
        // Get the branch codes from the loaded branches relationship
        // $branchCodes = $this->branches->map(function ($branch) {
        //     return $branch->pivot->branch_code;
        // })->toArray();

        //String
        $branchCode = $this->branches->first() ? $this->branches->first()->pivot->branch_code : null;

        // $branchCodes = $branches ? $branches->pluck('branch_code')->toArray() : null;
        Log::info("Branch codes only ");
        Log::debug($branchCode);

        return [
            'tenant_id' => $this->tenant_id,
            'tenant_name' => $tenant ? $tenant->name : null,
            'tenant_short_name' => $tenant ? $tenant->short_name : null,
            'tenant_logo_url' => $tenant ? $tenant->logo_url : null,
            'user_id' => $this->id, //Added User id in token
            'branch_code' => $branchCode,
            'displayname' => $this->displayname,
            'profile_pic_url' => $this->profile_pic_url,
            'login_id' => $this->login_id,
            'mobile_no' => $this->mobile_no,
            'email_id' => $this->email_id,
            'user_type' => $this->user_type,
            'role_id' => $this->role_id,
            'role_name' => $role ? $role->name : null,
            'privileges' => $this->privileges()->toArray(),
        ];
    }
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'userbranch', 'user_id', 'branch_code');
    }
}
