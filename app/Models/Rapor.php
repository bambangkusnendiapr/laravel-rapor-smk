<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Major;
use App\Models\Master\Semester;
use App\Models\Rapor\PesantrenEskul;
use App\Models\Rapor\RaporEskul;
use App\Models\Rapor\RaporPrestasi;

class Rapor extends Model
{
    use HasFactory;

    protected $dates = ['tanggal'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function pesantreneskul()
    {
        return $this->hasMany(PesantrenEskul::class);
    }

    public function raporeskul()
    {
        return $this->hasMany(RaporEskul::class);
    }

    public function raporprestasi()
    {
        return $this->hasMany(RaporPrestasi::class);
    }
}
