<?php

namespace Tests\Unit\KnowledgeCafe\Library;

use App\Models\KnowledgeCafe\Library\Book;
use Tests\TestCase;

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
}
