<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',	
        'purchase_total',	
        'address',	
        'status',	
        'delivery_receipt',	
        'total_weight',	
        'province',	
        'district',	
        'type',	
        'postal_code',	
        'courier',	
        'package',	
        'cost',	
        'estimate',	
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
