<?php namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Mark;
use App\Sprite;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller manages profiles.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware("auth");
	}

	// Shows a user profile with favorites and uploads.
	public function showProfile($userid)
	{
		$user = User::where("alphaid", "=", $userid);
		if (!$user->exists()) abort(404);
		$user = $user->first();
		$favorites = Mark::where("username", "=", $user->alphaid)->orderBy("created_at", "desc")->get();
		$uploads = Sprite::where("username", "=", $user->alphaid)->orderBy("created_at", "desc")->get();
		return view("user/show", [
			"username" => $user->username,
			"name" => $user->name,
			"about" => $user->about,
			"favorites" => $favorites,
			"uploads" => $uploads,
			"creation" => $user->created_at,
			"modification" => $user->updated_at,
		]);
	}
	
	// Show a prefilled profile edit form.
	public function offerEdit() {
		$user = Auth::user();
		return view("user/edit", [
			"username" => $user->username,
			"name" => $user->name,
			"about" => $user->about,
		]);
	}

	// Actually make edits to a profile.
	public function handleEdit(Request $request)
	{
		$this->validate($request, [
			"name" => "required|min:3|max:255",
			"about" => "max:2000",
		]);
		Auth::user()->name = $request->input("name");
		Auth::user()->about = $request->input("about");
		Auth::user()->save();
		return redirect("/user/".Auth::user()->alphaid);
	}

}
