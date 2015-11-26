<?php namespace App\Http\Controllers;

use Auth;
use App\Sprite;
use Illuminate\Http\Request;

class MostController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| Make the home and welcome pages. Handle searches.
	|
	*/

	// Show the home page with new sprites.
	public function home()
	{
		if (!Auth::check()) { // send to main page if logged-out.
			return redirect("/");
		}
		$sprites = Sprite::orderBy("created_at", "desc")->take(200)->get();
		return view("home", [
			"sprites" => $sprites,
		]);
	}

	// Show the welcome screen.
	public function welcome()
	{
		if (Auth::check()) { // If logged-in, sent to sprite listing
			return redirect("/home");
		}
		$sprites = Sprite::all()->count();
		return view("welcome", [
			"sprites" => $sprites,
		]);
	}

	// Handle searches.
	public function search(Request $request)
	{
		if (!Auth::check()) { // Only for logged-in users.
			return redirect("/home");
		}
		$query = $request->input("q");
		$terms = implode(" ", explode(" ", trim($query)));
		if (isset($query) && strlen($terms) > 1) {
			$terms = explode(" ", $terms);
			$special = array("+", "-", "*", "(", ")", "<", ">");
			foreach($terms as &$term) {
				$first = substr($term, 0, 1);
				$last = substr($term, -1);
				if (in_array($last, $special)) $term = substr($term, 0, -1);
				$term = str_replace($special, "", $term);
				if ($first == '"' && $last == '"') $term = "+".substr($term, 1, -1);
				else $term = $term."*";
			}
			$terms = implode(" ", $terms);
			$sprites = Sprite::whereRaw("MATCH(title,description,colors) AGAINST(? IN BOOLEAN MODE)", [$terms])
				->orderBy("created_at", "desc")->get();
			return view("home", [
				"sprites" => $sprites,
				"query" => $query,
			]);
		} else {
			return redirect("home");
		}
	}

}
