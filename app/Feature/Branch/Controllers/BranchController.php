<?php

namespace App\Feature\Branch\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Branch\Requests\BranchStoreRequest;
use App\Feature\Branch\Services\BranchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Feature\Branch\Models\Branch;

class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(Request $request)
    {
        Log::info('Branch index method called in BranchController');
        $branches = $this->branchService->getAllBranches($request);

        return response()->json($branches);
    }

    public function store(BranchStoreRequest $request)
    {
        $validatedData = $request->validated();

        $uploadBranch = $request->file('UploadBranch');
        $uploadShopAct = $request->file('UploadShopAct');

        $branchPhotoFilename = $validatedData['BranchCode'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $uploadBranch->getClientOriginalExtension();
        $shopActFilename = $validatedData['BranchCode'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $uploadShopAct->getClientOriginalExtension();

        Storage::makeDirectory('public/Branch/branchPhoto');
        Storage::makeDirectory('public/Branch/shopAct');

        $branchPhotoPath = $uploadBranch->storeAs(
            'public/Branch/branchPhoto',
            $branchPhotoFilename
        );
        $shopActPath = $uploadShopAct->storeAs(
            'public/Branch/shopAct',
            $shopActFilename
        );

        $validatedData['UploadBranch'] = asset($branchPhotoPath);
        $validatedData['UploadShopAct'] = asset($shopActPath);

        $validatedData['Status'] = 'ACTIVE';

        $branch = $this->branchService->createBranch($validatedData);

        return response()->json($branch, 201);
    }


    // public function store(BranchStoreRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     $uploadBranch = $request->file('UploadBranch');
    //     $uploadShopAct = $request->file('UploadShopAct');

    //     $branchPhotoFilename = $validatedData['BranchCode'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $uploadBranch->getClientOriginalExtension();
    //     $shopActFilename = $validatedData['BranchCode'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $uploadShopAct->getClientOriginalExtension();

    //     Storage::makeDirectory('public/Branch/branchPhoto');
    //     Storage::makeDirectory('public/Branch/shopAct');

    //     $baseLaravelUrl = 'http://127.0.0.1:8000/';

    //     $branchPhotoPath = $baseLaravelUrl . 'storage/' . $uploadBranch->storeAs(
    //         'public/Branch/branchPhoto',
    //         $branchPhotoFilename
    //     );
    //     $shopActPath = $baseLaravelUrl . 'storage/' . $uploadShopAct->storeAs(
    //         'public/Branch/shopAct',
    //         $shopActFilename
    //     );

    //     $validatedData['UploadBranch'] = $branchPhotoPath;
    //     $validatedData['UploadShopAct'] = $shopActPath;

    //     $branch = $this->branchService->createBranch($validatedData);

    //     return response()->json($branch, 201);
    // }

    public function show($branchCode)
    {
        Log::info('Branch show method called in BranchController');
        $branch = $this->branchService->getBranchByCode($branchCode);

        return response()->json($branch);
    }

    public function update(Request $request, $branchCode)
    {
        $branch = $this->branchService->updateBranch($branchCode, $request->all());

        return response()->json($branch);
    }

    public function deactivate(Request $request, $branchCode)
    {
        $response = $this->branchService->deactivateBranch($branchCode);

        if (is_string($response)) {
            // Branch is already deactivated, return the response
            return response()->json(['message' => $response], 200);
        }

        if (!$response) {
            // Branch not found, return 404 response
            return response()->json([
                'Branch Code' => $branchCode,
                'message' => 'Branch not found',
            ], 404);
        }

        // Branch successfully deactivated, return the branch information
        return response()->json(['data' => $response->toArray()], 200);
    }

    public function destroy($branchCode)
    {
        if ($this->branchService->deleteBranch($branchCode)) {
            return response()->json([
                'Branch Code' => $branchCode,
                'deleted' => true,
                'message' => 'Branch deleted successfully',
            ], 200);
        }

        return response()->json([
            'Branch Code' => $branchCode,
            'message' => 'Branch not found',
        ], 404);
    }

    public function getAllBranchNames(Request $request)
    {
        Log::info('Branch names method called in BranchController');
        $branchNames = $this->branchService->getAllBranchNamesOnly($request);

        return response()->json($branchNames);
    }

    public function getAllBranchCodes(Request $request)
    {
        Log::info('fetching only branch codes in BranchController');
        $branchCodes = $this->branchService->getAllBranchCodesOnly($request);

        return response()->json($branchCodes);
    }

    public function getBranchPhoto($branchCode)
    {
        $branch = $this->branchService->getBranchByCode($branchCode);
        if ($branch) {
            $photoPath = asset($branch->UploadBranch);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $photoPath)));
        } else {
            abort(404);
        }
    }

    public function getShopAct($branchCode)
    {
        $branch = $this->branchService->getBranchByCode($branchCode);
        if ($branch) {
            $shopActPath = asset($branch->UploadShopAct);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $shopActPath)));
        } else {
            abort(404);
        }
    }

    // public function getBranchPhoto($filename)
    // {
    //     $path = 'public/Branch/branchPhoto/' . $filename;
    //     if (Storage::exists($path)) {
    //         return response()->file(storage_path('app/' . $path));
    //     } else {
    //         abort(404);
    //     }
    // }

    // public function getShopAct($filename)
    // {
    //     $path = 'public/Branch/shopAct/' . $filename;
    //     if (Storage::exists($path)) {
    //         return response()->file(storage_path('app/' . $path));
    //     } else {
    //         abort(404);
    //     }
    // }

    public function getBrancodes()
    {
        try {
            // Fetch only userbranches fields from the userbranches table
            $userbranches = Branch::select('BranchCode')->get();

            // Check if userbranches were found
            if ($userbranches->isEmpty()) {
                return response()->json(['message' => 'No userbranches found'], 404);
            }

            // Return the userbranches as JSON response
            return response()->json($userbranches, 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to fetch userbranches'], 500);
        }
    }

}
