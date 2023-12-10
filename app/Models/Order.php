<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["order_date", "total_amount", "total_price", "user_id"];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
