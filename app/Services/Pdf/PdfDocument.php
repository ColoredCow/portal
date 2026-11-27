<?php

namespace App\Services\Pdf;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * One rendered PDF. Built by App\Services\PdfService.
 *
 * The HTML is rendered on first use and the bytes are kept, so calling
 * output(), save() and inline() on the same document renders it once.
 */
class PdfDocument
{
    private ?string $bytes = null;

    public function __construct(private string $html, private array $config = [])
    {
    }

    public function output(): string
    {
        if ($this->bytes === null) {
            $this->bytes = $this->render();
        }

        return $this->bytes;
    }

    public function save(string $path): static
    {
        File::ensureDirectoryExists(dirname($path));
        File::put($path, $this->output());

        return $this;
    }

    public function inline(string $filename = 'document.pdf'): Response
    {
        return $this->response($filename, 'inline');
    }

    public function download(string $filename = 'document.pdf'): Response
    {
        return $this->response($filename, 'attachment');
    }

    private function response(string $filename, string $disposition): Response
    {
        return new Response($this->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . addcslashes($filename, '"\\') . '"',
        ]);
    }

    private function render(): string
    {
        if (isset($this->config['tempDir'])) {
            File::ensureDirectoryExists($this->config['tempDir']);
        }

        $mpdf = new Mpdf($this->config);
        $mpdf->WriteHTML($this->html);

        return $mpdf->Output('', Destination::STRING_RETURN);
    }
}
