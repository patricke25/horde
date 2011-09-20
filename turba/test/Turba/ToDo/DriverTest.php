<?php

require_once dirname(__FILE__) . '/TestBase.php';

/**
 * Test cases for the Turba_Driver:: class
 *
 * @author  Jason M. Felice <jason.m.felice@gmail.com>
 * @package Turba
 * @subpackage UnitTests
 */
class Turba_DriverTest extends Turba_TestBase {

    function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    function test_search_results_should_be_sorted_according_to_supplied_sort_order()
    {
        $this->assertSortsList(array($this, 'doSearch'));
    }

    function doSearch($order)
    {
        $driver = $this->getDriver();
        $this->fakeAuth();
        return $driver->search(array('__type' => 'Object'), $order, 'AND');
    }

}
