<?php

namespace Josh\Components\TvSchedule\Channels;

use Josh\Components\TvSchedule\Channel;
use Symfony\Component\DomCrawler\Crawler;
use Josh\Components\TvSchedule\Programmes\ManotoProgramm;

class Manoto extends Channel
{
    protected $name = 'manototv';

    protected $logo = 'manototv.png';

    protected $pageUri = 'https://www.manototv.com/dayschedule?day={date}';

    public function handle()
    {
        return $this->crawler->filter('body > div')->each(function (Crawler $node) {

            return new ManotoProgramm($node);
        });
    }
}