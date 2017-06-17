<?php
use Acme\Models\Testimonial;
use Acme\Tests\AcmeBaseIntegrationTest;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/11/17
 * Time: 4:45 PM
 */
class TestimonialTest extends AcmeBaseIntegrationTest
{

    public function testGetUserForTestimonials()
    {

        $testimonial = Testimonial::find(1);
        $user        = $testimonial->user();

        $actual   = get_class($user);
        $expected = HasOne::class;

        $this->assertEquals($expected, $actual);
    }

}