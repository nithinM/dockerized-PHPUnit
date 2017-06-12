<?php
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/11/17
 * Time: 4:58 PM
 */

namespace Acme\Test;


use Acme\Http\Request;
use Acme\Models\User;
use Acme\Validation\Validator;
use Illuminate\Database\Eloquent\Collection;

class ValidatorIntegrationTest extends AcmeBaseIntegrationTest
{
    public function testGetRows()
    {
        $req = $this->getMockBuilder(Request::class)
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue(1));

        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$req, $this->response, $this->session])
            ->setMethods(null)
            ->getMock();

        $rows      = $validator->getRows(User::class, "id");
        $original  = get_class($rows);
        $expected  = Collection::class;

        $this->assertEquals($original, $expected);
        foreach ($rows as $row) {
            $this->assertEquals($row->id, 1);
        }
    }
}