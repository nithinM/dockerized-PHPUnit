<?php
use Acme\Models\User;
use Acme\Test\AcmeBaseIntegrationTest;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/11/17
 * Time: 3:58 PM
 */
class UserTest extends AcmeBaseIntegrationTest
{

    public function testGetTestimonialsForUser()
    {

        $user = User::find(1);
        $testimonials = $user->testimonials();

        $actual = get_class($testimonials);
        $expected = HasMany::class;
        $this->assertEquals($expected, $actual);

    }

}