<?php

namespace App\Feature\Tenant\Controllers;

use App\Feature\Tenant\Requests\TenantStoreRequest;
use App\Feature\Tenant\Requests\TenantUpdateRequest;
use App\Feature\Tenant\Services\TenantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function store(TenantStoreRequest $request)
    {
        Log::debug('Tenant store method called in TenantController');
        $validatedData = $request->validated();
        $tenant = $this->tenantService->createTenant($validatedData);

        if ($tenant) {
            return response()->json($tenant, 201); // 201 Created
        } else {
            // Log the error
            Log::error('Failed to create tenant in TenantController@store', ['request' => $validatedData]);

            // Return an error response
            return response()->json([
                'message' => 'Failed to create tenant',
                'errors' => 'There was an error processing the request',
            ], 500); // 500 Internal Server Error
        }
    }

    public function show($id)
    {
        Log::debug("Tenant show method called in TenantController for ID: $id");
        $tenant = $this->tenantService->getTenantById($id);

        if (! $tenant) {
            Log::error("Tenant with ID: $id not found in TenantController@show");

            return response()->json(['message' => 'Tenant not found'], 404);
        }

        return response()->json($tenant);
    }

    public function index(Request $request)
    {
        Log::debug('Tenant index method called in TenantController');

        try {
            $tenants = $this->tenantService->getAllTenants($request);

            if ($tenants->isEmpty()) {
                Log::info('No tenants found in TenantController@index');
            }

            return response()->json($tenants);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in TenantController@index: '.$e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching tenants',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(TenantUpdateRequest $request, $id)
    {
        Log::debug("Tenant update method called in TenantController for ID: $id");
        $validatedData = $request->validated();
        $tenant = $this->tenantService->updateTenant($id, $validatedData);

        if (! $tenant) {
            Log::error("Tenant with ID: $id not found in TenantController@update");

            return response()->json(['message' => 'Tenant not found'], 404);
        }

        return response()->json($tenant);
    }

    public function deactivate($id)
    {
        Log::debug("Deactivating tenant with ID: $id in TenantController");
        $tenant = $this->tenantService->deactivateTenant($id);

        if ($tenant) {
            Log::info("Tenant with ID: $id deactivated successfully");
            $response = $tenant->toArray();
            $response['message'] = 'Tenant deactivated successfully';

            return response()->json($response, 200);
        }

        Log::error("Tenant with ID: $id not found for deactivation");

        return response()->json(['message' => 'Tenant not found'], 404);
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete tenant with ID: $id in TenantController");
        if ($this->tenantService->deleteTenant($id)) {
            Log::info("Tenant with ID: $id deleted successfully");

            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'Tenant deleted successfully'], 200);
        }

        Log::error("Tenant with ID: $id not found for deletion");

        return response()->json(['id' => $id, 'message' => 'Tenant not found'], 404);
    }
}
