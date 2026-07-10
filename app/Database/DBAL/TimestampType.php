<?php

namespace App\Database\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MariaDb1043Platform;
use Doctrine\DBAL\Platforms\MariaDb110700Platform;
use Illuminate\Database\DBAL\TimestampType as BaseTimestampType;

class TimestampType extends BaseTimestampType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof MariaDb1043Platform || $platform instanceof MariaDb110700Platform) {
            return $this->getMySqlPlatformSQLDeclaration($column);
        }

        return parent::getSQLDeclaration($column, $platform);
    }
}
