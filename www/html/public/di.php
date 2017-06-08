<?php
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/8/17
 * Time: 5:41 PM
 */

namespace di;

class Foo {
    // Logic
}

class Bar {

    private $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

}