<?php

namespace Modules\LegalDocument\Entities;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentMailTemplate extends Model
{
    protected $fillable = ['subject', 'body', 'legal_document_id'];

    public function parse($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            $index = trim($index);
            $index = str_replace('$', '', $index);
            if (isset($data[$index])) {
                return $data[$index];
            } else {
            }
        }, $this->body);

        return $parsed;
    }
}
