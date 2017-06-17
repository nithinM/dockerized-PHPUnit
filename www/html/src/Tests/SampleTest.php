<?php
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/6/17
 * Time: 5:19 PM
 */

namespace Acme\Test;

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{

    public function testIsTrue()
    {
        $myVar = true;
        $this->assertTrue($myVar);
    }
}