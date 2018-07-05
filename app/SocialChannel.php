<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Social;

class SocialChannel extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'type', 'category', 'access_token', 'access_token_secret', 'social_id', 'user_id', 'channel_id', 'channel_URL'
    ];

    public $timestamps = true;

    public function socials()
    {
        return $this
            ->hasOne('App\Social','id', 'social_id');
    }

    public function users()
    {
        return $this
            ->hasOne('App\User')
            ->withTimestamps();
    }

}
