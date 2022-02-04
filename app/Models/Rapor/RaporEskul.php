<?php

namespace App\Models\Rapor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Extracurricular;

class RaporEskul extends Model
{
    use HasFactory;

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }
}
