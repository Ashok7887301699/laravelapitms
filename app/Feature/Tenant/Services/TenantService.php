<?php

namespace App\Feature\Tenant\Services;

use App\Feature\Tenant\Models\Tenant;
use App\Feature\Tenant\Repositories\TenantRepository;
use Illuminate\Support\Facades\Log;

class TenantService
{
    protected $tenantRepository;

    public function __construct(TenantRepository $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function createTenant(array $data)
    {
        Log::debug('Creating a new tenant in TenantService', $data);

        return $this->tenantRepository->create($data);
    }

    public function getTenantById($id)
    {
        Log::debug("Fetching tenant with ID: $id in TenantService");

        return $this->tenantRepository->find($id);
    }

    public function getAllTenants($request)
    {
        Log::debug('Fetching list of tenants in TenantService', ['query_params' => $request->query()]);
        $query = Tenant::query();

        // Filter by 'name'
        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        // Filter by 'short_name'
        if ($request->has('short_name')) {
            $query->where('short_name', 'like', '%'.$request->short_name.'%');
        }

        // Filter by 'status'
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by 'created_at' date range
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
        }

        // Filter by 'updated_at' date range
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
        }

        // Sorting
        $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));

        // Pagination
        $perPage = $request->get('per_page', 10); // Default to 10 if not provided

        return $query->paginate($perPage);
    }

    public function updateTenant($id, array $data)
    {
        Log::debug('Updating tenant in TenantService', ['id' => $id, 'data' => $data]);
        $tenant = $this->tenantRepository->find($id);
        if ($tenant) {
            $tenant->update($data);

            return $tenant;
        }

        Log::error('Tenant not found for update', ['id' => $id]);

        return null;
    }

    public function deactivateTenant($id)
    {
        Log::debug('Deactivating tenant in TenantService', ['id' => $id]);
        $tenant = $this->tenantRepository->find($id);
        if ($tenant) {
            $tenant->update(['status' => 'DEACTIVATED']);

            return $tenant;
        }

        return null; // Handle the case where the tenant is not found
    }

    public function deleteTenant($id)
    {
        Log::debug('Deleting tenant in TenantService', ['id' => $id]);
        $tenant = $this->tenantRepository->find($id);
        if ($tenant) {
            $tenant->delete();

            return true;
        }

        return false;
    }
}