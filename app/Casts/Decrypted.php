<?php
namespace App\Casts;

use Crypt;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Decrypted implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return mixed
     */

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($value === null) {
            return $value;
        }

        try {
            return Crypt::decrypt($value);
        } catch (\Throwable $th) {
            return $value;
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     *
     * @return mixed
     */

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
