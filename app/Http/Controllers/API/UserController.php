<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    // Function for create order
    public function createUser(Request $request)
    {
        // Validator 

        $valid = Validator::make($request->all(),[
            'name' => 'required| string',
            'email' => 'required| string',
            'password' => 'required| min:6',
        ]);
        if($valid->fails()){
            $result = array('status' => false, 'message' => "Validation error occured",
        'error_message' => $valid->errors());
        return response()->json($result, 400);
        }


        // Create New User
        $user = User::create([
            'name' => $request-> name,
            'email' => $request-> email,
            'password' => bcrypt($request-> password),
        ]);
        if($user-> id){
            $result = array('status' => true, 'message' => "user created", "data" => $user);
            $responseCode = 200;
        }
        else{
            $result = array('status' => false, 'message' => "user not created");
            $responseCode = 400;
        }
        return response()->json($result, $responseCode);
    }

    public function getUser()
    {
        try {
        // Fetch User
            $user = User::all();
            $result = array('status' => true, 'message' => count($user). "user(s) fetched", 
            "data" => $user);
            $responseCode = 200;      
            return response()->json($result, $responseCode);
        }
        catch (Exception $e)
        {
            $result = array('status' => false, 'message' =>  "API failed due to an error.", 
        "error" => $e->getMessage());
        return response()->json($result, 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['status' => false, 'message' => "User not Fond"], 404);
        }
        // Validator 

        $valid = Validator::make($request->all(),[
            'name' => 'required| string',
            'email' => 'required| string',
            
        ]);
        if($valid->fails()){
            $result = array('status' => false, 'message' => "Validation error occured",
        'error_message' => $valid->errors());
        return response()->json($result, 400);
        }
        // Update Existing User
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $result = array('status' => false, 'message' => "User has been updated successfully.",
        'data' => $user); 
        return response()->json($user, 200);    
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['status' => false, 'message' => "User not Fond"], 404);
        }
        $user->delete();
        $result = array('status' => false, 'message' => "User has been deleted successfully."); 
        return response()->json($user, 200);    
    }

}
