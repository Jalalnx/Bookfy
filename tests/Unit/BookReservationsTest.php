<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checked_in_twice()
    {
        $this->withoutExceptionHandling();
        $this->refreshInMemoryDatabase();
//        $this->expectException(\Exception::class);
        Book::factory()->count(1)->create();
        $book = Book::first();
        User::factory()->count(1)->create();
        $user = User::first();

        $book->check_out($user);

        $book->check_in($user);

        $book->check_out($user);
        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->User_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->check_in_at);
        $this->assertEquals(now(), Reservation::find(2)->check_out_at);

        $book->check_in($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->User_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->check_in_at);
        $this->assertEquals(now(), Reservation::find(2)->check_in_at);


    }

    /**  @test */
    public function a_book_can_be_checked_out()
    {
        $this->withoutExceptionHandling();
        Book::factory()->count(1)->create();
        $book = Book::first();
        $this->assertCount(1, Book::all());
        User::factory()->count(1)->create();
        $user = User::first();
        $this->assertCount(1, User::all());
        $book->check_out($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->User_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_out_at);


    }

    /** @test */
    public function a_book_can_be_checked_in()
    {
        $this->withoutExceptionHandling();
        Book::factory()->count(1)->create();
        $book = Book::first();
        User::factory()->count(1)->create();
        $user = User::first();

        $book->check_out($user);
        $book->check_in($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->User_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->check_in_at);
        $this->assertEquals(now(), Reservation::first()->check_in_at);

    }

    /** @test */
    public function if_not_checked_ot_Expution_throw()
    {

        $this->expectException(\Exception::class);
        $this->withoutExceptionHandling();
        Book::factory()->count(1)->create();
        $book = Book::first();
        User::factory()->count(1)->create();
        $user = User::first();

        //must throw Exception
        $book->check_in($user);
    }




}
