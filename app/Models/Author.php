<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Author extends Model{
    protected $primaryKey = 'id_author';
    protected $table = 'info_author';
    protected $fillable = array(
      'id_user',
      'nama_author',
      'deskripsi_diri'
    );

    public $timestamps = true;
  }
?>