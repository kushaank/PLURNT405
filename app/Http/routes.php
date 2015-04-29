<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Models\Songs;
use App\Models\User;

Route::get('/', function(){
	return View::make('auth.login');
});
Route::get('/about',function(){
	return view('about');
});
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/home/top','SongController@getSongsTop');
Route::get('/home/new','SongController@getSongsNew');


Route::get('/home/post','SongController@post');
Route::post('/home/postrequest','SongController@postRequest');
Route::post('/home/comment','SongController@comment');


//for returning genres
Route::get('/genres/{genre_name}', function($genre_name){
	$genre = Genre::where('genre_name', '=', $genre_name)->pluck('id');
	$songs = Songs::with('genre')->where('genre_id', '=', $genre)->get();
	return view('resultsbygenre',[
		'songs' => $songs,
		'genre_name' => $genre_name
	]);
});


Route::get('/facebook',function(){

	return \Socialize::with('facebook')->redirect();
});


Route::get('/home',function(){
	$songs = (new Songs())->getSongsTop();

	return view('index',[
		'songs'=>$songs,
		'users'=> User::all()
	]);
});
Route::get('/songs/{id}','SongController@getDetails');
Route::post('/songs/comment','SongController@comment');
Route::get('/account/facebook',function(){
	$songs = (new Songs())->getSongsTop();

	$user=\Socialize::with('facebook')->user();



	if(!(User::where('email', '=', $user->email)->exists())){
		// user found

		User::createUser([
			'name' => $user->name,
			'user_id' => $user->id,
			'email' => $user->email

		]);
	}
	Session::put('currentUser', $user);


	view()->share('user', $user);
	return view('index',[
			'songs'=>$songs,
			'users'=>User::all()
		]
		);
});

