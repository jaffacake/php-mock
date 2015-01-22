<?php

namespace malkusch\phpmock\functions;

/**
 * Tests AbstractSleepFunction and all its implementations.
 *
 * @author Markus Malkusch <markus@malkusch.de>
 * @link bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK Donations
 * @license http://www.wtfpl.net/txt/copying/ WTFPL
 * @see AbstractSleepFunction
 */
class AbstractSleepFunctionTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Tests incrementation of all Incrementables
     *
     * @test
     */
    public function testSleepIncrementationOfAllIncrementables()
    {
        $value1 = new FixedValueFunction(1);
        $value2 = new FixedValueFunction(2);
        $sleep = new SleepFunction(array($value1, $value2));
        
        $sleep->sleep(1);
        
        $this->assertEquals(2, $value1->getValue());
        $this->assertEquals(3, $value2->getValue());
    }
    
    /**
     * Tests incrementation of Incrementables
     *
     * @param AbstractSleepFunction $sleepFunction Tested implementation.
     * @param int $amount                          Amount of time units.
     * @param mixed $expected                      Expected seconds.
     *
     * @test
     * @dataProvider provideTestSleepIncrementation
     */
    public function testSleepIncrementation(
        AbstractSleepFunction $sleepFunction,
        $amount,
        $expected
    ) {
        $value = new FixedValueFunction(0);
        $sleepFunction->addIncrementable($value);
        $sleepFunction->sleep($amount);
        $this->assertEquals($expected, $value->getValue());
    }
    
    /**
     * Returns test cases for testSleepIncrementation().
     *
     * @return array Test cases.
     */
    public function provideTestSleepIncrementation()
    {
        return array(
            array(new SleepFunction(), 1, 1),
            array(new SleepFunction(), 0, 0),

            array(new UsleepFunction(), 0, 0),
            array(new UsleepFunction(), 1000, 0.001),
            array(new UsleepFunction(), 1000000, 1),
        );
    }
}
