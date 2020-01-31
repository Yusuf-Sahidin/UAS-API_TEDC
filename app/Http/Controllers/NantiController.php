<?php
    namespace App\Http\Controllers;

    use App\Models\Nanti;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Gate;
  use Illuminate\Support\Facades\Auth;

  class NantiController extends Controller{
    public function index(Request $request){

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }
      if(Auth::user() -> role == 'user'){
        $nantis = Nanti::with('user', 'daftar') -> Where(['id_user' => Auth::user() -> id_user]) -> OrderBy("id", "DESC") -> paginate(2) -> toArray();
      }else{
        return false;
      }

      $response = [
        "total_count" => $nantis["total"],
        "limit" => $nantis["per_page"],
        "pagination" => [
          "next_page" => $nantis["next_page_url"],
          "current_page" => $nantis["current_page"]
        ],
        "data" => $nantis["data"]
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
        $nanti = Nanti::with('user', 'daftar') -> Where(['id_user' => Auth::user() -> id_user]) -> where('id', $id) -> first();
      }else{
        return false;
      }
      
      if(!$nanti){
        abort(404);
      }

      return response() -> json($nanti, 200);
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
        'id_daftar_bacaan' => 'required|exists:daftar_bacaan,id_daftar_bacaan'
      ];

      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $nanti = Nanti::create($input);
      return response() -> json($nanti, 200);
    }

    public function destroy($id){
      $nanti = Nanti::where('id', $id, ['id_user' => Auth::user() -> id_user]) -> first();

      if(!$nanti){
        abort(404);
      }

      if(Gate::denies('userOnly')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }

      $nanti -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id' => $id
      ];

      return response() -> json($message, 200);
    }
  }
?>