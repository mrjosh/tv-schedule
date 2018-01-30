<?php

namespace Josh\Components\TvSchedule\Programmes;

use Carbon\Carbon;
use Josh\Components\TvSchedule\Programm;

class NbcProgramm extends Programm
{
    public function getName()
    {
        return trim(
            $this->node->filter('div.schedule-show__content > div.schedule-show__content__show-title')
                ->text()
        );
    }

    public function getLink()
    {
        return null;
    }

    public function getCover()
    {
        return null;
    }

    public function getTime()
    {
        $time = trim($this->node->filter('div.schedule-show__time > span')->text());

        $time = str_replace(':','',$time);

        $pmam = ( preg_match('/am/',$time) ? 'AM' : 'PM' );

        $time = str_replace('am','',$time);

        $time = str_replace('pm','',$time);

        $time = ( strlen($time) !== 4 ? '0' . $time : $time );

        $time = date("Hi", strtotime($time[0] . $time[1] . ':' . $time[2] . $time[3] . $pmam));

        return Carbon::createFromTime($time[0] . $time[1] , $time[2] . $time[3] , 0,'Asia/Tehran');
    }
}