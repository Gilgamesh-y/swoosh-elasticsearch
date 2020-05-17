<?php

namespace Src\Elasticsearch;

use Elasticsearch\ClientBuilder;

class Client
{
    /**
     * Elasticsearch client
     *
     * @var \Elasticsearch\Client
     */
    public $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * Add document to the index
     *
     * @param mixed $index
     * @param mixed $type
     * @param mixed $id
     * @param array $source
     * @return array
     */
    public function index($index, $type, $id, array $source)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $source
        ];
        
        return $this->client->index($params);
    }

    /**
     * Get the document
     *
     * @param mixed $index
     * @param mixed $type
     * @param mixed $id
     * @return array
     */
    public function get($index, $type, $id)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id
        ];

        return $this->client->get($params);
    }
}