<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Kelas;
use App\Models\Master\Major;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function ortu()
    {
        return $this->belongsTo(Ortu::class);
    }
}
