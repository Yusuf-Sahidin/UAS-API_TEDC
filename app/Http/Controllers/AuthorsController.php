<?php
  namespace App\Http\Controllers;

  use App\Models\Author;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Gate;
  use Illuminate\Support\Facades\Auth;

  class AuthorsController extends Controller{
    public function index(Request $request){

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }
      if(Auth::user() -> role == 'user'){
        $authors = Author::with('user') -> OrderBy("id_author", "DESC") -> paginate(2) -> toArray();
      }else{
        return false;
      }

      $response = [
        "total_count" => $authors["total"],
        "limit" => $authors["per_page"],
        "pagination" => [
          "next_page" => $authors["next_page_url"],
          "current_page" => $authors["current_page"]
        ],
        "data" => $authors["data"]
      ];

      return response() -> json($response, 200);
    }

    public function show($id){
      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }
      if(Auth::user() -> role == 'user'){
        $author = Author::with(['user'=> function ($query){
          $query -> select('id_user', 'email');
        }]) -> Where('id_author', $id) -> first();
      }else{
        return false;
      }
      
      if(!$author){
        abort(404);
      }

      return response() -> json($author, 200);
    }

    public function store(Request $request){
      $input = $request -> all();

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }

      $validationRules = [
        'nama_author' => 'required|min:10',
        'deskripsi_diri' => 'required|min:20'
      ];
      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }
      
      $author = Author::with(['user'=> function ($query){
        $query -> select('id_user', 'email');
      }]) -> Where('id_user', Auth::user() -> id_user) -> first();

      if(!$author){
        $author = new Author;
        $author -> id_user = Auth::user() -> id_user; 
      }

      $author -> nama_author = $request -> input('nama_author');
      $author -> deskripsi_diri = $request -> input('deskripsi_diri');

      $author -> save();

      return response() -> json($author, 200);
    }

    public function destroy($id){
      $author = Author::where('id_author', $id) -> first();

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }

      if(!$author){
        abort(404);
      }

      $author -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id_author' => $id
      ];

      return response() -> json($message, 200);
    }
  }
?>