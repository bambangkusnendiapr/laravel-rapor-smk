<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Major;
use App\Models\Master\Lesson;
use App\Models\Teacher;

class PelajaranGuru extends Model
{
    use HasFactory;

    protected $table = 'pelajaran_guru';

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
