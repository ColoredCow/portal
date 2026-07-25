<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RootFactoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function setting_factory_creates_a_persisted_setting()
    {
        $setting = Setting::factory()->create();

        $this->assertDatabaseHas('settings', ['setting_key' => $setting->setting_key]);
        $this->assertNotEmpty($setting->module);
    }

    /** @test */
    public function book_factory_creates_a_persisted_book()
    {
        $book = Book::factory()->create();

        $this->assertTrue($book->exists);
        $this->assertNotEmpty($book->isbn);
    }

    /** @test */
    public function book_category_factory_creates_a_persisted_category()
    {
        $category = BookCategory::factory()->create();

        $this->assertTrue($category->exists);
        $this->assertNotEmpty($category->name);
    }

    /** @test */
    public function client_factory_creates_a_persisted_client()
    {
        $client = Client::factory()->create();

        $this->assertTrue($client->exists);
        $this->assertNotEmpty($client->name);
    }
}
