<?php

namespace Tests\Unit;

use App\Services\PdfService;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PdfServiceTest extends TestCase
{
    private string $outputDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->outputDir = storage_path('framework/testing/pdf-' . uniqid());
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->outputDir);

        parent::tearDown();
    }

    #[Test]
    public function it_renders_html_to_pdf_bytes()
    {
        $bytes = app(PdfService::class)->loadHtml('<p>Amount: ₹ 1,00,000</p>')->output();

        $this->assertStringStartsWith('%PDF-', $bytes);
    }

    #[Test]
    public function inline_returns_a_pdf_response_shown_in_the_browser()
    {
        $response = app(PdfService::class)->loadHtml('<p>Hello</p>')->inline('invoice-42.pdf');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename="invoice-42.pdf"', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    #[Test]
    public function download_returns_a_pdf_response_saved_as_a_file()
    {
        $response = app(PdfService::class)->loadHtml('<p>Hello</p>')->download('letter.pdf');

        $this->assertSame('attachment; filename="letter.pdf"', $response->headers->get('Content-Disposition'));
    }

    #[Test]
    public function save_creates_missing_directories()
    {
        $path = $this->outputDir . '/offer-letters/2026/letter.pdf';

        app(PdfService::class)->loadHtml('<p>Hello</p>')->save($path);

        $this->assertFileExists($path);
        $this->assertStringStartsWith('%PDF-', file_get_contents($path));
    }

    #[Test]
    public function a_profile_is_merged_over_the_default_settings()
    {
        $service = app(PdfService::class);

        $this->assertSame('B4', $service->config()['format']);
        $this->assertSame('A4', $service->config('letter')['format']);
        $this->assertSame('utf-8', $service->config('letter')['mode']);
    }

    #[Test]
    public function an_unknown_profile_is_rejected()
    {
        $this->expectException(InvalidArgumentException::class);

        app(PdfService::class)->config('does-not-exist');
    }

    #[Test]
    public function the_appraisal_letter_template_renders()
    {
        $data = (object) [
            'commencementDate' => '01 Nov 2026',
            'employeeName' => 'Rahul Verma',
            'employeeFirstName' => 'Rahul',
            'address' => '221B, Sector 21<br>Gurugram',
            'salaryIncreasePercentage' => 12,
            'previousSalary' => 900000,
            'ctcAggregated' => 1008000,
            'basicSalary' => 42000,
            'hra' => 21000,
            'tranportAllowance' => 1600,
            'otherAllowance' => 14000,
            'employeeShare' => 3600,
            'monthlyHealthInsurance' => 1200,
        ];

        $bytes = app(PdfService::class)->loadView('salary::render.appraisal-letter-template', compact('data'))->output();

        $this->assertStringStartsWith('%PDF-', $bytes);
    }

    #[Test]
    public function the_offer_letter_template_renders_with_the_letter_profile()
    {
        $bytes = app(PdfService::class)->loadView('hr.application.draft-joining-letter', [
            'applicant' => (object) ['name' => 'Anjali Singh'],
            'job' => (object) ['title' => 'Software Engineer'],
            'offer_letter_body' => '<p>Body</p>',
        ], 'letter')->output();

        $this->assertStringStartsWith('%PDF-', $bytes);
    }
}
