<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Nanti extends Model{
    protected $primaryKey = 'id';
    protected $table = 'baca_nanti';
    protected $fillable = array(
      'id_user',
      'id_daftar_bacaan',
    );
    public $timestamps = true;

    public function daftar(){
      return $this -> belongsTo('App\Models\Daftar', 'id_daftar_bacaan');
    }

    public function user(){
      return $this -> belongsTo('App\Models\User', 'id_user');
    } 
  }
?>