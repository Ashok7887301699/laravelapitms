<?php


namespace App\Feature\PickupRequestNote\Models;


use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    // Mass assignable attributesprotected $primaryKey = 'sap_cust_code'; // Set the primary key
    protected $keyType = 'string'; // Set the type of the primary key


    // Define fillable fields
    protected $fillable = [
        'sap_cust_code',
        'sap_cust_grp_code',
        'cust_grp_code',
        'CostCenter',
        'CustName',
        'Category',
        'MobileNo',
        'PAN',
        'City',
        'Pincode',
        'Location',
        'TelNo',
        'Address',
        'ind_type_id',
        'sap_ind_type',
        'CustNameMar',
        'AddressMar',
        'BillAddressMar',
        'EmailId',
        'BillingMail',
        'Status',
        'U_BP_Category',
        'depot_id',
        'sap_depot_name',
        'sap_create_date',
    ];


    // Define relationships



}