<?php

namespace App;


namespace App\Feature\PickupRequestNote\Repositories;

use App\Feature\PickupRequestNote\Models\PickupRequestNote;

class PickupRequestNoteRepository
{
    public function create(array $data): PickupRequestNote
    {
        // Create and return a new PickupRequestNote model
        return PickupRequestNote::create($data);
    }

    public function find($id): ?PickupRequestNote
    {
        // Return null if the record is not found
        return PickupRequestNote::find($id);
    }

    // Add other methods as needed for specific queries or repository functionalities
}