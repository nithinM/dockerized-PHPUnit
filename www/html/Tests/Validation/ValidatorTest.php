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
}