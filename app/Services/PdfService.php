<?php

namespace App\Services;

use App\Services\Pdf\PdfDocument;
use InvalidArgumentException;

/**
 * Renders HTML or a Blade view to PDF with mPDF.
 *
 * Usage:
 *   app(PdfService::class)->loadView('invoice::render.invoice-template', $data)->inline('invoice.pdf');
 *   app(PdfService::class)->loadHtml($html, 'letter')->save($path);
 */
class PdfService
{
    public function loadView(string $view, array $data = [], ?string $profile = null): PdfDocument
    {
        return $this->loadHtml(view($view, $data)->render(), $profile);
    }

    public function loadHtml(string $html, ?string $profile = null): PdfDocument
    {
        return new PdfDocument($html, $this->config($profile));
    }

    public function config(?string $profile = null): array
    {
        $config = config('pdf.default', []);

        if ($profile === null) {
            return $config;
        }

        $overrides = config("pdf.profiles.{$profile}");
        if (! is_array($overrides)) {
            throw new InvalidArgumentException("Unknown PDF profile [{$profile}].");
        }

        return array_merge($config, $overrides);
    }
}
