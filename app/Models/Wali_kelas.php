<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Major;
use App\Models\Teacher;

class Wali_kelas extends Model
{
    use HasFactory;

    protected $table = 'major_teacher';

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
