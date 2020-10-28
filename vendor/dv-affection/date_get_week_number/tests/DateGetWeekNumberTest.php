<?php

class DateGetWeekNumberTest extends \PHPUnit_Framework_TestCase
{

    public function testWeekIsStringAndPaddedWithZero()
    {
        $date = new \DateTime;
        $date->setDate(2013, 1, 1);

        $actual   = \date_get_week_number($date);
        $expected = '01';
        $this->assertSame($expected, $actual);
    }

    public function testGeneral()
    {
        $date = new \DateTime;
        $date->setDate(2013, 1, 6);

        $actual   = \date_get_week_number($date);
        $expected = 2;
        $this->assertEquals($expected, $actual);


        $date     = new \DateTime;
        $date->setDate(2013, 12, 29);
        $actual   = \date_get_week_number($date);
        $expected = 53;
        $this->assertEquals($expected, $actual);
    }

}