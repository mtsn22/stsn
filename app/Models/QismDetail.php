<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QismDetail extends Model
{
    use HasFactory;

    public function qism()
    {
        return $this->belongsTo(Qism::class);
    }
}
