<?php
  namespace App\Http\Controllers;

  use App\Models\Author;
  use Illuminate\Http\Request;

  class AuthorsController extends Controller{
    public function index(Request $request){
      $authors = Author::OrderBy("id_author", "DESC") -> paginate(2) -> toArray();
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
      $author = Author::where('id_author', $id) -> first();

      if(!$author){
        abort(404);
      }

      return response() -> json($author, 200);
    }

    public function store(Request $request){
      $input = $request -> all();

      $validationRules = [
        'id_user' => 'required|exists:users,id_user',
        'nama_author' => 'required|min:10',
        'deskripsi_diri' => 'required|min:20'
      ];
      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $author = Author::create($input);

      return response() -> json($author, 200);
    }

    public function edit(Request $request, $id){
      $input = $request -> all();
      $author = Author::where('id_author', $id) -> first();

      if(!$author){
        abort(404);
      }

      $validationRules = [
        'id_user' => 'required|exists:users,id_user',
        'nama_author' => 'required|min:10',
        'deskripsi_diri' => 'required|min:20'
      ];
      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }
      
      $author -> fill($input);
      $author -> save();

      return response() -> json($author, 200);
    }

    public function destroy($id){
      $author = Author::where('id_author', $id) -> first();

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