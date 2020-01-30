<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Isi extends Model{
    protected $primaryKey = 'id';
    protected $table = 'isi_bacaan';
    protected $fillable = array(
      'id_author',
      'id_daftar_bacaan',
      'chapter',
      'isi_cerita'
    );
    public $timestamps = true;

    public function daftar(){
      return $this -> belongsTo('App\Models\Daftar', 'id_daftar_bacaan');
    }

    public function author(){
      return $this -> belongsTo('App\Models\Author', 'id_author');
    } 
  }
?>