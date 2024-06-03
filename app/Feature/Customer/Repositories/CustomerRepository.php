<?php

namespace App\Feature\Customer\Repositories;

use App\Feature\Customer\Models\Customer;

class CustomerRepository
{
    // public function getAllCustomers()
    // {
    //     return Customer::all();
    // }
// ChatGpt Code
    // Add more methods for data manipulation as needed...

    public function create(array $data): Customer
    {
        // Create and return a new Customer model
        return Customer::create($data);
    }

    public function find($sap_cust_code)
    {
       // return Customer::find($CustCode);
       return Customer::where('sap_cust_code', $sap_cust_code)->first();
    }

    public function findBysap_cust_code($sap_cust_code)
    {
        return Customer::where('sap_cust_code', $sap_cust_code)->first();
    }
    public function getAllCustomerCodes()
    {
    return Customer::select('sap_cust_code')->get();
    }

}
