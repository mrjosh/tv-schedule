<?php

namespace Josh\Components\TvSchedule;

use DateTime;
use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\DependencyInjection\ServiceContainer;
use JonnyW\PhantomJs\Engine;
use Symfony\Component\DomCrawler\Crawler;

abstract class Channel
{
    protected $name;

    protected static $client;

    protected $pageUri;

    protected $crawler;

    protected $logo;

    protected $schedule;

    public function __construct()
    {
        $this->setLogo($this->logo);
        $this->setPageUri($this->pageUri);
        $this->crawler = new Crawler($this->getContent());
        $this->schedule = $this->handle();
    }

    abstract public function handle();

    public static function setPhantomJsClient($path)
    {
        $serviceContainer = ServiceContainer::getInstance();

        $engine = new Engine();

        $engine->setPath($path);

        $serviceContainer->set('engine', $engine);

        self::$client = new Client(
            $serviceContainer->get('engine'),
            $serviceContainer->get('procedure_loader'),
            $serviceContainer->get('procedure_compiler'),
            $serviceContainer->get('message_factory')
        );
    }

    public function getContent()
    {
        $request = self::$client->getMessageFactory()->createRequest($this->pageUri, 'GET');

        $response = self::$client->getMessageFactory()->createResponse();

        self::$client->send($request, $response);

        return $response->getContent();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = __DIR__ . '/../channels/' . $logo;
    }

    /**
     * @param mixed $pageUri
     * @param null $timeFormat
     */
    public function setPageUri($pageUri,$timeFormat = null)
    {
        $datetime = new DateTime;

        $date = $datetime->format( ( is_null($timeFormat) ? 'Y-m-d' : $timeFormat ) );

        $pageUri = str_replace('{date}',$date,$pageUri);

        $this->pageUri = $pageUri;
    }

    /**
     * @return mixed
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param mixed $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }
}