<?php

namespace Josh\Components\TvSchedule\Channels;

use Josh\Components\TvSchedule\Channel;
use Josh\Components\TvSchedule\Programmes\NbcProgramm;
use Symfony\Component\DomCrawler\Crawler;

class Nbc extends Channel
{
    protected $name = 'nbc';

    protected $logo = 'nbc.png';

    protected $pageUri = 'https://www.nbc.com/schedule';

    public function handle()
    {
        return $this->crawler->filter('#main > div > div.schedule > div.schedule__content > div > div')->each(function (Crawler $node) {

            return new NbcProgramm($node);
        });
    }
}