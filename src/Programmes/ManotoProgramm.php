<?php

namespace Josh\Components\TvSchedule\Programmes;

use Carbon\Carbon;
use Josh\Components\TvSchedule\Programm;

class ManotoProgramm extends Programm
{
    public function getName()
    {
        return $this->node->filter('div.InfoCol')->text();
    }

    public function getLink()
    {
        try {

            return $this->node->filter('div.InfoCol > a')->attr('href');
        } catch (\Exception $exception){

            return null;
        }
    }

    public function getCover()
    {
        return null;
    }

    public function getTime()
    {
        $time = $this->node->filter('div.TimeCol')->text();

        $time = trim(preg_replace('/\s\s+/','',$time));

        $time = str_replace('ویدیو','',$time);

        if(strlen($time) == 3){

            $time = Carbon::createFromTime($time[0],$time[1] . $time[2],0,'Asia/Tehran');
        } elseif(strlen($time) == 4) {

            $time = Carbon::createFromTime($time[0].$time[1],$time[2].$time[3],0,'Asia/Tehran');
        }

        return $time;
    }
}