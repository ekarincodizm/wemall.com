<?php

class TimeLogger
{
    protected static $snapshots = array();
    protected static $start = array();

    public static function snap($note = "", $branch = "default")
    {
        if (! isset($_COOKIE['timelogger']) && !Input::has('timelogger'))
        {
            return false;
        }

        if (empty(self::$start[$branch]))
        {
            self::$start[$branch] = self::getCurrentTime();
        }

        $time = self::getCurrentTime();
        $diff = $time - self::$start[$branch];

        // Laravel call everything under closure function
        // so debug_backtrace don't return file and line number
        // useless to keep it
        $lastCall = array();

        $data = array(
            'note' => $note,
            'branch' => $branch,
            'timeLap' => self::getTimelap($diff),
            'microtime' => $time,
        ) + $lastCall;

        self::addSnapShot($branch, $data);
    }

    protected static function addSnapShot($branch, Array $data)
    {
        if (! isset(self::$snapshots[$branch]))
        {
            self::$snapshots[$branch] = array();
        }

        $last = last(self::$snapshots[$branch]) ?: array();

        // add diff before
        $lastTime = empty($last['microtime']) ? $data['microtime'] : $last['microtime'];
        $used = $data['microtime'] - $lastTime;
        $timeUsed = array('timeDiffBefore' => self::getTimelap($used));

        $data = $data + $timeUsed;

        self::$snapshots[$branch][] = $data;

        Log::debug("TimeLogger", $data);
    }

    protected static function getCurrentTime()
    {
        return microtime(true);
    }

    protected static function getTimelap($microtime)
    {
        $sec = intval($microtime);
        $micro = $microtime - $sec;

        // Format the result as you want it
        // $final will contain something like "00:00:02.452"
        return (string) date('H:i:s',  mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
    }
}