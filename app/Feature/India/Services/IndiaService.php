<?php

namespace App\Feature\India\Services;

use App\Feature\India\Models\India;
use App\Feature\India\Repositories\IndiaRepository;
use Illuminate\Support\Facades\Log;

class IndiaService
{
    protected $indiaRepository;

    public function __construct(IndiaRepository $indiaRepository)
    {
        $this->indiaRepository = $indiaRepository;
    }

    public function createIndia(array $data)
    {
        Log::debug('Creating a new india in IndiaService', $data);

        return $this->indiaRepository->create($data);
    }

    public function getIndiaById($id)
    {
        Log::debug("Fetching india with ID: $id in IndiaService");

        return $this->indiaRepository->find($id);
    }

    public function getAllIndias($request)
    {
        Log::debug('Fetching list of indias in IndiaService', ['query_params' => $request->query()]);
        $query = India::query();

        // Filter by 'name'
        if ($request->has('Country')) {
            $query->where('Country', 'like', '%'.$request->Country.'%');
        }

        // Filter by 'short_name'
        if ($request->has('state')) {
            $query->where('state', 'like', '%'.$request->state.'%');
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

    public function updateIndia($id, array $data)
    {
        Log::debug('Updating India in IndiaService', ['id' => $id, 'data' => $data]);
        $india = $this->indiaRepository->find($id);
        if ($india) {
            $india->update($data);

            return $india;
        }

        Log::error('India not found for update', ['id' => $id]);

        return null;
    }

    public function deactivateIndia($id)
    {
        Log::debug('Deactivating india in IndiaService', ['id' => $id]);
        $india = $this->indiaRepository->find($id);
        if ($india) {
            $india->update(['status' => 'DEACTIVATED']);

            return $india;
        }

        return null; // Handle the case where the India is not found
    }

    public function deleteIndia($id)
    {
        Log::debug('Deleting india in IndiaService', ['id' => $id]);
        $india = $this->indiaRepository->find($id);
        if ($india) {
            $india->delete();

            return true;
        }

        return false;
    }
}