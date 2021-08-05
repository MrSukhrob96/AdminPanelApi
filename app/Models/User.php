<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  protected $guarded = ['id'];

  protected $hidden = ['password'];

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function permissions()
  {
    return $this->role->permissions->pluck('name');
  }
}
