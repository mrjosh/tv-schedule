<?php

require __DIR__ . '/vendor/autoload.php';

use Josh\Components\TvSchedule\Channel;
use Josh\Components\TvSchedule\Channels\Abc;
use Josh\Components\TvSchedule\Channels\Nbc;
use Josh\Components\TvSchedule\Channels\Manoto;

Channel::setPhantomJsClient('bin/phantomjs');

$xml = new SimpleXMLElement('<tv/>');

$channels = [
    'manoto' => new Manoto,
    'abc' => new Abc,
    'nbc' => new Nbc,
];


/** @var \Josh\Components\TvSchedule\Channel $channel */
foreach ($channels as $channel){

    $track = $xml->addChild('channel');
    $track->addAttribute('id',$channel->getName());
    $track->addChild('display-name', $channel->getName());
    $track->addChild('icon')->addAttribute('src',$channel->getLogo());

    $datetime = new DateTime();

    /** @var \Josh\Components\TvSchedule\Programm $schedule */
    foreach ($channel->getSchedule() as $schedule){

        $track = $xml->addChild('programme');

        $track->addAttribute('start',htmlspecialchars( $schedule->getTime() ));

        $track->addAttribute('stop',htmlspecialchars( $schedule->getTime() ));

        $track->addAttribute('channel',htmlspecialchars($channel->getName()));

        $track->addChild('title', htmlspecialchars($schedule->getName()))->addAttribute('lang','en');

        $track->addChild('desc', htmlspecialchars(''))->addAttribute('lang','en');

        $track->addChild('date', $datetime->format('Ymd'));
    }
}

header('Content-type: text/xml');
print($xml->asXML());