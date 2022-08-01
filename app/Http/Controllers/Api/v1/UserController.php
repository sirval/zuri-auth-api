<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RequestLogin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetUsers()
    {
        $users = User::all();
        return response()->json([
            'status' => 200,
            'users' => $users,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'User Registered Succesfully',
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Registeration Failed',
            ], 400);
        }
    }

     /**
     * login the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(RequestLogin $request)
    {
        if (!Auth::attempt($request->only(['email','password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email or Password mismatched!',
                'user' => $request->email,
            ], 400);
        }
        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 200);
           
        

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetUser($id)
    {
        $user = User::find($id);
        return response()->json([
            'status'=> 200,
            'user'=> $user,
        ]);
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id )
    {
        $user = User::find($id);
        $update_user = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($update_user) {
            return response()->json([
                'status' => true,
                'user' => $update_user,
                'message' => 'User Successfully Updated',
            ], 200);
        }else {
            
            return response()->json([
                'status' => false,
                'message' => 'User Update Failed',
            ], 400);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete()){
            return response()->json([
                'status' => true,
                'message' => 'User Successfully Deleted',
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'User Deletion Failed',
            ], 400);
        }
    }
}
