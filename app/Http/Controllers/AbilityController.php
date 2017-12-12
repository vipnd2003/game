<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AbilityController extends Controller
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

    public function update(Request $request) {
        $user = Auth::user();
        $data = $request->all();

        $ability = Ability::where('user_id', $user->id)->first();


        if (!$ability) {
            $ability = new Ability();
        }

        $ability->fill($data);
        $ability->save();

        return json($ability);
    }
}
