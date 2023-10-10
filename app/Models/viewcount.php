<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class viewcount extends Model
{
    use HasFactory;
    protected $table = 'view_count';
    protected $guarded = [];
}
