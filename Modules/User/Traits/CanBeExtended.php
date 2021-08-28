<?php

namespace Modules\User\Traits;

trait CanBeExtended
{
    protected $isExtended = null;

    public function getExtendedAttribute()
    {
        if (! $this->isExtended) {
            $this->isExtended = app('USER_EXTENDED', ['context' => $this]);
        }

        return $this->isExtended;
    }
}
