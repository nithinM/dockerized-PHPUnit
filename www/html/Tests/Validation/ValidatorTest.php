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

    public function testGetIsValidReturnTrue()
    {

        //Create new request object
        $request =  new Request([]);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $validator->setIsValid(true);

        $this->assertTrue($validator->getIsValid());
    }

    public function testGetIsValidReturnFalse()
    {

        //Create new request object
        $request =  new Request([]);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $validator->setIsValid(false);

        $this->assertFalse($validator->getIsValid());
    }

    public function testCheckForMinStringLengthWithValidData()
    {

        //Create new request object
        $request =  new Request(['mintype' => 'yellow']);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $errors = $validator->check(['mintype' => 'min:3']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForMinStringLengthWithInvalidData()
    {

        //Create new request object
        $request =  new Request(['mintype' => 'x']);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $errors = $validator->check(['mintype' => 'min:3']);

        $this->assertCount(1, $errors);

    }

    public function testCheckForEmailWithValidData()
    {

        //Create new request object
        $request =  new Request(['email' => 'nithin@test.lk']);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);

    }

    public function testCheckForEmailWithInvalidData()
    {

        //Create new request object
        $request =  new Request(['email' => 'whatever']);
        //Create new response object;
        $response = new Response($request);
        //Create validator object
        $validator = new Validator($request, $response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(1, $errors);

    }

}