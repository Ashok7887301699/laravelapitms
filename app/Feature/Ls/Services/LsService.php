<?php

namespace App\Feature\Ls\Services;
use App\Feature\Ls\Repositories\LsRepository;
use App\Feature\Ls\Models\GetLrData;
use App\Feature\Ls\Models\FbConsignmentDetail;
use App\Feature\Ls\Models\LsLr;
use App\Feature\Ls\Requests\LsRequests;
class LsService
{

    protected $lsRepository;

    public function __construct(LsRepository $lsRepository)
    {
        $this->lsRepository = $lsRepository;
    }

    // public function store(LsRequests $request)
    // {
    //     // Validate the incoming request
    //     $validatedData = $request->validated();

    //     // Manually set the ID for the ls record
    //     $validatedData['id'] = 'PNA24005'; // Assuming 'PNA24001' is the desired ID format


    //     // Create the record in the fm_ls table
    //     $ls = $this->lsRepository->createLs($validatedData);
    //     // Create the record in the fm_ls_lr table
    //     $lsLrData = [
    //         'ls_id' => $ls->id, // Assuming this is the foreign key linking to the fm_ls table
    //         'lr_id' => $validatedData['lr_id'], // Provided lr_id
    //         'seq_num' => $validatedData['seq_num'],
    //         // 'tenant_id' => $validatedData['tenant_id'],
    //         'dated' => $validatedData['dated'],
    //         'del_depot' => $validatedData['del_depot'],
    //         'from_depot' => $validatedData['from_depot'],
    //         'to_depot' => $validatedData['to_depot'],
    //         'freight_charges' => $validatedData['freight_charges'],


    //     ];

    //     $this->lsRepository->createLsLr($lsLrData);

    //     // You can return any response as needed
    //     return ['message' => 'Data saved successfully'];
    // }


    public function createLs(array $data)
    {
        return $this->lsRepository->create($data);
    }

    public function createLsLrDetail(array $data)
{
    return LsLr::create($data);
}

    public function getlrby($query)
    {

        return GetLrData::where('id', 'like', '%' . $query . '%')
        ->where(function ($query) {
            $query->where('status', 1)
                  ->orWhere('status', 6);
        })
        ->select('id')
        ->get();
    }

    public function getLrDetailsByIdWithJoin($query)
    {
        $lrDetails = GetLrData::join('fb_consignment', 'fb_lr.id', '=', 'fb_consignment.lr_id')
            ->select(
                'fb_consignment.lr_id',
                'fb_lr.booking_date_time',
                'fb_lr.payment_type',
                'fb_lr.from_place',
                'fb_lr.to_place',
                'fb_lr.docket_total_charges',
                'fb_consignment.num_of_pkgs',
                'fb_consignment.actual_weight_per_pkg'
            )
            ->where('fb_lr.id', $query)
            ->first();

        return $lrDetails;
    }

}
