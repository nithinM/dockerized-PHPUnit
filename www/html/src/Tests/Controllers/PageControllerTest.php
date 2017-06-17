<?php
use Acme\Controllers\PageController;
use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Http\Session;
use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use PHPUnit\Framework\TestCase;


class PageControllerTest extends TestCase
{
    protected $request;
    protected $response;
    protected $session;
    protected $blade;
    protected $signer;
    protected $validator;

    /**
     * @dataProvider providerTestMakeSlug
     */
    public function testMakeSlug($original, $expected)
    {
        $controller = $this->getMockBuilder(PageController::class)
            ->setConstructorArgs([$this->request, $this->response, $this->session, $this->signer, $this->blade])
            ->setMethods(null)
            ->getMock();

        $original = 'Hello, world!';
        $expected = 'hello-world';

        $actual = $controller->makeSlug($original);

        $this->assertEquals($expected, $actual);
    }

    public function providerTestMakeSlug()
    {
        return [
            ['Hello, world!', 'hello-world'],
            ['This is a test URL', 'this-is-a-test-url'],
            ['one & two ?', 'one-two'],
            ['URL with 123', 'url-with-123']
        ];
    }

    protected function setUp()
    {
        $this->signer = $this->getMockBuilder(SignatureGenerator::class)
            ->setConstructorArgs(['abc123'])
            ->getMock();

        $this->blade = $this->getMockBuilder(BladeInstance::class)
            ->setConstructorArgs(['viewPath', 'cachePath'])
            ->getMock();

        $this->session = $this->getMockBuilder(Session::class)
            ->getMock();

        $this->request = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->getMock();


    }

}