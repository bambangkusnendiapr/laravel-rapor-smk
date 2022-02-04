<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $user = User::create([
                'name' => $row['nama'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'position_id' => $row['id_jabatan'],
                'nip' => $row['nip'],
                'kode' => $row['kode'],
            ]);

            $user->attachRole('guru');
            
        }
    }
}
