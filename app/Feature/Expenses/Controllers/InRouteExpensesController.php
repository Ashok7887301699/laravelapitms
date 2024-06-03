<?php


namespace App\Feature\Expenses\Controllers;


use App\Http\Controllers\Controller;

use App\Feature\Expenses\Requests\InRouteExpensesStoreRequest;


use App\Feature\Expenses\Services\InRouteExpensesService;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class InRouteExpensesController extends Controller
{
    protected $inRouteExpensesService;

    public function __construct(InRouteExpensesService $inRouteExpensesService)
    {
        $this->inRouteExpensesService = $inRouteExpensesService;
    }

    public function store(InRouteExpensesStoreRequest $request)
    {
        Log::debug('InRouteExpenses store method called in InRouteExpensesController');
        $validatedData = $request->validated();
        $inRouteExpenses = $this->inRouteExpensesService->createInRouteExpenses($validatedData);

        if ($inRouteExpenses) {
            return response()->json($inRouteExpenses, 201); // 201 Created
        } else {
            // Log the error
            Log::error('Failed to create In Route Expenses in InRouteExpensesController@store', ['request' => $validatedData]);

            // Return an error response
            return response()->json([
                'message' => 'Failed to create In Route Expenses',
                'errors' => 'There was an error processing the request',
            ], 500); // 500 Internal Server Error
        }
    }

    public function show($id)
    {
        Log::debug("InRouteExpenses show method called in InRouteExpensesController for ID: $id");
        $inRouteExpenses = $this->inRouteExpensesService->getInRouteExpensesById($id);

        if (! $inRouteExpenses) {
            Log::error("In Route Expenses with ID: $id not found in InRouteExpensesController@show");

            return response()->json(['message' => 'In Route Expenses not found'], 404);
        }

        return response()->json($inRouteExpenses);
    }

    public function index(Request $request)
    {
        Log::debug('InRouteExpenses index method called in InRouteExpensesController');

        try {
            $inRouteExpenses = $this->inRouteExpensesService->getAllInRouteExpensess($request);

            if ($inRouteExpenses->isEmpty()) {
                Log::info('No In Route Expensesfound in InRouteExpensesController@index');
            }

            return response()->json($inRouteExpenses);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in InRouteExpensesController@index: '.$e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching In Route Expenses',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(InRouteExpensesStoreRequest $request, $id)
    {
        Log::debug("InRouteExpenses update method called in InRouteExpensesController for ID: $id");
        $validatedData = $request->validated(); // This line retrieves the validated data from the request
        $inRouteExpenses = $this->inRouteExpensesService->updateInRouteExpenses($id, $validatedData);
    
        if (! $inRouteExpenses) {
            Log::error("In Route Expenses with ID: $id not found in InRouteExpensesController@update");
    
            return response()->json(['message' => 'In Route Expenses not found'], 404);
        }
    
        return response()->json($inRouteExpenses);
    }

    public function deactivate(InRouteExpensesStoreRequest $request, $id)
    {
        Log::debug("Deactivating In Route Expenses with ID: $id in InRouteExpensesController");
        $inRouteExpenses = $this->inRouteExpensesService->deactivateInRouteExpenses($id);

        if ($inRouteExpenses) {
            Log::info("In Route Expenses with ID: $id deactivated successfully");
            $response = $inRouteExpenses->toArray();
            $response['message'] = 'In Route Expenses deactivated successfully';

            return response()->json($response, 200);
        }

        Log::error("In Route Expenses with ID: $id not found for deactivation");

        return response()->json(['message' => 'In Route Expenses not found'], 404);
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete In Route Expenses with ID: $id in InRouteExpensesController");
        if ($this->inRouteExpensesService->deleteInRouteExpenses($id)) {
            Log::info("In Route Expenses with ID: $id deleted successfully");

            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'In Route Expenses deleted successfully'], 200);
        }

        Log::error("In Route Expenses with ID: $id not found for deletion");

        return response()->json(['id' => $id, 'message' => 'In Route Expenses not found'], 404);
    }
}
