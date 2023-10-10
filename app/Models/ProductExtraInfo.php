<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExtraInfo extends Model
{
    use HasFactory;
    protected $table = 'extra_product_info';
    protected $guarded = [];

}
