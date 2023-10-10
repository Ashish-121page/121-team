<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockEnquiry extends Model
{
    use HasFactory;
    protected $table = 'locked_enquiry';
    protected $guarded = ['id'];
}
