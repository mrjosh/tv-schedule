<?php

namespace Josh\Components\TvSchedule\Programmes;

use Carbon\Carbon;
use Josh\Components\TvSchedule\Programm;

class AbcProgramm extends Programm
{
    public function getName()
    {
        $node = $this->node->filter('span > div.m-schedule-program-details.column.small-9.medium-6.large-7.xlarge-7');

        try {

            return $node->filter('div.m-schedule-program-name > a')->text();
        } catch (\Exception $exception){

            return $node->filter('div.m-schedule-program-name')->text();
        }
    }

    public function getLink()
    {
        try {

            return 'http://abc.go.com' . $this->node->filter('span > div.m-schedule-program-thumb.column.show-for-medium-up.medium-3.large-3.xlarge-3 > a')
                    ->attr('href');
        } catch (\Exception $exception){

            return null;
        }
    }

    public function getCover()
    {
        try {

            $image = $this->node->filter('span > div.m-schedule-program-thumb.column.show-for-medium-up.medium-3.large-3.xlarge-3 > a > picture > source')
                ->attr('srcset');
        } catch (\Exception $exception){

            $image = $this->node->filter('span > div.m-schedule-program-thumb.column.show-for-medium-up.medium-3.large-3.xlarge-3 > picture > source')
                ->attr('srcset');
        }

        return str_replace(' 1x','',$image);
    }

    public function getTime()
    {
        $time = $this->node->filter('span > div.m-schedule-program-time.column.small-3.medium-3.large-2.xlarge-2')
            ->text();

        $time = trim(preg_replace('/\s\s+/','',$time));

        $time = str_replace(':','',$time);

        $pmam = ( preg_match('/am/',$time) ? 'AM' : 'PM' );

        $time = str_replace('pm','',$time);

        $time = str_replace('am','',$time);

        $time = str_replace('On Now','',$time);

        $time = ( strlen($time) !== 4 ? '0' . $time : $time );

        $time = date("Hi", strtotime($time[0] . $time[1] . ':' . $time[2] . $time[3] . $pmam));

        return Carbon::createFromTime($time[0] . $time[1] , $time[2] . $time[3] , 0,'Asia/Tehran');
    }
}