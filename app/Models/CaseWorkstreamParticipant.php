<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CaseWorkstreamParticipant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'case_workstream_participants';
    protected $guarded = [];
}
