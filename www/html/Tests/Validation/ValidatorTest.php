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
use Acme\Validation\Validator;
use Kunststube\CSRFP\SignatureGenerator;
use PHPUnit\Framework\TestCase;


class ValidatorTest extends TestCase
{

    protected $request;
    protected $response;
    protected $validator;
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

        $validator = new Validator($this->request, $this->response);
        $validator->setIsValid(true);

        $this->assertTrue($validator->getIsValid());

    }

    public function testGetIsValidReturnFalse()
    {

        $validator = new Validator($this->request, $this->response);
        $validator->setIsValid(false);

        $this->assertFalse($validator->getIsValid());

    }

    public function testCheckForMinStringLengthWithValidData()
    {

        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue('yellow'));

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['mintype' => 'min:3']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForMinStringLengthWithInvalidData()
    {

        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->willReturn('x');

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['mintype' => 'min:3']);

        $this->assertCount(1, $errors);

    }

    public function testCheckForEmailWithValidData()
    {

        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->willReturn('nithin@axis.lk');

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForEmailWithInvalidData()
    {

        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->willReturn('whatever');

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(1, $errors);

    }

    protected function setUp()
    {
        $signer = $this->getMockBuilder(SignatureGenerator::class)
            ->setConstructorArgs(['abc123'])
            ->getMock();

        $this->request = $this->getMockBuilder(Request::class)
            ->getMock();

        $this->response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $signer])
            ->getMock();

    }

    /*
    public function testValidateWithInvalidateData()
    {

        $this->testdata = ['check_field' => 'x'];
        $this->setUpRequestResponse();
        $this->validator->validate(['check_field' => 'x'], '/register');

    }*/
}