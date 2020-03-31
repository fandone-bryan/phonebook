<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  public function phones()
  {
      return $this->hasMany('App\Phone');
  }
}
