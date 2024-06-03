<?php

namespace App\Feature\IndustryType\Services;

use App\Feature\IndustryType\Models\IndustryType;
use App\Feature\IndustryType\Repositories\IndustryTypeRepository;
use Illuminate\Support\Facades\Log;

class IndustryTypeService
{
    protected $industrytypeRepository;

    public function __construct(IndustryTypeRepository $industrytypeRepository)
    {
        $this->industrytypeRepository = $industrytypeRepository;
    }

    public function createIndustryType(array $data)
    {
        $data['name'] = strtoupper($data['name']);
        $data['description'] = strtoupper($data['description']); 
        return $this->industrytypeRepository->create($data);
    }

    public function getIndustryTypeById($id)
    {
        return $this->industrytypeRepository->find($id);
    }

    public function getAllIndustryTypes($request)
    {
        $query = IndustryType::query();

        // Filter by 'name'
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
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



    public function updateIndustryType($id, array $data)
{
    $industrytype = $this->industrytypeRepository->find($id);

    if ($industrytype) {
        // Transform data to uppercase
        foreach ($data as $key => $value) {
            $data[$key] = strtoupper($value);
        }

        // Update the industry type
        $industrytype->update($data);
    }

    return $industrytype;
}

    public function deactivateIndustryType($id)
    {
        $industrytype = $this->industrytypeRepository->find($id);
        if ($industrytype) {
            $industrytype->update(['status' => 'DEACTIVATED']);

            return $industrytype;
        }

        return null; // Handle the case where the industrytype is not found
    }

    public function deleteIndustryType($id)
    {
        $industrytype = $this->industrytypeRepository->find($id);

        if ($industrytype) {
            // Delete the industrytype type
            $industrytype->delete();

            return true;
        }

        return false;
    }
}
