<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
   use Authenticatable, CanResetPassword;

   protected $table = 'users';

   protected $fillable = ['userId', 'name', 'email', 'wallet_address', 'phone', 'sponsorId', 'placementId', 'networkId', 'order', 'role', 'position', 'p_num', 'password'];

   protected $hidden = ['password', 'remember_token'];

   public function isAdmin()
   {
      return $this->role === 'admin';
   }

   public function isUser()
   {
      return $this->role === 'user';
   }

   public function childLists()
   {
      $user = Session::get('user');   // Session User Data
      $userId = $user->userId;

      $child_users = DB::table('users')->where(['sponsorId' => $userId])
         // ->orderBy('menu_sort', 'ASC')
         ->get();

      return $child_users;
   }
}
