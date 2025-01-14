<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
