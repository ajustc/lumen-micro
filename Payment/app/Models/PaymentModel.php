<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'name',
        'bank',
        'price',
        'date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
