<?php
namespace Acme\Test;
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/13/17
 * Time: 6:01 AM
 */

use Acme\Controllers\PageController;
use Acme\Http\Response;
use PHPUnit\Framework\Assert;

/**
 * Class PageControllerIntegrationTest
 * @package Acme\Test
 */
class PageControllerIntegrationTest extends AcmeBaseIntegrationTest
{
    public function testGetShowHomepage(){

        $response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->setMethods(['render'])
            ->getMock();

        $response->method('render')
            ->willReturn('true');

        $controller = new PageController($this->request, $response, $this->session, $this->signer, $this->blade);

        $controller->getShowHomePage();

        $expected = 'home';
        $actual = self::readAttribute($response, 'view');

        $this->assertEquals($expected, $actual);

    }
}