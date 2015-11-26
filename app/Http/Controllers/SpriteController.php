<?php namespace App\Http\Controllers;

use App\Sprite;
use Validator;
use Illuminate\Http\Request;
use Image;
use Auth;
use App\User;
use App\Mark;
//use ImagePalette;

class SpriteController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Sprite Controller
	|--------------------------------------------------------------------------
	|
	| Handle sprite uploads, edits, views, downloads, removals, (un)favorites.
	|
	*/

	/**
	 * Create a new controller instance that requires a logged-in user.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware("auth");
	}
	
	// Simply serve a sprite to offer upload.
	public function offerUpload() {
		return view("sprite/upload");
	}

	// Handle uploading of a sprite.
	public function handleUpload(Request $request)
	{
		$this->validate($request, [
			"name" => "required|min:2|max:200",
			"uploadtype" => "required",
			"file" => "required_if:uploadtype,image|image|max:200", // < 200kb
			"pdecapture" => "required_if:uploadtype,code",
			"description" => "max:2000",
			"license" => "required|in:ccby4,unlicense",
		]);
		$submissionid = strtolower(str_random(5));
		while (Sprite::where("alphaid", "=", $submissionid)->exists()) {
			$submissionid = strtolower(str_random(5));
		}
		$path = public_path()."/sprites/full/".$submissionid.".png";
		if ($request->input("uploadtype") == "image") {
			if ($request->file("file")->getSize() > 200*1000) { // 200kb
				return redirect()->back()
					->withErrors(["This file is too large."])
					->withInput();
			}
			Image::make($request->file("file")->getRealPath())->save($path);
		} else {
			$base64 = $request->input("pdecapture");
			Image::make($base64)->save($path);
		}
		if (Sprite::where("checkfile", "=", sha1_file($path))->exists()) {
			unlink($path);
			return redirect()->back()
				->withErrors(["This file is a duplicate."])
				->withInput();
		}
		$image = Image::make($path);
		$palette = new \BrianMcdo\ImagePalette\ImagePalette($path, 3);
		$colors = "";
		foreach ($palette as $color) {
			$colors .= $color." ";
		}
		Sprite::create([
			"title" => $request->input("name"),
			"alphaid" => $submissionid,
			"description" => $request->input("description"),
			"license" => $request->input("license"),
			"username" => Auth::user()->alphaid,
			"width" => $image->width(),
			"height" => $image->height(),
			"filesize" => $image->filesize(),
			"checkfile" => sha1_file($path),
			"colors" => $colors,
		]);
		if ($image->width()/$image->height() > 1.5) {
			$image->widen(30)->save(public_path()."/sprites/small/".$submissionid.".png");
		} else {
			$image->widen(15)->save(public_path()."/sprites/small/".$submissionid.".png");
		}
		return redirect("/sprite/".$submissionid);
	}

	// Reindex all sprite-colors.
	public function redoColors()
	{
		$sprites = Sprite::all();
		foreach ($sprites as $sprite) {
			$path = public_path()."/sprites/full/".$sprite->alphaid.".png";
			$image = Image::make($path);
			$palette = new \BrianMcdo\ImagePalette\ImagePalette($path, 3);
			$colors = "";
			foreach ($palette as $color) {
				$colors .= $color." ";
			}
			$sprite->colors = $colors;
			$sprite->save();
		}
	}
	
	// Pre-fill an edit form and serve to a user.
	public function offerEdit($spriteid) {
		$sprite = Sprite::where("alphaid", "=", $spriteid);
		if (!$sprite->exists()) abort(404);
		$sprite = $sprite->first();
		if ($sprite->username != Auth::user()->alphaid) abort(403);
		return view("sprite/edit", [
			"title" => $sprite->title,
			"alphaid" => $sprite->alphaid,
			"description" => $sprite->description,
		]);
	}

	// Make changes to a sprite.
	public function handleEdit(Request $request)
	{
		$this->validate($request, [
			"name" => "required|min:2|max:200", // also in the migration
			"description" => "max:2000",
			"alphaid" => "required",
		]);
		$sprite = Sprite::where("alphaid", "=", $request->input("alphaid"));
		if (!$sprite->exists()) abort(404);
		$sprite = $sprite->first();
		if ($sprite->username != Auth::user()->alphaid) abort(403);
		// All data clear! Continue:
		$sprite->title = $request->input("name");
		$sprite->description = $request->input("description");
		$sprite->save();
		return redirect("/sprite/".$sprite->alphaid);
	}

	// Show a sprite.
	public function show($spriteid)
	{
		$sprite = Sprite::where("alphaid", "=", $spriteid);
		if (!$sprite->exists()) abort(404);
		$sprite = $sprite->first();
		$fullname = User::where("alphaid", "=", $sprite->username)->first()->name;
		$favorite = Mark::where("alphaid", "=", $spriteid)
			->where("username", "=", Auth::user()->alphaid)
			->exists();
		$favorites = Mark::where("alphaid", "=", $spriteid)->count();
		return view("sprite/show", [
			"title" => $sprite->title,
			"alphaid" => $sprite->alphaid,
			"description" => $sprite->description,
			"license" => $sprite->license,
			"uploader" => $fullname,
			"username" => $sprite->username,
			"favorited" => $favorite,
			"favorites" => $favorites,
			"width" => $sprite->width,
			"height" => $sprite->height,
			"filesize" => $sprite->filesize,
			"colors" => explode(" ", trim($sprite->colors)),
			"creation" => $sprite->created_at,
			"modification" => $sprite->updated_at,
		]);
	}

	// Force a download of a sprite.
	public function download($spriteid)
	{
		$sprite = Sprite::where("alphaid", "=", $spriteid);
		if (!$sprite->exists()) abort(404);
		$sprite = $sprite->first();
		$fullname = User::where("alphaid", "=", $sprite->username)->first()->name;
		return response()->download(public_path()."/sprites/full/".$sprite->alphaid.".png",
			$sprite->alphaid."-".str_slug($sprite->title, "_").".png");
	}

	// Remove a sprite.
	public function remove($spriteid, Request $request)
	{
		if ($request->input("t") == csrf_token()) {
			$sprite = Sprite::where("alphaid", "=", $spriteid);
			if (!$sprite->exists()) abort(404);
			$sprite = $sprite->first();
			if (!(
				$sprite->username == Auth::user()->alphaid ||
				str_contains(Auth::user()->rights, "delete_anything ")
			)) abort(403);
			unlink(public_path()."/sprites/full/".$spriteid.".png");
			unlink(public_path()."/sprites/small/".$spriteid.".png");
			$favorites = Mark::where("alphaid", "=", $spriteid);
			foreach ($favorites as $favorite) {
				$favorite->delete();
			}
			$sprite->delete();
		} else {
			abort(403);
		}
		return redirect("");
	}

	// Favorite a sprite.
	public function favorite($spriteid, Request $request)
	{
		if ($request->input("t") == csrf_token()) {
			$favorite = Mark::where("alphaid", "=", $spriteid)
				->where("username", "=", Auth::user()->alphaid);
			if ($favorite->exists()) $favorite->first()->delete();
			// All data clear! Continue:
			Mark::create([
				"alphaid" => $spriteid,
				"username" => Auth::user()->alphaid,
			]);
		} else {
			abort(403);
		}
		return redirect()->back();
	}

	// Unfavorite a sprite.
	public function unfavorite($spriteid, Request $request)
	{
		if ($request->input("t") == csrf_token()) {
			$favorite = Mark::where("alphaid", "=", $spriteid)
				->where("username", "=", Auth::user()->alphaid);
			if ($favorite->exists()) $favorite->first()->delete();
		} else {
			abort(403);
		}
		return redirect()->back();
	}

}
