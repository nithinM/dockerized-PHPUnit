<?php

/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/7/17
 * Time: 6:23 AM
 */

namespace Acme\Test;

use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Http\Session;
use Acme\Validation\Validator;
use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use PHPUnit\Framework\TestCase;


class ValidatorTest extends TestCase
{

    protected $request;
    protected $response;
    protected $validator;
    protected $session;
    protected $blade;
    protected $signer;
//    protected $testdata;

//    protected function setUpRequestResponse()
//    {
//        if ( $this->testdata == null ){
//            $this->testdata = [];
//        }
//
//        //Create new request object
//        $this->request = new Request($this->testdata);
//        //Create new response object;
//        $this->response = new Response($this->request);
//        //Create validator object
//        $this->validator =  new Validator($this->request, $this->response);
//
//    }

    public function testGetIsValidReturnTrue()
    {

        $validator = new Validator($this->request, $this->response, $this->session);
        $validator->setIsValid(true);

        $this->assertTrue($validator->getIsValid());

    }

    public function testGetIsValidReturnFalse()
    {

        $validator = new Validator($this->request, $this->response, $this->session);
        $validator->setIsValid(false);

        $this->assertFalse($validator->getIsValid());

    }

    public function testCheckForMinStringLengthWithValidData()
    {

        $req = $this->getRequest('yellow');

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['mintype' => 'min:3']);

        $this->assertCount(0, $errors);

    }

    public function getRequest($input = '')
    {
        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->willReturn($input);

        return $req;
    }

    /**
     *
     */
    public function testCheckForMinStringLengthWithInvalidData()
    {

        $req = $this->getRequest('x');

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['mintype' => 'min:3']);

        $error_msg = $errors[0];

        $this->assertTrue(strContains($error_msg, 'must be at least'));

//        $this->assertCount(1, $errors);

    }

    public function testCheckForEmailWithValidData()
    {

        $req = $this->getRequest('nithin@axis.lk');

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForEmailWithInvalidData()
    {

        $req = $this->getRequest('whatever');

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['email' => 'email']);

        $error_msg = $errors[0];

        $this->assertTrue(strContains($error_msg, 'must be a valid email!'));

//        $this->assertCount(1, $errors);

    }

    public function testCheckForEqualToValidData()
    {

        //All methods stubs, all methods return null, all methods can be overridden
        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        //All methods stubs, all methods return null, all methods can be overridden
        /*$req = $this->getMockBuilder(Request::class)
            ->getMock([]);*/

        //All methods mocks
        /*$req = $this->getMockBuilder(Request::class)
            ->getMock(null);*/

        //All methods in array stubs others are mocks, array of methods return null, all methods can be overridden
        /*$req = $this->getMockBuilder(Request::class)
            ->getMock(['method_1', 'method_2']);*/

        $req->expects($this->at(0))
            ->method('input')
            ->willReturn('Nithin');
        $req->expects($this->at(1))
            ->method('input')
            ->willReturn('Nithin');

        $validator = new Validator($req, $this->response, $this->session);
        $error     = $validator->check(['first_input' => 'equalTo:second_input']);

        $this->assertCount(0, $error);

    }

    public function testCheckForEqualToInvalidData()
    {

        //All methods stubs, all methods return null, all methods can be overridden
        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->at(0))
            ->method('input')
            ->willReturn('Nithin');
        $req->expects($this->at(1))
            ->method('input')
            ->willReturn('Manasha');

        $validator = new Validator($req, $this->response, $this->session);
        $errors    = $validator->check(['first_input' => 'equalTo:second_input']);

        $error_msg = $errors[0];

        $this->assertStringStartsWith('Value does not match verification value', $error_msg);

//        $this->assertCount(1, $errors);

    }

    public function testCheckForUniqueValidData()
    {

        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['getRows'])
            ->getMock();

        $validator->method('getRows')
            ->willReturn([]);

        $error = $validator->check(['my_field' => 'unique:User']);

        $this->assertCount(0, $error);

    }

    public function testCheckForUniqueInValidData()
    {

        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['getRows'])
            ->getMock();

        $validator->method('getRows')
            ->willReturn(['a']);

        $errors = $validator->check(['my_field' => 'unique:User']);

        $error_msg = $errors[0];

        $this->assertTrue(strContains($error_msg, 'already exists in this system!'));

//        $this->assertCount(1, $errors);

    }

    public function testValidateWithValidateData()
    {

        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['check'])
            ->getMock();

        $isValid = $validator->validate(['foo' => 'min:3'], '/register');

        $this->assertTrue($isValid);


    }

    public function testValidateWithInvalidateData()
    {

        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['check', 'redirectToPage'])
            ->getMock();

        $validator->expects($this->once())
            ->method('check')
            ->willReturn(['Some errors']);

        $validator->expects($this->once())
            ->method('redirectToPage');

        $validator->validate(['foo' => 'min:1'], '/bar');

    }

    public function testRedirectToPage()
    {
        // in order to run a unit test on this method and allow for an assertion,
        // we'll mock the response class and override redirectToPage to return a true
        $res = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->setMethods(['render'])
            ->getMock();

        $res->expects($this->once())
            ->method('render')
            ->will($this->returnValue([true]));

        $validator = new Validator($this->request, $res, $this->session);
        $result    = $this->run_protected_method($validator, 'redirectToPage', ['/whatever', []]);
        $this->assertNull($result);
    }

    /**
     * Use reflection to allow us to run protected methods
     *
     * @param $obj
     * @param $method
     * @param array $args
     * @return mixed
     */
    protected function run_protected_method($obj, $method, $args = array())
    {
        $method = new \ReflectionMethod(get_class($obj), $method);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    protected function setUp()
    {

        include(__DIR__ . '/../../bootstrap/functions.php');

        $this->signer = $this->getMockBuilder(SignatureGenerator::class)
            ->setConstructorArgs(['abc123'])
            ->getMock();

        $this->session = $this->getMockBuilder(Session::class)
            ->getMock();

        $this->blade = $this->getMockBuilder(BladeInstance::class)
            ->setConstructorArgs(['view-path', 'cache-path'])
            ->getMock();

        $this->request = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->getMock();

    }

}