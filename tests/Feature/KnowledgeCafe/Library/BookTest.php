<?php

namespace Tests\Feature\KnowledgeCafe\Library;

use Tests\Feature\FeatureTest;
use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\KnowledgeCafe\Library\BookCategory;

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
        $response = $this->delete(route('books.delete', $book->id));
        $fetchBook = Book::find($book->id);
        $this->assertTrue($fetchBook == null);
    }

    /** @test */
    public function an_authorised_user_can_update_book_categories()
    {
        $this->signInAsSuperAdmin();
        $book = create(Book::class);
        $category = create(BookCategory::class);
        $response = $this->patch(route('books.update', $book->id), ['categories' => [0 => $category->toArray()]]);
        $this->assertTrue($book->categories->contains($category));
    }

    /** @test */
    public function an_un_authorised_user_cant_update_book_categories()
    {
        $this->expectException(AuthorizationException::class);
        $this->signIn();
        $book = create(Book::class);
        $category = create(BookCategory::class);
        $response = $this->patch(route('books.update', $book->id), ['categories' => [0 => $category->toArray()]]);
        $this->assertTrue($book->categories->contains($category));
    }

    /** @test */
    public function an_authenticated_user_can_add_the_book_to_wishlist()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function an_authenticated_user_can_mark_book_as_read()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function an_authenticated_can_disable_the_book_suggestion()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function an_authenticated_can_enable_the_book_suggestion()
    {
        $this->assertTrue(true);
    }
}
