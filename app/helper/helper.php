<?php
/**
 * Created by liuguansheng.
 * Email: w193241125@163.com
 * Time: 2019/5/28 9:59
 */


if (!function_exists('get_week_start_end_date')) {
    //获取一周开始和结束的日期
    function get_week_start_end_date()
    {
        $time = time();
        $week = date('w',$time);//获取是周几
        if ($week ==="0") $week = '7';
        $fix = 7 - $week; //7
        $s = $week-1;
        if ($fix >= 0){
            $start = "- $s";
            $end = "+ $fix";
        }else{
            $start = "- $s";
            $end = "+ $fix";
        }

        $week_date['start_date'] = date('Y-m-d',strtotime("$start days"));
        $week_date['end_date']  = date('Y-m-d',strtotime("$end days"));
        return $week_date;
    }
}

if (!function_exists('get_next_week_start_end_date')) {
    //获取一周开始和结束的日期
    function get_next_week_start_end_date()
    {
        $time = time();
        $week = date('w',$time);//获取是周几
        if ($week ==="0") $week = '7';
        $fix = 14 - $week ; //7
        $s = $week +6;

        $start = "+ $s";
        $end = "+ $fix";

        $week_date['start_date'] = date('Y-m-d',strtotime("$start days"));
        $week_date['end_date']  = date('Y-m-d',strtotime("$end days"));
        return $week_date;
    }
}
