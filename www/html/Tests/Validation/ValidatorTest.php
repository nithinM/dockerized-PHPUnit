<?php

/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/7/17
 * Time: 6:23 AM
 */

namespace Acme\Test;

use PHPUnit\Framework\TestCase;
use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Validation\Validator;


class ValidatorTest extends TestCase
{

    protected $request;
    protected $response;
    protected $validator;
    protected $testdata;

    protected function setUpRequestResponse()
    {
        if ( $this->testdata == null ){
            $this->testdata = [];
        }

        //Create new request object
        $this->request = new Request($this->testdata);
        //Create new response object;
        $this->response = new Response($this->request);
        //Create validator object
        $this->validator =  new Validator($this->request, $this->response);

    }

    public function testGetIsValidReturnTrue()
    {

        $this->setUpRequestResponse();
        $this->validator->setIsValid(true);

        $this->assertTrue($this->validator->getIsValid());

    }

    public function testGetIsValidReturnFalse()
    {

        $this->setUpRequestResponse();
        $this->validator->setIsValid(false);

        $this->assertFalse($this->validator->getIsValid());

    }

    public function testCheckForMinStringLengthWithValidData()
    {

        $this->testdata = ['mintype' => 'yellow'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['mintype' => 'min:3']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForMinStringLengthWithInvalidData()
    {

        $this->testdata = ['mintype' => 'x'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['mintype' => 'min:3']);

        $this->assertCount(1, $errors);

    }

    public function testCheckForEmailWithValidData()
    {

        $this->testdata = ['email' => 'nithin@test.lk'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForEmailWithInvalidData()
    {

        $this->testdata = ['email' => 'whatever'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['email' => 'email']);

        $this->assertCount(1, $errors);

    }

}