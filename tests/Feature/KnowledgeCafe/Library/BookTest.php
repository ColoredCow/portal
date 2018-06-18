<?php

namespace Tests\Feature\KnowledgeCafe\Library;

use Tests\Feature\FeatureTest;
use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Auth\Access\AuthorizationException;

class BookTest extends FeatureTest
{
    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_authorised_user_can_see_books()
    {
        $this->signInAsSuperAdmin();
        $this->get(route('books.index'))
            ->assertStatus(200);
    }

     /** @test */
     public function an_un_authorised_user_cant_see_books()
     {
         $this->expectException(AuthorizationException::class);
         $this->signIn();
         $this->get(route('books.index'));
     }

    /** @test */
    public function an_authorised_user_can_create_books()
    {
        $this->signInAsSuperAdmin();
        $book = make(Book::class);
        $response = $this->post(route('books.store'), $book->toArray());
        $this->get(route('books.index'))
            ->assertSee($book->title);
    }

    /** @test */
    public function an_un_authorised_user_cant_create_books()
    {
        $this->expectException(AuthorizationException::class);
        $this->signIn();
        $book = make(Book::class);
        $response = $this->post(route('books.store'), $book->toArray());
    }

    /** @test */
    public function an_authorised_user_can_delete_book()
    {
        $this->signInAsSuperAdmin();
        $book = create(Book::class);
        $response = $this->delete(route('books.delete', $book->id ));
        $fetchBook = Book::find($book->id);
        $this->assertTrue($fetchBook == null);
    }

      /** @test */
    public function an_authorised_user_cant_delete_book()
    {
        $this->expectException(AuthorizationException::class);
        $this->signIn();
        $book = create(Book::class);
        $response = $this->delete(route('books.delete', $book->id ));
    }
}
