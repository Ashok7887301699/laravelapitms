<?php

namespace App\Feature\Customer\Services;

use Illuminate\Http\Request;
use App\Feature\Customer\Models\Customer;
use App\Feature\Customer\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Feature\Branch\Models\Branch;
use App\Feature\Customer\Models\BranchCode;
use App\Feature\Customer\Models\IndType;
use App\Feature\GroupMaster\Models\GroupMaster;

class CustomerService
{
    protected $CustomerRepository;

    public function __construct(CustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }
    public function createCustomer(array $customers)
    {
        $createdCustomers = [];
        $duplicateSapCustCodes = [];

        foreach ($customers as $data) {
            try {
                // Check if the customer already exists based on sap_cust_code
                $existingCustomer = $this->CustomerRepository->findBysap_cust_code($data['sap_cust_code']);

                if ($existingCustomer) {
                    // Customer already exists, log it and continue to the next record
                    Log::info('Customer with sap_cust_code ' . $data['sap_cust_code'] . ' already exists. Skipping record.');
                    $duplicateSapCustCodes[] = $data['sap_cust_code']; // Store the duplicate sap_cust_code
                    continue;
                }

                // Customer does not exist, create it
                $createdCustomer = $this->CustomerRepository->create($data);
                $createdCustomers[] = $createdCustomer;
            } catch (\Exception $e) {
                // Other database-related errors
                Log::error('Database error: ' . $e->getMessage());
                // Handle the error as needed
            }
        }

        if (!empty($duplicateSapCustCodes)) {
            // Return the duplicate sap_cust_codes in the error response
            throw new \Exception('Duplicate sap_cust_codes found: ' . implode(', ', $duplicateSapCustCodes));
        }

        // Return the created customers
        return $createdCustomers;
    }


    public function getCustomerById($sap_cust_code)
    {
        return $this->CustomerRepository->find($sap_cust_code);
    }


    // public function getAllCustomers($request)
    // {
    //     $query = Customer::query();

    //     // Filter by 'name'
    //     if ($request->has('sap_cust_code')) {
    //         $query->where('sap_cust_code', 'like', '%' . $request->sap_cust_code . '%');
    //     }
    //     if ($request->has('sap_cust_grp_code')) {
    //         $query->where('sap_cust_grp_code', 'like', '%' . $request->sap_cust_grp_code . '%');
    //     }

    //     if ($request->has('CustName')) {
    //         $query->where('CustName', 'like', '%' . $request->CustName . '%');
    //     }
    //     // Filter by 'status'
    //     if ($request->has('Status')) {
    //         $query->where('Status', $request->Status);
    //     }

    //     // Filter by 'created_at' date range
    //     if ($request->has(['created_from', 'created_to'])) {
    //         $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
    //     }

    //     // Filter by 'updated_at' date range
    //     if ($request->has(['updated_from', 'updated_to'])) {
    //         $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
    //     }

    //     // Sorting
    //     $sortBy = $request->get('sort_by', 'updated_at');
    //     $sortOrder = $request->get('sort_order', 'desc');
    //     $query->orderBy($sortBy, $sortOrder);

    //     // Pagination
    //     $perPage = $request->get('per_page', 10);
    //     return $query->paginate($perPage);
    //     // // Sorting
    //     // $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));

    //     // // Pagination
    //     // $perPage = $request->get('per_page', 10); // Default to 10 if not provided

    //     // return $query->paginate($perPage);

    //     return Customer::all();
    // }

    public function getAllCustomers(Request $request)
    {
        $query = Customer::query();

        // Filter by 'sap_cust_code'
        if ($request->has('sap_cust_code')) {
            $query->where('sap_cust_code', 'like', '%' . $request->input('sap_cust_code') . '%');
        }

        // Filter by 'sap_cust_grp_code'
        if ($request->has('sap_cust_grp_code')) {
            $query->where('sap_cust_grp_code', 'like', '%' . $request->input('sap_cust_grp_code') . '%');
        }

        // Filter by 'CustName'
        if ($request->has('CustName')) {
            $query->where('CustName', 'like', '%' . $request->input('CustName') . '%');
        }

        // Filter by 'Status'
        if ($request->has('Status')) {
            $query->where('Status', $request->input('Status'));
        }

        // Filter by 'created_at' date range
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->input('created_from'), $request->input('created_to')]);
        }

        // Filter by 'updated_at' date range
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->input('updated_from'), $request->input('updated_to')]);
        }

        if ($request->has(['sap_create_date_from', 'sap_create_date_to'])) {
            $query->whereBetween('sap_create_date', [$request->input('sap_create_date_from'), $request->input('sap_create_date_to')]);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'updated_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);
    }


    public function updateCustomer($sap_cust_code, array $data)
    {
        $customer = $this->CustomerRepository->find($sap_cust_code);
        if ($customer) {
            $customer->update($data);
        }

        return $customer;
    }


    public function deactivateCustomer($sap_cust_code)
    {
        $customer = $this->CustomerRepository->find($sap_cust_code);
        if ($customer) {
            $customer->update(['Status' => '0']);

            return $customer;
        }

        return null; // Handle the case where the tenant is not found
    }

    public function deleteCustomer($sap_cust_code)
    {
        $customer = $this->CustomerRepository->find($sap_cust_code);
        if ($customer) {
            $customer->delete();

            return true;
        }

        return false;
    }
    // Add other methods for customer-related business logic as needed...

    public function getBranchCodeBySapDepotName($sap_depot_name)
    {
        $branch = Branch::where('BranchCode', $sap_depot_name)->first();

        return $branch ? $branch->BranchCode : null;
    }

    public function fetch_sap_ind_type()
    {
        return IndType::groupBy('name')->pluck('name')->toArray();
    }

    public function fetch_sap_depot_name()
    {
        return Branch::groupBy('BranchCode')->pluck('BranchCode')->toArray();
    }

    public function fetch_groupcode()
    {
        return GroupMaster::select('groupcode', 'groupname')->get();
    }
    public function getExistingCustomerCodes()
    {
    return $this->CustomerRepository->getAllCustomerCodes();
    }

    public function checkPANExists($PAN)
    {
    // Logic to check if PAN exists
     $existingCustomer = Customer::where('PAN', $PAN)->exists();

    return $existingCustomer;
    }

}
