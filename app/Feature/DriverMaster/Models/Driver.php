<?php

namespace App\Feature\DriverMaster\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $fillable = [
        'FirstName',
        'MiddleName',
        'LastName',
        'SAPId',
        'UserId',
        'BranchCode',
        'DriverCode',
        'Location',
        'MobileNumber',
        'PermanentAddress',
        'CurrentAddress',
        'LicenseNumber',
        'LicenseValidity',
        'IssuedByRTO',
        'GuarantorName',
        'FirstLicenseIssueDate',
        'CloseTrip',
        'MannualDriverCode',
        'DriverFatherName',
        'VehicleNumber',
        'PermanentCity',
        'PermanentPincode',
        'CurrentCity',
        'CurrentPincode',
        'GuarantorName',
        'Status',
        'DriverCategory',
        'DOB',
        'DOJ',
        'Ethinicity',
        'CurrentLicenseIssueDate',
        'LicenseVerifiedDate',
        'LicenseVerified',
        // 'VerifiedByUserId',
        'AddressVerified',
        'DriverPhoto',
        'PanCard',
        'VoterId',
        'AadharCard',
        'License',
    ];
}