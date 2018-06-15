<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public function SocialChannels()
    {
        return $this->hasMany('App\SocialChannel');
    }
}
