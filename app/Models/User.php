<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class User extends Model{
    protected $primaryKey = 'id_user';
    protected $fillable = array(
      'email',
      'password',
      'role'
    );

    public $timestamps = true;
  }
?>