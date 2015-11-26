<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model {

	protected $table = 'marked';

	protected $fillable = ['alphaid', 'username', 'collection'];

}
