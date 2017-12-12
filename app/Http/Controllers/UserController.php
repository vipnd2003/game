<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
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

			return json($user);
		}
	}
	
	public function create(Request $request) {
		// Validate request
		$this->validate($request, [
			'name' => 'required|unique:users',
			'code' => 'required'
		]);

		// Create user
		$data = $request->all();
		
		$user = new User();
		$user->fill($data);
		$user->api_key = base64_encode(str_random(40));

		$user->save();

		return json($user);
	}

	public function sync(Request $request) {
		// Validate request
		$this->validate($request, [
			'name' => 'required',
			'code' => 'required'
		]);

		$user = User::with('ability')->where('name', $request->input('name'))
			->where('code', $request->input('code'))
			->first();

		return json($user);
	}

	public function update(Request $request) {
		$user = Auth::user();

		// Validate request
		$this->validate($request, [
			'name' => 'required|unique:users,name,' . $user->id,
			'code' => 'required'
		]);

		// Update user
		$data = $request->all();

		$user->fill($data);
		$user->save();

		return json($user);
	}
}
