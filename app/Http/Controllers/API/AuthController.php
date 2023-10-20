<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    //
    use HasApiTokens;

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama_user' => ['required'],
            'username' => ['required'],
            'role' => ['required'],
            // "username" => 'required|email',
            'password' => ['required']
        ]);
        if ($validated->fails()) {
            return response()->json([
                "success" => false,
                "msg" => "Terjadi Kesalahan",
                "data" => $validated->errors()
            ]);
        }
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "success" => true,
            "msg" => "Sukses Register",
            "data" => $token
        ]);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            $user = User::where('username', $request->username)->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;


            return response()->json([
                "success" => true,
                "msg" => "Sukses Register",
                "token" => $token,
                "user_data" => $user
            ]);
        }
    }
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
?>