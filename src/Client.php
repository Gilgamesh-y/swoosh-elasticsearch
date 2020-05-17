<?php

namespace Src\Elasticsearch;

use Elasticsearch\ClientBuilder;

class Client
{
    /**
     * Elasticsearch client
     *
     * @var Elasticsearch\ClientBuilder
     */
    public $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }
}