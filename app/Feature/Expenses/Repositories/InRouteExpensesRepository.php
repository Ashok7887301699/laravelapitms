<?php

namespace App\Feature\Expenses\Repositories;

use App\Feature\Expenses\Models\InRouteExpenses;

class InRouteExpensesRepository
{
    public function create(array $data): InRouteExpenses
    {
        return InRouteExpenses::create($data);
    }

    public function find($id)
    {
        return InRouteExpenses::find($id);
    }

    public function delete($id)
    {
        $inRouteExpenses = InRouteExpenses::find($id);
        if ($inRouteExpenses) {
            return $inRouteExpenses->delete();
        }
        return false;
    }
}
