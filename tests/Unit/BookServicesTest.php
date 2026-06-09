<?php

namespace Tests\Unit;

use App\Services\BookServices;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookServicesTest extends TestCase
{
    /** @test */
    public function it_extracts_the_isbn_from_the_vision_text_detection_response()
    {
        Http::fake([
            'vision.googleapis.com/*' => Http::response([
                'responses' => [[
                    'textAnnotations' => [
                        ['description' => "Some Book Title\nISBN 978-3-16-148410-0"],
                        ['description' => 'ISBN'],
                        ['description' => '978-3-16-148410-0'],
                    ],
                ]],
            ], 200),
        ]);

        $file = UploadedFile::fake()->image('book-cover.jpg');

        $isbn = BookServices::getISBN($file);

        $this->assertSame('9783161484100', $isbn);
    }

    /** @test */
    public function it_posts_a_text_detection_request_to_the_google_vision_rest_endpoint()
    {
        Http::fake([
            'vision.googleapis.com/*' => Http::response(['responses' => [[]]], 200),
        ]);

        $file = UploadedFile::fake()->image('book-cover.jpg');

        BookServices::getISBN($file);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'vision.googleapis.com/v1/images:annotate')
                && ($request['requests'][0]['features'][0]['type'] ?? null) === 'TEXT_DETECTION';
        });
    }
}
