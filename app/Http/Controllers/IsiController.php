<?php
  namespace App\Http\Controllers;

  use App\Models\Isi;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Gate;
  use Illuminate\Support\Facades\Auth;

  class IsiController extends Controller{
    public function index(Request $request){
      $isii = Isi::with('daftar', 'author') -> OrderBy("id", "DESC") -> paginate(2) -> toArray();
      $response = [
        "total_count" => $isii["total"],
        "limit" => $isii["per_page"],
        "pagination" => [
          "next_page" => $isii["next_page_url"],
          "current_page" => $isii["current_page"]
        ],
        "data" => $isii["data"]
      ];

      return response() -> json($response, 200);
    }

    public function show($id){
      $isi = Isi::with('daftar', 'author') -> where('id', $id) -> first();
      
      if(!$isi){
        abort(404);
      }

      return response() -> json($isi, 200);
    }

    public function store(Request $request){
      $input = $request -> all();

      $validationRules = [
        'id_author' => 'required|exists:info_author,id_author',
        'id_daftar_bacaan' => 'required|exists:daftar_bacaan,id_daftar_bacaan',
        'chapter' => 'required|min:1|unique:isi_bacaan',
        'isi_cerita' => 'required|min:20'
      ];

      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $isi = Isi::create($input);
      return response() -> json($isi, 200);
    }

    public function edit(Request $request, $id){
      $input = $request -> all();

      $isi = Isi::find($id);

      if(!$isi){
        abort(404);
      }

      $validationRules = [
        'id_author' => 'required|exists:info_author,id_author',
        'id_daftar_bacaan' => 'required|exists:daftar_bacaan,id_daftar_bacaan',
        'chapter' => 'required|min:1|unique:isi_bacaan',
        'isi_cerita' => 'required|min:20'
      ];
      
      $validator = \Validator::make($input, $validationRules);
      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $isi -> fill($input);
      $isi -> save();

      return response() -> json($isi, 200);
    }

    public function destroy($id){
      $isi = Isi::where('id', $id) -> first();

      if(!$isi){
        abort(404);
      }

      $isi -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id' => $id
      ];

      return response() -> json($message, 200);
    }
  }

?>