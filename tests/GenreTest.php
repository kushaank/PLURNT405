<?php

class GenreTest extends TestCase {

    public function testValidateReturnsFalseIfGenreNameIsMissing(){

        $validation= \App\Models\Genre::validate([]);

        $this->assertEquals($validation->passes(),false);
    }
    public function testValidateReturnsFalseIfGenreNameIsPresent(){

        $validation= \App\Models\Genre::validate([
            'genre_name'=>"genreeee"
        ]);

        $this->assertEquals($validation->passes(),true);
    }
}