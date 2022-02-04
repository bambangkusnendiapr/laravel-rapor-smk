<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use App\Models\Ortu;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
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
            $user_ortu = User::create([
                'name' => $row['nama_ortu'],
                'email' => $row['email_ortu'],
                'password' => bcrypt($row['password_ortu']),
            ]);

            $ortu = Ortu::create([
                'user_id' => $user_ortu->id,
            ]);

            $user_ortu->attachRole('orang_tua');

            $user_siswa = User::create([
                'name' => $row['nama_siswa'],
                'email' => $row['email_siswa'],
                'password' => bcrypt($row['password_siswa']),
            ]);

            $user_siswa->attachRole('siswa');

            $student = Student::create([
                'user_id' => $user_siswa->id,
                'major_id' => $row['id_jurusan'],
                'ortu_id' => $ortu->id,
                'kelas' => $row['kelas'],
                'nis' => $row['nis'],
            ]);

            
        }
    }
}
