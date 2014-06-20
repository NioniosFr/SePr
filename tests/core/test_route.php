<?php

/**
 * Tests to test that that testing framework is testing tests.
 */
class Test_RouteClass extends PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     *
     * @see PHPUnit_TestCase::setUp()
     */
    function setUp()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP1.1:';
        $_SERVER['REQUEST_URI'] = 'uri';
        $_SERVER['QUERY_STRING'] = '';
        $_REQUEST = null;

        // Include the plugin class.
        require_once BASE . '/common/route.class.php';
    }

    /**
     * (non-PHPdoc)
     *
     * @see PHPUnit_TestCase::tearDown()
     */
    function tearDown()
    {}

    function test_getArgumentsFromNullRequest()
    {
        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals(null, $actual);
        $actual = $route->getArguments();
        $this->assertEquals(null, $actual);
    }
    function test_getArgumentsWithoutPathInput()
    {
        $_REQUEST = array(
            'some' => 'value'
        );
        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals(null, $actual);
    }

    function test_getArgumentsWithPathInput()
    {
        $_REQUEST = array(
            'path' => ''
        );
        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals(null, $actual);
    }

    function test_getArgumentsWithFullInput()
    {
        $_REQUEST = array(
            'path' => '',
            'key1' => 'value1',
            'key2' => 2
        );
        $expected = array(
            'key1' => 'value1',
            'key2' => '2'
        );

        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals($expected, $actual);
    }

    function test_getArgumentsWithSpecialChars()
    {
        $_REQUEST = array(
            'path' => '',
            'html' => '&amp;%3C%3B%21%23',
            'spaces' => '%20hello%20world'
        );
        $expected = array(
            'html' => '&<;!#',
            'spaces' => ' hello world'
        );

        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Skip this: Not yet implemented.
     */
    function test_getArgumentsFromUTF8()
    {
        $this->markTestSkipped('UTF8 support is not yet implemented.');

        $_REQUEST = array(
            'path' => '',
            'utf8' => '%FC%D8%E9',
            'GR' => 'αβγδπλρωΨΩΛΔΘ'
        );
        $expected = array(
            'utf8' => 'üØé',
            'GR' => 'αβγδπλρωΨΩΛΔΘ'
        );

        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals($expected, $actual);
    }

    function test_getMethodWithEmptyArray()
    {
        $route = new Route();

        $actual = $route->getMethod(array());
        $this->assertEquals(null, $actual);

        $actual = $route->getMethod(array(
            ''
        ));
        $this->assertEquals(null, $actual);

        $actual = $route->getMethod(array(
            ' '
        ));
        $actual = $route->getMethod(array(
            null
        ));
        $this->assertEquals(null, $actual);
    }

    function test_getMethodWithArrayKeys()
    {
        $route = new Route();

        $actual = $route->getMethod(array(
            'first' => 'somevalue',
            'second' => 132165
        ));
        $this->assertEquals(null, $actual);

        $actual = $route->getMethod(array(
            2 => 'somevalue',
            'second' => 132165
        ));
        $this->assertEquals(null, $actual);

        $actual = $route->getMethod(array(
            0 => 'expected',
            'second' => 132165
        ));
        $this->assertEquals('expected', $actual);

        $actual = $route->getMethod(array(
            'first' => 012345,
            0 => 'expected'
        ));
        $this->assertEquals('expected', $actual);

        $actual = $route->getMethod(array(
            'first' => 'somevalue',
            0 => 012345
        ));
        $this->assertEquals(null, $actual);
    }

    function test_getMethodWithArrayIndexes()
    {
        $route = new Route();

        $actual = $route->getMethod(array(
            'expected',
            12345
        ));
        $this->assertEquals('expected', $actual);
        // First argument has to be a string.
        $actual = $route->getMethod(array(
            12345,
            'somevalue'
        ));
        $this->assertEquals(null, $actual);

        $actual = $route->getMethod(array(
            null,
            'somevalue'
        ));
        $this->assertEquals(null, $actual);

    }

    function test_getActionFromNullRequest()
    {
        $route = new Route();

        $actual = $route->getAction();
        $this->assertEquals(null, $actual);
    }

    function test_getActionFromEmptyRequest()
    {
        $_REQUEST = array();
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);
    }

    function test_getActionFromRequestWithoutPath()
    {
        $_REQUEST = array(
            'other',
            'variables',
            'and' => 'pairs'
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);
    }

    function test_getActionFromRequestWithMalformedPath()
    {
        //global $path;
        $_REQUEST = array(
            'path'=> '1358%0865dafcaes65f1v%204edfv',
            'empty' =>'%20',
            'uninitialized' => null
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);
    }

    function test_getActionForInvalidController()
    {
        $_REQUEST = array(
            'path'=> '../etc/config.ini.php'
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);

    }

    function test_getActionForValidController()
    {
        $_REQUEST = array(
            'path'=> 'user/blablala/%3C%20%3E'
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('user', $actual);
    }

    function test_getActionForValidMisplacedController()
    {
        $_REQUEST = array(
            'path'=> 'sdad%20asda/user/blablala/%3C%%3E'
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);
    }

    function test_getActionForMistypedButValidController()
    {
        $_REQUEST = array(
            'path'=> 'uSer/blablala'
        );
        $route = new Route();

        $route->getAction();
        $actual = $route->action;
        $this->assertEquals('default', $actual);

    }
}
