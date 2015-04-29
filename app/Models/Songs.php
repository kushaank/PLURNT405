<?php
/**
 * Created by PhpStorm.
 * User: kush2
 * Date: 4/23/15
 * Time: 3:49 AM
 */

namespace App\Models;
use DB;
use Validator;
use Illuminate\Database\Eloquent\Model;
class Songs extends Model{
    public function getGenres() {
        $query = DB::table('genres')->orderBy('genre_name', 'asc');
        return $query->get();
    }

    public static function getSongsTop(){
        $query = DB::table('songs')->orderBy('id', 'desc');
        return $query->get();
    }
    public static function getSongsNew(){
        $query = DB::table('songs')->orderBy('id', 'desc');
        return $query->get();
    }
    public static function getInfo($songId){
        $query = DB::table('songs')
            ->where('songs.id', '=' , $songId)
            ->select('*', 'songs.id AS id')
            ->join('genres', 'genres.id', '=', 'songs.genre_id')
        ->join('User','User.user_id','=','songs.userid');

        return $query->first();
    }
    public static function search($title) {
        $query = DB::table('songs')->select('*', 'songs.id AS id');

        if ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        $query->orderBy('title', 'asc');
        return $query->get();
    }


    public static function validate($input){
        return Validator::make($input, [
            'name' => 'required|min:5',
            'link' => 'required|min:10',
            'artist' => 'required',
            'genre'=>'required'
        ]);
    }
    public static function writeReview($input){
        return DB::table('comments')->insert($input);
    }
    public static function getComments($id){
        $query= DB::table('comments')->where('song_id', '=', $id);
        return $query->get();
    }


    public static function createSong($info){
        return DB::table('songs')->insert($info);
    }
    public static function validateInsertRequest($request){
        return Validator::make($request,[
            'name' => 'required',
            'link' => 'required',
            'artist' => 'required',
            'genre' => 'required'
        ]);
    }
    public static function alidate($input){

        return Validator::make($input,[
            'title'=>'required'
        ]);
    }
}
?>