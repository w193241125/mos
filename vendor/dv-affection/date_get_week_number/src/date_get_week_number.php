<?php

if ( ! function_exists('date_get_week_number')) {

    /**
     * Return given datetime week number of year (week starts on Sunday). Example: "01" or "42"
     *
     * NOTE: ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)
     * (http://php.net/manual/en/function.date.php)
     *
     * @param \DateTime $datetime
     * @return string
     */
    function date_get_week_number(\DateTime $datetime)
    {
        $week = (int) $datetime->format('W');
        // if current day of the week is Sunday increment week
        if (0 == $datetime->format('w')) {
            $week ++;
        }

        return str_pad($week, 2, 0, STR_PAD_LEFT);
    }

}