<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseWorkstream extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'case_workstreams';
    protected $guarded = [];
}
