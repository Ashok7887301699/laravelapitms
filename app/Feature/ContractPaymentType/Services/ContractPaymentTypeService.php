<?php

namespace App\Feature\ContractPaymentType\Services;

use App\Feature\ContractPaymentType\Models\ContractPaymentType;
use App\Feature\ContractPaymentType\Repositories\ContractPaymentTypeRepository;

class ContractPaymentTypeService
{
    protected $contractpaymenttypeRepository;

    public function __construct(ContractPaymentTypeRepository $contractpaymenttypeRepository)
    {
        $this->contractpaymenttypeRepository = $contractpaymenttypeRepository;
    }

    public function createContractPaymentType(array $data)
    {
        // Additional business logic before saving can go here
        return $this->contractpaymenttypeRepository->create($data);
    }

    public function getContractPaymentTypeById($id)
    {
        return $this->contractpaymenttypeRepository->find($id);
    }

    public function getAllContractPaymentType($request)
    {

        $query = ContractPaymentType::query();

        // Filter by 'contract_paymenttype'
        if ($request->has('contract_paymenttype')) {
            $query->where('contract_paymenttype', 'like', '%'.$request->contract_paymenttype.'%');
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

    public function updateContractPaymentType($id, array $data)
    {
        $contractpaymenttype = $this->contractpaymenttypeRepository->find($id);
        if ($contractpaymenttype) {
            $contractpaymenttype->update($data);
        }

        return $contractpaymenttype;
    }

    public function deactivateContractPaymentType($id)
    {
        $contractpaymenttype = $this->contractpaymenttypeRepository->find($id);
        if ($contractpaymenttype) {
            $contractpaymenttype->update(['status' => 'DEACTIVATED']);

            return $contractpaymenttype;
        }

        return null; // Handle the case where the contractpaymenttype is not found
    }

    public function deleteContractPaymentType($id)
    {
        $contractpaymenttype = $this->contractpaymenttypeRepository->find($id);
        if ($contractpaymenttype) {
            $contractpaymenttype->delete();

            return true;
        }

        return false;
    }
}
