#####Useful commands

######Upgrade composer package

- If you want to update the old composer package to latest, please 
remove the old package and then install the latest. As a example if 
you want to update the 'respect/validation' package, first remove the 
package as below and then install package again. If your code break after
the upgrade please refer the [respect/validation Backward Compatibility Break](https://github.com/Respect/Validation/wiki/Respect%5CValidation-1.0)

```
#Remove the package
composer remove respect/validation --update-with-dependencies

#Install the package again
composer require respect/validation
```


######Setup PHPUnit

- Install PHPUnit using composer (as a dev dependency)
```
composer require phpunit/phpunit --dev
```

######Run first unit test :)
- Create `phpunit.xml` in the project root folder and add below code snippet.

```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit colors="true">
    <testsuites>
        <testsuite name="Application Test Suite">
            <directory>./Tests/</directory>
        </testsuite>
    </testsuites>
</phpunit>
```
- Create a `Test` folder in the project root
- Create php class `SampleTest` (Test is required).
- PHPUnit's units of code are now namespaced. For instance, `PHPUnit_Framework_TestCase` is now `PHPUnit\Framework\TestCase`. More info [Release Announcement for PHPUnit 6.0.0](https://github.com/sebastianbergmann/phpunit/wiki/Release-Announcement-for-PHPUnit-6.0.0)
- After right your very first PHPUnit, it look likes below.
```
<?php

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
```
- To run the PHPUnit

```
vendor/bin/phpunit
```

######Run code coverage 
- For run the code coverage in terminal you have to configure xdebug - [Tutorial](http://blog.arroyolabs.com/2016/10/docker-xdebug/)
- Update the ` phpunit.xml `. Please put below code snippet after `<testsuites>` close.

```
<!-- Put this snippt in the phpunit.xml -->
<filter>
    <whitelist processUncoveredFilesFromWhiteList="true">
        <directory suffix=".php">./src</directory>
    </whitelist>
</filter>
```
 
- Then run the code coverage 
```
vendor/bin/phpunit --coverage-html coverage
```

######Basic unit test
- Should always have to mirror structure of the source code in side the `Test` folder.
- For this example we use the `src/Validation/Validator.php`. So create a folder `Validation` in side the `Test` folder.
Then create a php class file `ValidatorTest.php` (Test word required otherwise PHPUnit ignore it).
- Add below code snippet.
```
<?php

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
```
- Run PHPUnit Test
```
vendor/bin/phpunit
```

