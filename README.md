## 设置

```php
[
    'hosts' => [
        // This is effectively equal to: "https://username:password!#$?*abc@foo.com:9200/"
        [
            'host' => 'foo.com',
            'port' => '9200',
            'scheme' => 'https',
            'user' => 'username',
            'pass' => 'password!#$?*abc'
        ],

        // This is equal to "http://localhost:9200/"
        [
            'host' => 'localhost',    // Only host is required
        ]
    ],
    'connection_pool' => \Elasticsearch\ConnectionPool\SniffingConnectionPool::class
];
```

## 索引文档
```php
\ES::index('test_index_1', 'test', ['name' => 'wrath']);
```

## 批量索引文档
```php
\ES::bulk([
    [
        'index' => 'test_index_2',
        'type' => 'test',
        'source' => [
            'name' => 'wrath1'
        ]
    ]
]);
```

## 获取文档
```php
\ES::get('test_index_1', 'test', '196752254659723264');
```

## 更新文档
```php
\ES::update('test_index_1', 'test', '196752254659723264', [
    'name' => 'wrath1',
    'age' => '18'
]);

\ES::update_by_script('test_index_1', 'test', '196752254659723264', [
    'script' => 'ctx._source.age += 1'
]);
```

## 删除文档
```php
\ES::delete('test_index_1', 'test', '196752254659723264');
```

## 搜索文档
```php
// Match查询
\ES::search('test_index_1', 'test', [
    'query' => [
        'match' => [
            'name' => 'wrath1'
        ]
    ]
]);
// bool查询
\ES::search('test_index_1', 'test', [
    'query' => [
        'bool' => [
            'must' => [ // 所有语句都必须匹配， 与mysql and等价
                ['match' => ['name' => 'wrath1']],
                ['match' => ['age' => '18']]
            ],
            'must_not' => [ // 所有语句都不能匹配， 与mysql not等价
                ['match' => ['name' => 'wrath1']],
                ['match' => ['age' => '18']]
            ],
            'should' => [ // 至少有一个语句匹配，与mysql or等价
                ['match' => ['name' => 'wrath1']],
                ['match' => ['age' => '18']]
            ]
        ]
    ]
]);
```