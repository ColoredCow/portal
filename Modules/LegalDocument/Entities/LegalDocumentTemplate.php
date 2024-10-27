<?php
namespace Modules\LegalDocument\Entities;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentTemplate extends Model
{
    protected $fillable = ['title', 'body', 'legal_document_id'];

    public function parse($data)
    {
        return preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            $index = $matches[1];
            $index = trim($index);
            $index = str_replace('$', '', $index);
            if (isset($data[$index])) {
                return $data[$index];
            }
        }, $this->body);
    }
}
