<?php

$mpdfFonts = (new Mpdf\Config\FontVariables())->getDefaults();

return [
    /*
    |--------------------------------------------------------------------------
    | PDF rendering (mPDF)
    |--------------------------------------------------------------------------
    |
    | Every PDF in the portal is rendered by App\Services\PdfService, a thin
    | wrapper around mPDF. These settings go straight to the mPDF constructor.
    | See https://mpdf.github.io/reference/mpdf-variables/overview.html
    |
    | "default" applies to every document. A named profile is merged on top
    | of it when a caller asks for that profile.
    |
    */

    'default' => [
        'mode' => 'utf-8',
        // Invoices, appraisal letters and NDAs were laid out for B4 paper
        // with 20mm side margins when they were rendered by wkhtmltopdf.
        'format' => 'B4',
        'margin_left' => 20,
        'margin_right' => 20,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'margin_header' => 0,
        'margin_footer' => 0,
        // wkhtmltopdf drew "sans-serif" text in Helvetica and unstyled text
        // (such as NDA templates) in Times. FreeSans and FreeSerif have the
        // same letter widths, so line breaks and table widths stay close to
        // the old output. mPDF swaps "sans-serif" for the first entry in
        // sans_fonts, so FreeSans goes first.
        'default_font' => 'freeserif',
        'sans_fonts' => array_values(array_unique(array_merge(['freesans'], $mpdfFonts['sans_fonts']))),
        // Embed the Free fonts the same way as DejaVu. Without this, mPDF
        // writes text in a position: fixed block (such as the appraisal
        // letter footer) as unreadable glyphs. We only need the Basic
        // Multilingual Plane, which covers every script we print, and ₹.
        'BMPonly' => array_merge($mpdfFonts['BMPonly'], ['freesans', 'freeserif']),
        'tempDir' => storage_path('framework/cache/mpdf'),
    ],

    'profiles' => [
        // Offer and joining letters were always rendered by mPDF with its
        // own defaults. Keep that output unchanged.
        'letter' => [
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9,
            'default_font' => '',
            'sans_fonts' => $mpdfFonts['sans_fonts'],
            'BMPonly' => $mpdfFonts['BMPonly'],
        ],
    ],
];
