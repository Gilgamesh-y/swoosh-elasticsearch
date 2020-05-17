<?php

namespace Src\Elasticsearch\Provider;

use Src\Elasticsearch\Client;
use Src\Core\AbstractProvider;

class ElasticsearchProvider extends AbstractProvider
{
    public function register()
    {
        $this->app->set('elasticsearch', function () {
            return new Client($this->app);
        });
    }
}