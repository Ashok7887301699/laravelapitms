<?php

namespace App\Feature\Customer\Controllers;

use App\Feature\Branch\Models\Branch;
use App\Http\Controllers\Controller;
use App\Feature\Customer\Requests\CustomerRequest;
use App\Feature\Customer\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{
    protected $customerService; // Corrected property name

    public function __construct(CustomerService $customerService) // Corrected parameter name
    {
        $this->customerService = $customerService; // Corrected property assignment
    }

    public function store(CustomerRequest $request, CustomerService $customerService)
    {
        Log::info('Customer store method called in CustomerController');
        $validatedData = $request->validated();

        // Access the 'data' key from the validated data
        $customers = $validatedData['data'];

        if (empty($customers)) {
            return response()->json(['message' => 'No customers provided'], 400);
        }

        $customer = $customerService->createCustomer($customers);

        return response()->json(['message' => 'Customer(s) created successfully', 'customer' => $customer], 201);
    }




    public function show($sap_cust_code)
    {
        Log::info('Customer show method called in CustomerController');
        $customer = $this->customerService->getCustomerById($sap_cust_code);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['message' => 'Perticular Customer fetched successfully', 'customer' => $customer]);
    }
    public function index(Request $request)
    {
        Log::info('Customer index method called in CustomerController');
        $customer = $this->customerService->getAllCustomers($request);

        return response()->json(['message' => 'Customers fetched successfully', 'customer' => $customer]);
    }

    public function update(Request $request, $sap_cust_code)
    {
        $customer = $this->customerService->updateCustomer($sap_cust_code, $request->all());

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer]);
    }


    public function deactivate($sap_cust_code)
    {
        $customer = $this->customerService->deactivateCustomer($sap_cust_code);
        if ($customer) {
            $response = $customer->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'customer deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'sap_cust_code' => $sap_cust_code,
            'message' => 'customer not found',
        ], 404);
    }

    public function destroy($sap_cust_code)
    {
        if ($this->customerService->deleteCustomer($sap_cust_code)) {
            return response()->json([
                'sap_cust_code' => $sap_cust_code,
                'deleted' => true,
                'message' => 'Customer deleted successfully',
            ], 200);
        }

        return response()->json([
            'sap_cust_code' => $sap_cust_code,
            'message' => 'Customer not found',
        ], 404);
    }

    public function getBranchCodeBySapDepotName($sap_depot_name)
    {
        $BranchCode = $this->customerService->getBranchCodeBySapDepotName($sap_depot_name);

        if ($BranchCode) {
            return response()->json(['message' => 'BranchCode found', 'BranchCode' => $BranchCode], 200);
        } else {
            return response()->json(['message' => 'BranchCode not found for the given sap_depot_name'], 404);
        }
    }


    public function fetchindtype()
    {
        // Call the CityMasterService to fetch all states
        $sap_ind_type = $this->customerService->fetch_sap_ind_type();

        // Return the fetched states
        return response()->json(['name' => $sap_ind_type], 200);
    }
    public function fetchdeponame()
    {
        // Call the fetch_sap_depot_name method from your service
        $BranchCode = $this->customerService->fetch_sap_depot_name();

        // Check if BranchCodes are not empty
        if (!empty($BranchCode)) {
            // Return the fetched BranchCodes
            return response()->json(['BranchCode' => $BranchCode], 200);
        } else {
            // Return an error message if BranchCodes are not found
            return response()->json(['message' => 'BranchCode not found'], 404);
        }
    }

    public function fetchgroupcode()
    {
        // Call the fetch_sap_depot_name method from your service
        $groupcode = $this->customerService->fetch_groupcode();

        // Check if BranchCodes are not empty
        if (!empty($groupcode)) {
            // Return the fetched BranchCodes
            return response()->json(['groupcode' => $groupcode], 200);
        } else {
            // Return an error message if BranchCodes are not found
            return response()->json(['message' => 'groupcode not found'], 404);
        }
    }
    public function getExistingCustomerCodes()
    {
        $existingCodes = $this->customerService->getExistingCustomerCodes();
        return response()->json(['existing_codes' => $existingCodes], 200);
    }
    public function checkPANExists(Request $request)
    {
        $PAN = $request->input('PAN');
        $panExists = $this->customerService->checkPANExists($PAN);

        return response()->json(['PAN' => $panExists]);
    }


}
