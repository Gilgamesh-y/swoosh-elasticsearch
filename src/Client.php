<?php

namespace Src\Elasticsearch;

use Elasticsearch\ClientBuilder;
use Elasticsearch\ConnectionPool\SniffingConnectionPool;
use Src\App;

class Client
{
    /**
     * Elasticsearch client
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    public function __construct(array $config)
    {
        $this->client = ClientBuilder::create()
            ->setHosts($config['hosts'] ?? ['http://127.0.0.1:9200'])
            ->setConnectionPool($config['connection_pool'] ?? SniffingConnectionPool::class)
            ->build();
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Associate document
     * 
     * @param mixed $index
     * @param mixed $type
     * @param array $document
     * @param mixed $id
     *
     * @return array
     */
    public function index($index, $type, $doc, $id = null)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'body' => $doc
        ];
        if (is_null($id)) {
            $params['id'] = App::get('snowflake')->get_id();
        }

        return $this->client->index($params);
    }

    /**
     * Bulk associate document
     * 
     * @param array $arr [
            [
                'index' => 'test_index_2',
                'type' => 'test',
                'doc' => [
                    'name' => 'wrath1'
                ]
            ]
        ]
     *
     * @return array
     */
    public function bulk(array $arr)
    {
        $params = [];
        foreach ($arr as $val) {
            if (!isset($val['index']) || !isset($val['type']) || !isset($val['doc'])) {
                throw new \Exception('参数错误', -1);
            }
            $params['body'][] = [
                'index' => [
                    '_index' => $val['index'],
                    '_type' => $val['type'],
                    '_id' => App::get('snowflake')->get_id()
                ]
            ];
            $params['body'][] = $val['doc'];
        }

        return $this->client->bulk($params);
    }

    /**
     * Get document
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

    /**
     * Update document
     *
     * @param mixed $index
     * @param mixed $type
     * @param mixed $id
     * @param array $doc ['field_name' => 'value']
     * @return array
     */
    public function update($index, $type, $id, $doc)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => [
                'doc' => $doc
            ]
        ];
        
        return $this->client->update($params);
    }

    /**
     * Update document by script
     *
     * @param mixed $index
     * @param mixed $type
     * @param mixed $id
     * @param array $script ['script' => 'ctx._source.field_name += 1']
     * @return array
     */
    public function update_by_script($index, $type, $id, $script)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $script
        ];
        
        return $this->client->update($params);
    }

    /**
     * Delete document
     * 
     * @param mixed $index
     * @param mixed $type
     * @param mixed $id
     * @return array
     */
    public function delete($index, $type, $id)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id
        ];
        
        return $this->client->delete($params);
    }

    /**
     * Match document
     * 
     * @param mixed $index
     * @param mixed $type
     * @param array
     * @return array
     */
    public function search($index, $type, $query)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'body' => $query
        ];
        
        return $this->client->search($params);
    }
}