<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    protected $table = 'tags';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
