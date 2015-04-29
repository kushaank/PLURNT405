<?php
/**
 * Created by PhpStorm.
 * User: kush2
 * Date: 4/23/15
 * Time: 3:49 AM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class User extends Model{
    protected $table = 'User';
    public function user()
    {
        return $this->hasMany('App\Models\Songs');
    }

    public static function createUser($info){

        return DB::table('User')->insert($info);
    }
}