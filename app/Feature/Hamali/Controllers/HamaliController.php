<?php

namespace App\Feature\Hamali\Controllers;

use App\Feature\Hamali\Requests\HamaliStoreRequest;
use App\Feature\Hamali\Services\HamaliService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HamaliController extends Controller
{
    protected $hamaliService;

    public function __construct(HamaliService $hamaliService)
    {
        $this->hamaliService = $hamaliService;
    }

    public function store(HamaliStoreRequest $request)
    {
        Log::info('Hamali store method called in HamaliController');
        $validatedData = $request->validated();
        $hamali = $this->hamaliService->createHamali($validatedData);

        return response()->json($hamali, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('Hamali show method called in HamaliController');
        $hamali = $this->hamaliService->getHamaliById($id);

        return response()->json($hamali);
    }

    public function index(Request $request)
    {
        Log::info('Hamali index method called in HamaliController');
        $hamalis = $this->hamaliService->getAllHamali($request);

        return response()->json($hamalis);
    }

    public function update(Request $request, $id)
    {
        $hamali = $this->hamaliService->updateHamali($id, $request->all());

        return response()->json($hamali);
    }

    public function deactivate($id)
    {
        $hamali = $this->hamaliService->deactivateHamali($id);
        if ($hamali) {
            $response = $hamali->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'Hamali deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Hamali not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->hamaliService->deleteHamali($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'Hamali deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Hamali not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
