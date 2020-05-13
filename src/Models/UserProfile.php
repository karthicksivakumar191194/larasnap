<?php

namespace LaraSnap\LaravelAdmin\Models;

use LaraSnap\LaravelAdmin\Models\BaseModel;

class UserProfile extends BaseModel
{
    protected $table = 'userprofiles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'mobile_no', 'address', 'state', 'city', 'pincode', 'user_photo'
    ];
}
