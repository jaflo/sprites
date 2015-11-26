<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprite extends Model {

	protected $table = 'sprites';

	protected $fillable = ['title', 'description', 'alphaid', 'username', 'license',
		'colors', 'width', 'height', 'filesize', 'checkfile'];

}
