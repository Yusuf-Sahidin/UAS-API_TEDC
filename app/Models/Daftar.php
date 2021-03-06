<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Daftar extends Model{
    protected $primaryKey = 'id_daftar_bacaan';
    protected $table = 'daftar_bacaan';
    protected $fillable = array(
      'judul',
      'id_author',
      'sinopsis'
    );
    public $timestamps = true;

    public function author(){
      return $this -> belongsTo('App\Models\Author', 'id_author');
    }

    public function isi(){
      return $this -> hasMany('App\Models\Isi', 'id_daftar_bacaan');
    }

    public function nanti(){
      return $this -> hasMany('App\Models\Nanti', 'id_daftar_bacaan');
    }
  }
?>