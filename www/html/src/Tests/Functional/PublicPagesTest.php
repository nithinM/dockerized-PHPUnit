<?php

namespace Acme\Tests;

/**
 * Class PublicPagesTest
 * @package Acme\Test
 */
class PublicPagesTest extends AcmeBaseIntegrationTest
{

    use CrawlTrait;

    /**
     * @param $urlToTest
     * @dataProvider provideUrls
     *
     */

    public function testPages($urlToTest)
    {

        $response_code = $this->crawl('http://nginx' . $urlToTest);

        $this->assertEquals(200, $response_code);
    }

    public function testPageNotFound()
    {
        $response_code = $this->crawl('http://nginx/asdf');
        $this->assertEquals(404, $response_code);
    }

    public function testLoginPage()
    {
        $response_code = $this->crawl('http://nginx/login');
        $this->assertEquals(200, $response_code);
    }

    public function provideUrls()
    {
        return [
            ['/'],
            ['/about-acme'],
            ['/account-activated'],
            ['/success']
        ];

    }

}