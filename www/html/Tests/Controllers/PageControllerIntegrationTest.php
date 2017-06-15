<?php

namespace Acme\Test;

use Acme\Controllers\PageController;
use Acme\Http\Response;
use PHPUnit\Framework\Assert;

/**
 * Class PageControllerIntegrationTest
 * @package Acme\Test
 */
class PageControllerIntegrationTest extends AcmeBaseIntegrationTest
{
    public function testGetShowHomepage()
    {

        $response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->setMethods(['render'])
            ->getMock();

        $response->method('render')
            ->willReturn('true');

        $controller = new PageController($this->request, $response, $this->session, $this->signer, $this->blade);

        $controller->getShowHomePage();

        $expected = 'home';
        $actual   = self::readAttribute($response, 'view');

        $this->assertEquals($expected, $actual);

    }

    public function testGetShowPage()
    {

        $response = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->setMethods(['render'])
            ->getMock();

        $response->method('render')
            ->willReturn('true');

        $controller = $this->getMockBuilder(PageController::class)
            ->setConstructorArgs([$this->request, $response, $this->session, $this->signer, $this->blade])
            ->setMethods(['getUri'])
            ->getMock();

        $controller->expects($this->once())
            ->method('getUri')
            ->will($this->returnValue('about-acme'));

        $controller->getShowPage();

        $expected = "About Acme";
        $actual   = $controller->page->browser_title;

        $this->assertEquals($expected, $actual);

        $expected = 'generic-page';
        $actual   = self::readAttribute($response, 'view');

        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual   = $controller->page->id;

        $this->assertEquals($expected, $actual);

    }
}