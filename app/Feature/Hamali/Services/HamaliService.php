<?php

namespace App\Feature\Hamali\Services;

use App\Feature\Hamali\Models\Hamali;
use App\Feature\Hamali\Repositories\HamaliRepository;

class HamaliService
{
    protected $hamaliRepository;

    public function __construct(HamaliRepository $hamaliRepository)
    {
        $this->hamaliRepository = $hamaliRepository;
    }

    public function createHamali(array $data)
    {
        // Additional business logic before saving can go here
        return $this->hamaliRepository->create($data);
    }

    public function getHamaliById($id)
    {
        return $this->hamaliRepository->find($id);
    }

    public function getAllHamali($request)
    {

        $query = Hamali::query();

        // Filter by 'VendorCode'
        if ($request->has('VendorCode')) {
            $query->where('VendorCode', 'like', '%'.$request->VendorCode.'%');
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

    public function updateHamali($id, array $data)
    {
        $hamali = $this->hamaliRepository->find($id);
        if ($hamali) {
            $hamali->update($data);
        }

        return $hamali;
    }

    public function deactivateHamali($id)
    {
        $hamali = $this->hamaliRepository->find($id);
        if ($hamali) {
            $hamali->update(['status' => 'DEACTIVATED']);

            return $hamali;
        }

        return null; // Handle the case where the hamali is not found
    }

    public function deleteHamali($id)
    {
        $hamali = $this->hamaliRepository->find($id);
        if ($hamali) {
            $hamali->delete();

            return true;
        }

        return false;
    }
}
