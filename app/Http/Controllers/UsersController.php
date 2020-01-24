<?php
  namespace App\Http\Controllers;

  use App\Models\User;
  use Illuminate\Http\Request;

  class UsersController extends Controller{
    public function index(Request $request){
      $users = User::OrderBy("id_user", "DESC") -> paginate(2) -> toArray();
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

    public function show($id_user){
      $user = User::where('id_user', $id_user) -> first();

      if(!$user){
        abort(404);
      }

      return response() -> json($user, 200);
    }

    public function store(Request $request){
      $input = $request -> all();

      $validationRules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,user'
      ];
      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }

      $user = User::create($input);

      return response() -> json($user, 200);
    }


    public function edit(Request $request, $id_user){
      $input = $request -> all();
      $user = User::where('id_user', $id_user) -> first();

      if(!$user){
        abort(404);
      }

      $validationRules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,user'
      ];
      $validator = \Validator::make($input, $validationRules);

      if($validator -> fails()){
        return response() -> json($validator -> errors(), 400);
      }
      
      $user -> fill($input);
      $user -> save();

      return response() -> json($user, 200);
    }

    public function destroy($id_user){
      $user = User::where('id_user', $id_user) -> first();

      if(!$user){
        abort(404);
      }

      $user -> delete();
      $message = [
        'message' => 'berhasil menghapus',
        'id_user' => $id_user
      ];

      return response() -> json($message, 200);
    }
  }
?>