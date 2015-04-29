<?php
/**
 * Created by PhpStorm.
 * User: kush2
 * Date: 3/5/15
 * Time: 3:50 PM
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Genre extends Model{
    protected $table = 'genres';
    public function genre()
    {
        return $this->hasMany('App\Models\Songs');
    }

    public static function validate($input){

        return Validator::make($input,[
            'genre_name'=>'required'
        ]);
    }
}