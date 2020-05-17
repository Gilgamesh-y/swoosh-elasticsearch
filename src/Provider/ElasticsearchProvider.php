<?php

namespace Src\Elasticsearch\Provider;

use Src\Core\AbstractProvider;

class DispatchServiceProvider extends AbstractProvider
{
    public function register()
    {
        $this->app->set('elasticsearch', function () {
            return new DispatcherServer($this->app);
        });
    }
}