<?php

namespace App\Feature\Expenses\Services;





use App\Feature\Expenses\Models\InRouteExpenses;
use App\Feature\Expenses\Repositories\InRouteExpensesRepository;
use Illuminate\Support\Facades\Log;

class InRouteExpensesService
{
    protected $inRouteExpensesRepository;

    public function __construct(InRouteExpensesRepository $inRouteExpensesRepository)
    {
        $this->inRouteExpensesRepository = $inRouteExpensesRepository;
    }

    public function createInRouteExpenses(array $data)
    {
        Log::info('In createInRouteExpenses Method in Service');

        return $this->inRouteExpensesRepository->create($data);
    }

    public function getInRouteExpensesById($id)
    {
        return $this->inRouteExpensesRepository->find($id);
    }

    public function getAllInRouteExpensess($request)
    {
        $query = InRouteExpenses::query();

        // Filtering logic can be added here based on the request parameters

        // Sorting logic
        $sortBy = $request->get('sort_by', 'updated_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);

        return $query->paginate($perPage);
    }

    public function updateInRouteExpenses($id, array $data)
    {
        $inRouteExpenses = $this->inRouteExpensesRepository->find($id);
        if ($inRouteExpenses) {
            $inRouteExpenses->update($data);
        }

        return $inRouteExpenses;
    }

    public function deactivateInRouteExpenses($id)
    {
        Log::debug('Deactivating inRouteExpenses in InRouteExpensesService', ['id' => $id]);
        $inRouteExpenses = $this->inRouteExpensesRepository->find($id);
        if ($inRouteExpenses) {
            $inRouteExpenses->update(['status' => 'DEACTIVATED']);

            return $inRouteExpenses;
        }

        return null; // Handle the case where the India is not found
    }

    public function deleteInRouteExpenses($id)
    {
        Log::debug('Deleting india in InRouteExpensesService', ['id' => $id]);
        $inRouteExpenses = $this->inRouteExpensesRepository->find($id);
        if ($inRouteExpenses) {
            $inRouteExpenses->delete();

            return true;
        }

        return false;
    }
}
