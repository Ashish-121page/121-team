<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeandActionModal extends Model
{
    use HasFactory;
    protected $table = 'time_and_action';
    protected $guarded = ['id'];
    
}
