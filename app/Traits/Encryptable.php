<?php

namespace App\Traits;

use Crypt;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable)) {
            try {
                $value = $this->decryptValue($value);
            } catch (\Throwable $th) {
            }

            return $value;
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && $value !== null) {
            $value = $this->encryptValue($value);
        }

        return parent::setAttribute($key, $value);
    }

    private function encryptValue($value)
    {
        return Crypt::encrypt($value);
    }

    private function decryptValue($value)
    {
        return Crypt::decrypt($value);
    }
}
