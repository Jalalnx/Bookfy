<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

//    public function __construct()
//    {
//        parent::setUp();
//
//    }

    /** @test */
    public  function  only_name_are_require_to_create_author(){


        Author::firstOrCreate([
            'name' =>'Davied shaffel'
        ]);

        $this->assertCount(1,Author::all());
    }
}
