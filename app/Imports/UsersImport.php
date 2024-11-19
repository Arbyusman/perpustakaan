<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $rowIndex = 0;
    public function model(array $row)
    {
        $this->rowIndex++;
        return new User([
            'name' => $row[1],
            'email' => str_replace(' ', '_', $row[1]) . "@gmail.com",
            'identification_number' => $row[0],
            'password'              => Hash::make($row[0]),
            'role_id'               => 3,
            'finger_id'               => $row[0],
            'email_verified_at'     => now(),
        ]);
    }
}
