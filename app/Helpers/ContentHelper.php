<?php

namespace App\Helpers;

class ContentHelper
{
    /**
     * Replaces all occurences of \r\n in the requested text.
     * Primarily keeps the content formatted in the mails.
     *
     * @param  string $content
     *
     * @return string
     */
    public static function editorFormat(string $content)
    {
        return preg_replace('/\r\n/', '', $content);
    }
}
