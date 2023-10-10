<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAskItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function price_ask_item(){
        return $this->belongsTo(PriceAskRequest::class);
    }
}
