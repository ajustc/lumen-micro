<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    protected $table = 'orders_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',	
        'product_id',
        'name',	
        'qty',	
        'price',	
        'weight',	
        'sub_weight',	
        'sub_price',	
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
