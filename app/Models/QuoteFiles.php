<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFiles extends Model
{
    use HasFactory;
    protected $table = 'quotation_files';
    protected $guarded = [];
}
