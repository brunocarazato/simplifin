<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

final class EloquentConnectionTest extends PHPUnit_TestCase
{
    protected static Capsule $capsule;

    public static function setUpBeforeClass(): void
    {
    
        // Instancia e configura Eloquent
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver'    => getenv('DB_DRIVER'),
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        self::$capsule = $capsule;
    }

    public function testEloquentConnectionIsWorking(): void
    {
        // Tenta rodar um comando simples
        $result = self::$capsule->getConnection()->select('SELECT 1 as result');

        $this->assertEquals(1, $result[0]->result);
    }
}
