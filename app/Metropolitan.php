<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Metropolitan extends Authenticatable
{
    use Notifiable;
	protected $table = 'metropolitan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'email', 'verified', 'last_name', 'picture', 'mac',
    ];
}