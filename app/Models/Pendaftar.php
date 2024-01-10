<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walisantri()
    {
        return $this->belongsTo(Walisantri::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
