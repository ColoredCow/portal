<?php

namespace Modules\LegalDocument\Entities;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentMailTemplate extends Model
{
    protected $fillable = ['subject', 'body', 'legal_document_id'];

    public function parse($data)
    {
        return preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            [$_shortCode, $index] = $matches;
            $index = trim($index);
            $index = str_replace('$', '', $index);
            if (isset($data[$index])) {
                return $data[$index];
            }
        }, $this->body);
    }
}
