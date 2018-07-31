<?php

namespace Tests\Feature\KnowledgeCafe\Library;

use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTest;

class BookTest extends FeatureTest
{
    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_authorized_user_can_see_books()
    {
        $this->signInAsEmployee();
        $this->get(route('books.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function a_guest_cant_see_books()
    {
        $this->expectException(AuthenticationException::class);
        $this->get(route('books.index'));
    }

    /** @test */
    public function an_authorized_user_can_create_books()
    {
        $this->signInAsSuperAdmin();
        $book = make(Book::class);
        $response = $this->post(route('books.store'), $book->toArray());
        $this->get(route('books.index'))
            ->assertSee($book->title);
    }

    /** @test */
    public function an_unauthorized_user_cant_create_books()
    {
        $this->expectException(AuthorizationException::class);
        $this->signIn();
        $book = make(Book::class);
        $response = $this->post(route('books.store'), $book->toArray());
    }

    /** @test */
    public function an_authorized_user_can_delete_book()
    {
        $this->signInAsSuperAdmin();
        $book = create(Book::class);
        $response = $this->delete(route('books.delete', $book->id));
        $fetchBook = Book::find($book->id);
        $this->assertNull($fetchBook);
    }

    /** @test */
    public function an_authorized_user_can_update_book_categories()
    {
        $this->signInAsSuperAdmin();
        $book = create(Book::class);
        $category = create(BookCategory::class);
        $response = $this->patch(route('books.update', $book->id), ['categories' => [0 => $category->toArray()]]);
        $this->assertTrue($book->categories->contains($category));
    }

    /** @test */
    public function an_unauthorized_user_cant_update_book_categories()
    {
        $this->expectException(AuthorizationException::class);
        $this->signIn();
        $book = create(Book::class);
        $category = create(BookCategory::class);
        $response = $this->patch(route('books.update', $book->id), ['categories' => [0 => $category->toArray()]]);
        $this->assertTrue($book->categories->contains($category));
    }

    /** @test */
    public function a_user_can_add_the_book_to_wishlist()
    {
        $this->signIn();
        $book = create(Book::class);
        $this->post(route('books.addToWishList'), ['book_id' => $book->id]);
        $this->assertTrue($book->wishers->contains(auth()->user()));
    }

    /** @test */
    public function a_user_can_mark_book_as_read()
    {
        $this->signIn();
        $book = create(Book::class);
        $this->post(route('books.toggleReadStatus'), ['book_id' => $book->id, 'is_read' => true]);
        $this->assertTrue($book->readers->contains(auth()->user()));
    }

    /** @test */
    public function a_book_can_have_multiple_copies()
    {
        $book_copies = rand(1, 10);
        $this->signInAsSuperAdmin();
        $this->post(route('books.store'), ['title' => 'Test Book', 'number_of_copies' => $book_copies]);
        $book = Book::whereTitle('Test Book')->first();
        $this->assertTrue($book->number_of_copies == $book_copies);
    }
}
