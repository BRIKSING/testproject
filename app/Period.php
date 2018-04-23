<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public function doing()
    {
      return $this->hasMany('App\Doing');
    }
}
