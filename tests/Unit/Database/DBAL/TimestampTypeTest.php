<?php

namespace Tests\Unit\Database\DBAL;

use App\Database\DBAL\TimestampType;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Platforms\MariaDb1043Platform;
use Doctrine\DBAL\Platforms\MariaDb110700Platform;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\DBAL\TimestampType as BaseTimestampType;
use Tests\TestCase;

class TimestampTypeTest extends TestCase
{
    /**
     * The override is only wired up by the `dbal.types` entry in
     * config/database.php. Nothing else registers it, so if that import gets
     * pointed back at the framework class (an easy merge-conflict resolution,
     * since that is what the base branch has) this class becomes dead code and
     * every other test here would still pass.
     *
     * @test
     */
    public function it_is_registered_as_the_doctrine_timestamp_type()
    {
        // Resolving a connection is what runs
        // DatabaseManager::registerConfiguredDoctrineTypes(). The PDO stays
        // lazy, so this touches no database.
        $this->app['db']->connection();

        $this->assertInstanceOf(TimestampType::class, Type::getType('timestamp'));
    }

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

    /** @test */
    public function it_declares_a_mariadb_11_7_timestamp_using_mysql_syntax()
    {
        $declaration = (new TimestampType())->getSQLDeclaration(
            ['precision' => 0, 'notnull' => false],
            new MariaDb110700Platform()
        );

        $this->assertSame('TIMESTAMP NULL', $declaration);
    }

    /**
     * Guards the reason this class exists: without the override, MariaDB 10.4.3
     * to 10.5.1 falls through Illuminate's platform match and throws. If a later
     * Laravel release adds MariaDb1043Platform to that match, this test fails.
     * The override can only be deleted once the 11.7 case below passes too.
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
    public function the_framework_type_it_extends_still_rejects_mariadb_11_7()
    {
        $this->expectException(DBALException::class);
        $this->expectExceptionMessage('Invalid platform: MariaDb110700Platform');

        (new BaseTimestampType())->getSQLDeclaration(
            ['precision' => 0, 'notnull' => false],
            new MariaDb110700Platform()
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
