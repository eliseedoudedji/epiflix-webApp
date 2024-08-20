<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $data = $request->validate([
            'name' => 'required|string',
            
            'status' => 'required|boolean',
            'email' => ['required','email','unique:users'],
            'email_verified_at' => 'string',
         
            'password' => 'required|min:6',
           
        ]);
        //dd($data);
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' =>$token
        ];
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => ['required','email','exists:users'],
            'password' => ['required','min:6']
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)){
            return response(
                ["message" =>'Bad creds'],401
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' =>$token
        ];
    }

    public function users(){
        $users=User::all();
        return response()->json($users) ;
    }
 
    public function oneUser(string $id)
    {
        $project = User::find($id);
        return response()->json($project);
    }

    public function destroyUser(string $id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function updateUser(Request $request, string $id)
    {
        $project = User::find($id);
        $project->name = $request->name ;
        $project->status = $request->status ;
        $project->email = $request-> email;
        $project->password = $request-> password;
        $project->save();
        return response()->json($project);
    }
}
