<?php

class SongsTest extends TestCase {

    public function testValidateReturnsFalseIfSongNameIsMissing(){

        $validation= \App\Models\Songs::alidate([]);

        $this->assertEquals($validation->passes(),false);
    }
    public function testValidateReturnsFalseIfSongNameIsPresent(){

        $validation= \App\Models\Songs::alidate([
            'title'=>"yehh"
        ]);

        $this->assertEquals($validation->passes(),true);
    }


}