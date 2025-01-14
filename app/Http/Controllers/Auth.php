<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class Auth extends Controller
{
    //
    public function RegisterFunc(Request $request){
        try{
            $request->validate([
                'email' => ['required', 'email'],
                'username' => ['required', 'string', 'min:5', 'max:18'],
                'password' => ['required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            ]);

            UserModel::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            return response()->json(['Access'=> true,'Error'=>false,"saved"=>true]);
        }catch (ValidationException $e) {
            // Return validation error messages in JSON format
            return response()->json([
                'Access' => false,
                'Error' => $e->errors() // Get all validation errors
            ], 400);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'Access' => false,
                'Error' => $e->getMessage()
            ], 500);
        }
    }

    public function LoginFunc(Request $request){
        try{
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            ]);

           $user= UserModel::where('email',$request->email)->first();

           if(!$user) return response()->json([
            "Access"=>true, "Error"=>"Email not found"
            ],400);

            if(!Hash::check($request->password,$user->password)) return response()->json([
                "Access"=>true, "Error"=>"Incorrec password"
            ],400);

           $token = Str::random(60);

            AuthModel::updateOrCreate(
                ['user_id' => $user->id], // Match existing verification by user_id
                [
                    'user_id' => $user->id,
                    'auth' => $token,
                ]
            );


            return response()->json(['Access'=> true,'Error'=>false, "Verified"=>true, "Data"=>$user ,"Token"=>$token]);
           
        }catch (ValidationException $e) {
            // Return validation error messages in JSON format
            return response()->json([
                'Access' => false,
                'Error' => $e->errors() // Get all validation errors
            ], 400);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'Access' => false,
                'Error' => $e->getMessage()
            ], 500);
        }
    }
}
