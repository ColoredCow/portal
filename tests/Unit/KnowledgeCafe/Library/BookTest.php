<?php

namespace Tests\Unit\KnowledgeCafe\Library;

use Tests\TestCase;
use App\Models\KnowledgeCafe\Library\Book;

class BookTest extends TestCase
{
    protected $book;

    public function setUp()
    {
        parent::setUp();
        $this->book = create(Book::class);
    }

    /** @test */
    public function it_has_categories()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->book->categories);
    }

    /** @test */
    public function it_has_readers()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->book->readers);
    }

    /** @test */
    public function it_has_wishers()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->book->wishers);
    }

    /** @test */
    public function it_can_mark_book_as_read_for_authenticated_user()
    {
        $this->signIn();
        $this->book->markBook(true);
        $this->assertTrue($this->book->readers->contains(auth()->user()));
    }

    /** @test */
    public function it_can_add_to_users_wishlist()
    {
        $this->signIn();
        $this->book->addToWishlist();
        $this->assertTrue($this->book->wishers->contains(auth()->user()));
    }
}
