<?php
  namespace App\Http\Controllers;

  use App\Models\Daftar;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Gate;
  use Illuminate\Support\Facades\Auth;

  class DaftarController extends Controller{
    public function index(Request $request){
      $daftars = Daftar::with('author') -> OrderBy("id_daftar_bacaan", "DESC") -> paginate(2) -> toArray();
      $response = [
        "total_count" => $daftars["total"],
        "limit" => $daftars["per_page"],
        "pagination" => [
          "next_page" => $daftars["next_page_url"],
          "current_page" => $daftars["current_page"]
        ],
        "data" => $daftars["data"]
      ];

      return response() -> json($response, 200);
    }

    public function show($id){
      $daftar = Daftar::with('author') -> where('id_daftar_bacaan', $id) -> first();
      
      if(!$daftar){
        abort(404);
      }

      return response() -> json($daftar, 200);
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
        'judul' => 'required|min:5',
        'id_author' => 'required|exists:info_author,id_author',
        'sinopsis' => 'required|min:10'
      ];

      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $daftar = Daftar::create($input);
      return response() -> json($daftar, 200);
    }

    public function edit(Request $request, $id){
      $input = $request -> all();

      $daftar = Daftar::find($id);

      if(!$daftar){
        abort(404);
      }

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }

      $validationRules = [
        'judul' => 'required|min:5',
        'id_author' => 'required|exists:info_author,id_author',
        'sinopsis' => 'required|min:10'
      ];
      
      $validator = \Validator::make($input, $validationRules);
      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $daftar -> fill($input);
      $daftar -> save();

      return response() -> json($daftar, 200);
    }

    public function destroy($id){
      $daftar = Daftar::where('id_daftar_bacaan', $id) -> first();

      if(!$daftar){
        abort(404);
      }

      $daftar -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id_daftar_bacaan' => $id
      ];

      return response() -> json($message, 200);
    }
  }
?>