<?php
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/11/17
 * Time: 3:53 PM
 */

namespace Acme\Test;


use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Http\Session;
use Dotenv;
use duncan3dc\Laravel\BladeInstance;
use Illuminate\Database\Capsule\Manager as Capsule;
use Kunststube\CSRFP\SignatureGenerator;
use PDO;
use PHPUnit\DbUnit\TestCase;

/**
 * Class AcmeBaseIntegrationTest
 * @package Acme\Tests
 */
abstract class AcmeBaseIntegrationTest extends TestCase
{
    public $bootstrapResources;
    public $dbAdapter;
    public $bootstrap;
    public $conn;
    public $session;

    protected $request;
    protected $response;
    protected $blade;


    public function setUp()
    {
        require __DIR__ . '/../vendor/autoload.php';
        require __DIR__ . '/../bootstrap/functions.php';
        Dotenv::load(__DIR__ . '/../');

        $capsule = new Capsule();
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'mariadbtest',
            'database'  => 'laravel_db_test',
            'username'  => 'root',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $signer   = $this->getMockBuilder(SignatureGenerator::class)
            ->setConstructorArgs(['abc123'])
            ->getMock();
        $this->session  = $this->getMockBuilder(Session::class)
            ->getMock();
        $this->blade    = $this->getMockBuilder(BladeInstance::class)
            ->setConstructorArgs(['viewPath', 'cachePath'])
            ->getMock();
        $this->request  = $this->getMockBuilder(Request::class)
            ->getMock();
        $this->response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $signer, $this->blade, $this->session])
            ->getMock();
    }

    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . "/laravel_db.xml");
    }

    public function getConnection()
    {
        $db = new PDO(
            "mysql:host=mariadbtest;dbname=laravel_db_test",
            "root", "secret");
        return $this->createDefaultDBConnection($db, "laravel_db_test");
    }
}
