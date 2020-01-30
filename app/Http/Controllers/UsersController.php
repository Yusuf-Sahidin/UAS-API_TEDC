<?php
  namespace App\Http\Controllers;

  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Gate;
  use Illuminate\Support\Facades\Auth;

  class UsersController extends Controller{
    public function index(Request $request){

      if(Gate::denies('admin')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }
      if(Auth::user() -> role == 'admin'){
        $users = User::OrderBy("id_user", "DESC") -> paginate(2) -> toArray();
      }else{
        return false;
      }
      
      $response = [
        "total_count" => $users["total"],
        "limit" => $users["per_page"],
        "pagination" => [
          "next_page" => $users["next_page_url"],
          "current_page" => $users["current_page"]
        ],
        "data" => $users["data"]
      ];

      return response() -> json($response, 200);
    }

    public function show($id){

      if(Gate::denies('admin')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }
      if(Auth::user() -> role == 'admin'){
        $user = User::where('id_user', $id) -> first();
      }else{
        return false;
      }

      if(!$user){
        abort(404);
      }

      return response() -> json($user, 200);
    }

    public function destroy($id){
      $user = User::where('id_user', $id) -> first();

      if(!$user){
        abort(404);
      }

      if(Gate::denies('admin')){
        return response() -> json([
          'success' => false,
          'status' => 403,
          'message' => 'you are unauthorized'
        ], 403);
      }

      $user -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id_user' => $id
      ];

      return response() -> json($message, 200);
    }
  }
?>