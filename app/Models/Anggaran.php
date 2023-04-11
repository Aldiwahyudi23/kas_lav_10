<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
