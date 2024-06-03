<?php

namespace App\Feature\CityMaster\Repositories;

use App\Feature\CityMaster\Models\CityMaster;

class CityMasterRepository
{
    /**
     * Create a new CityMaster.
     *
     * @param array $data
     * @return \App\Feature\CityMaster\Models\CityMaster
     */
    public function create(array $data)
    {
        return CityMaster::create($data);
    }

    /**
     * Find a CityMaster by ID.
     *
     * @param int $id
     * @return \App\Feature\CityMaster\Models\CityMaster|null
     */
    public function find($id)
    {
        return CityMaster::find($id);
    }

//     public function findByCityNameEng($cityNameEng)
// {
//     return CityMaster::where('CityNameEng', $cityNameEng)->first();
// }

   public function findByCityNameAndTaluka($cityNameEng, $taluka)
{
    return CityMaster::where('CityNameEng', $cityNameEng)
                     ->where('Taluka', $taluka)
                     ->first();
}

}