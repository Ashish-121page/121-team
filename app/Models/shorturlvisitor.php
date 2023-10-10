<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shorturlvisitor extends Model
{
    use HasFactory;
    protected $table = 'short_url_visit';
    protected $guarded = [];
}
