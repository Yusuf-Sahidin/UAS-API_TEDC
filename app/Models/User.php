<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  use Illuminate\Auth\Authenticatable;
  use Laravel\Lumen\Auth\Authorizable;
  use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
  use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

  use Tymon\JWTAuth\Contracts\JWTSubject;

  class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject{
    use Authenticatable, Authorizable;

    protected $primaryKey = 'id_user';
    protected $fillable = array(
      'email',
      'password',
      'role'
    );
    protected $hidden = [
      'password'
    ];

    public $timestamps = true;

    public function getJWTIdentifier(){
      return $this -> getKey();
    }
    public function getJWTCustomClaims(){
      return [];
    }
  }
?>