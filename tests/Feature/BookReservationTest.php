<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_add_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'cool book Title',
            'author' => 'victor',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'victor',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_author_is_required()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Hacker for Gays',
            'author' => '',
        ]);

        $response->assertSessionHasErrors(['author']);
    }

 /** @test */
   public  function a_book_can_be_update(){
       $this->withoutExceptionHandling();
       $this->post('/books', [
           'title' => 'Hacker for Gays',
           'author' => 'Daroat',
       ]);

       $Book =Book::first();
       $response= $this->patch('/books/'.$Book->id,[
           'title' => 'NEW title',
           'author' => 'NEW author',
       ]);
       $this->assertEquals('NEW title',Book::first()->title);
       $this->assertEquals('NEW author',Book::first()->author);
   }
}
