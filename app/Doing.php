<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doing extends Model
{
    protected $fillable = ['name', 'description', 'date', 'user_id', 'period_id'];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function period()
    {
      return $this->belongsTo('App\Period');
    }

}
