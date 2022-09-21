<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorMangmentTest extends TestCase
{
    use RefreshDatabase;
//>cls && vendor\bin\phpunit --filter a_Author_can_be_created
    /** @test */
    public function a_Author_can_be_created()
    {

        $this->withoutExceptionHandling();
        $this->post('/author', [
            'name' => 'Author name ',
            'dob' => '2014-04-02',
        ]);

        $author= Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2014-04-02',$author->first()->dob->format('Y-m-d'));
    }
}
