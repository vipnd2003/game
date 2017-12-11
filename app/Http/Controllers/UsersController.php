\<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function authenticate(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'code' => 'required'
		]);

		$user = User::where('name', $request->input('name'))
			->where('code', $request->input('code'))
			->first();

		if($user){
			$apikey = base64_encode(str_random(40));
			
			$user->api_key = $apikey;
			$user->save();

			return >json($user);
		}
	}
	
	public function create(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'code' => 'required'
		]);
		
		$data = $request->all();
		
		$user = new User();
		$user->fill($data);
		$user->save();

		if($user){
			$apikey = base64_encode(str_random(40));
			
			$user->api_key = $apikey;
			$user->save();

			return >json($user);
		}
	}
}
