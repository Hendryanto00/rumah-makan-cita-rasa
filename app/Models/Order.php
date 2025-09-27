<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','order_date','status','total_amount'];
    public function details(){ return $this->hasMany(OrderDetail::class); }
    public function payment(){ return $this->hasOne(Payment::class); }
}
