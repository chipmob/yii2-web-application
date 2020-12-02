<?php

namespace common\components\helpers;

class Date
{
    public static function setTomorrowStart(?int &$timestamp)
    {
        if ($timestamp !== null) {
            $timestamp = strtotime('tomorrow', $timestamp);
        }
    }
}
