<?php

namespace App\Database\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MariaDb1043Platform;
use Illuminate\Database\DBAL\TimestampType as BaseTimestampType;

/**
 * Fills a MariaDB 10.4 gap in Laravel's `timestamp` Doctrine type.
 *
 * Illuminate's TimestampType switches on `get_class($platform)`, so it matches
 * the exact class and never a subclass. Its list covers MariaDBPlatform and the
 * 10.2.7 / 10.5.2 / 10.6 / 10.10 platforms but omits MariaDb1043Platform, which
 * doctrine/dbal 3.10+ selects for MariaDB 10.4.3 up to 10.5.1. On those servers
 * the match falls through to `default` and throws
 * "Invalid platform: MariaDb1043Platform", so any migration calling `->change()`
 * on a timestamp column fails. MariaDB takes MySQL syntax here, so we send it to
 * the MySQL declaration.
 *
 * Registered as the `timestamp` type through `database.dbal.types` in
 * config/database.php.
 *
 * MariaDb1043Platform is also the base of dbal's newer MariaDB classes
 * (10.10 -> 10.6 -> 10.5.2 -> 10.4.3), so this `instanceof` catches those too.
 * The parent already routed them to the same declaration, so nothing changes
 * for them.
 *
 * Needed only while we are on Laravel 10. Laravel 11 drops doctrine/dbal for
 * schema changes and deletes the base class, so this goes away in that phase.
 */
class TimestampType extends BaseTimestampType
{
    /**
     * Get the SQL declaration for a timestamp column.
     *
     * @param  array  $column
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof MariaDb1043Platform) {
            return $this->getMySqlPlatformSQLDeclaration($column);
        }

        return parent::getSQLDeclaration($column, $platform);
    }
}
