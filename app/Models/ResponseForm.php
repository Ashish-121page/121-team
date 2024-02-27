<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseForm extends Model
{
    use HasFactory;
    protected $table = 'form_response';
    protected $guarded = [];

}
