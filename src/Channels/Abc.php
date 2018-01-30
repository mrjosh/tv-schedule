<?php

namespace Josh\Components\TvSchedule\Channels;

use Josh\Components\TvSchedule\Channel;
use Josh\Components\TvSchedule\Programmes\AbcProgramm;
use Symfony\Component\DomCrawler\Crawler;

class Abc extends Channel
{
    protected $name = 'abc';

    protected $logo = 'abc.png';

    protected $pageUri = 'http://abc.go.com/schedule';

    public function handle()
    {
        return $this->crawler->filter('body > div > main > div > section.module.m-schedule-responsive.slider-loaded > div > div.columns.m-schedule-column-wrapper > section.m-schedule-programs-section > ul > li')->each(function (Crawler $node) {

            return new AbcProgramm($node);
        });
    }
}