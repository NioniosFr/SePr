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

    function test_getArgumentsWithNullRequest()
    {
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
            'key' => 'value'
        );
        $expected = array(
            'key' => 'value'
        );

        $route = new Route();
        $actual = $route->getArguments();
        $this->assertEquals($expected, $actual);
    }
}

