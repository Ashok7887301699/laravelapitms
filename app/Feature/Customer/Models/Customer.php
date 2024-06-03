<?php

namespace App\Feature\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Feature\CustomerGroup\Models\CustomerGrp;
use App\Feature\IndustryType\Models\IndustryType;
use App\Feature\Branch\Models\Branch;
class Customer extends Model
{


    // protected $fillable = [
    //     'SapGroupCode',
    //     'CustCode',
    //     'CostCenter',
    //     'CustName',
    //     'Category',
    //     'MobileNo',
    //     'PAN',
    //     'City',
    //     'Pincode',
    //     'Location',
    //     'TelNo',
    //     'Address',
    //     'IndType',
    //     'CustNameMar',
    //     'AddressMar',
    //     'BillAddressMar',
    //     'EmailId',
    //     'BillingMail',
    //     'Status',
    //     'U_BP_Category',
    //     'BranchName',
    //     'SapCreateDate',
    // ];

    use HasFactory;
    protected $primaryKey = 'sap_cust_code';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'sap_cust_code', 'sap_cust_grp_code',  'CostCenter', 'CustName', 'Category',
        'MobileNo', 'PAN', 'GST_No', 'City', 'Pincode', 'Location', 'TelNo', 'Address','sap_ind_type',
        'CustNameMar', 'AddressMar', 'BillAddressMar','BillingMail','BillingMobileNo','BiillingPerson',
        'Status', 'sap_depot_name', 'CreatedBy', 'SalesReference', 'sap_create_date'
    ];


    // Relationships
    public function customerGrp()
    {
        return $this->belongsTo(CustomerGrp::class, 'cust_grp_code', 'cust_grp_code');
    }


    public function industryType()
    {
        return $this->belongsTo(IndustryType::class, 'ind_type_id', 'id');
    }


    public function depot()
    {
        return $this->belongsTo(Branch::class, 'depot_id', 'BranchCode');
    }

}
