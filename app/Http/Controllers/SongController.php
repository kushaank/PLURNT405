<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Socialize;
use App\Models\Genre;
use App\Models\User;
use App\Models\Songs;
use Pusher;


class SongController extends Controller {


public function search() {

}
public function getSongsTop() {

$songs = (new Songs())->getSongsTop();

return view('index', [
'songs'=>$songs,
'users' => User::all()
]);
}


public function getSongsNew(Request $request) {
    $songs = (new Songs())->getSongsNew();

    return view('new', [
        'songs'=>$songs
    ]);
    }
    public static function getDetails($id)
    {
        $info = (Songs::getInfo($id));
        $comments = (Songs::getComments($id));

        return view('comment',[
            'info' => $info,
            'comments' => $comments
        ]);
    }
public function comment(Request $request)
{
//$validator = Dvd::validate($request->all());
//if($validator->passes())
//{
Songs::writeReview([
'title' => $request->input('title'),
'description' => $request->input('review'),
'song_id' => $request->input('id'),

]);
return redirect('/songs/'.$request->input('id'))->with('success','Comment submitted');
//}
//return redirect('/dvds/'.$request->input('id'))->withInput()->withErrors($validator);
}


public function post(){


return view('post',[
'genres' => Genre::all(),
]);
}
public function postRequest(Request $request){
$validator = Songs::validateInsertRequest($request->all());
if($validator->passes()){
Songs::createSong([
'title' => $request->input('name'),
'genre_id' => $request->input('genre'),
'artist' => $request->input('artist'),
'link' => $request->input('link'),
    'userid'=> $request->input('user')
]);
return redirect('/home/post')->with('success','Song inserted successfully!');
}else{
return redirect('/home/post')
->withInput()
->withErrors($validator);
}
}
}
?>