<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookMangmentTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_add_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();
//        $response->assertOk();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_author_is_required()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors(['author_id']);
    }

    /** @test */
    public function a_book_can_be_update()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $Book = Book::first();
        $response = $this->patch($Book->path(), [
            'title' => 'NEW title',
            'author_id' => 'jalal',
        ]);

        $this->assertEquals('NEW title', Book::first()->title);
//        $this->assertEquals(6, Book::first()->author_id);
        $response->assertRedirect($Book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $Book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete($Book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');

    }


    /** @test */
    public function a_new_author_is_automatically_add()
    {

        $this->withoutExceptionHandling();

        $this->post('/books',$this->data());

        $book = Book::first();
        $author = Author::first();

//        dd($book->author_id);

        $this->assertEquals($author->id, $book->author_id);

        $this->assertCount(1, Author::all());

    }

    private function data(): array
    {
        return [
            'title' => 'HJGHGHGJ',
            'author_id' => 'johen',
        ];
    }
}
