<?php

namespace Tests\Unit\Database\DBAL;

use App\Database\DBAL\TimestampType;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Platforms\MariaDb1043Platform;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Illuminate\Database\DBAL\TimestampType as BaseTimestampType;
use Tests\TestCase;

class TimestampTypeTest extends TestCase
{
    /** @test */
    public function it_declares_a_mariadb_timestamp_using_mysql_syntax()
    {
        $declaration = (new TimestampType())->getSQLDeclaration(
            ['precision' => 0, 'notnull' => false],
            new MariaDb1043Platform()
        );

        $this->assertSame('TIMESTAMP NULL', $declaration);
    }

    /** @test */
    public function it_keeps_the_precision_of_a_not_null_mariadb_timestamp()
    {
        $declaration = (new TimestampType())->getSQLDeclaration(
            ['precision' => 3, 'notnull' => true],
            new MariaDb1043Platform()
        );

        $this->assertSame('TIMESTAMP(3)', $declaration);
    }

    /**
     * Guards the reason this class exists: without the override, MariaDB 10.4.3
     * to 10.5.1 falls through Illuminate's platform match and throws. If a later
     * Laravel release adds MariaDb1043Platform to that match, this test fails and
     * the override can be deleted.
     *
     * @test
     */
    public function the_framework_type_it_extends_still_rejects_mariadb_10_4()
    {
        $this->expectException(DBALException::class);
        $this->expectExceptionMessage('Invalid platform: MariaDb1043Platform');

        (new BaseTimestampType())->getSQLDeclaration(
            ['precision' => 0, 'notnull' => false],
            new MariaDb1043Platform()
        );
    }

    /** @test */
    public function it_leaves_non_mariadb_platforms_to_the_framework_type()
    {
        $column = ['precision' => 0, 'notnull' => false];
        $platform = new SqlitePlatform();

        $this->assertSame(
            (new BaseTimestampType())->getSQLDeclaration($column, $platform),
            (new TimestampType())->getSQLDeclaration($column, $platform)
        );
    }
}
