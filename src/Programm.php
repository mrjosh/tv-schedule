<?php

namespace Josh\Components\TvSchedule;

use Symfony\Component\DomCrawler\Crawler;

abstract class Programm
{
    protected $node;

    protected $name = null;

    protected $time = [];

    protected $link = null;

    protected $cover = null;

    public function __construct(Crawler $node)
    {
        $this->node = $node;
        $this->setName($this->getName());
        $this->setLink($this->getLink());
        $this->setCover($this->getCover());
        $this->setTime($this->getTime());
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = trim(preg_replace('/\s\s+/','',$name));
    }

    /**
     * @param array $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @param null $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @param null $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    abstract public function getCover();

    abstract public function getLink();

    abstract public function getTime();

    abstract public function getName();
}