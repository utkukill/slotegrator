<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:'. __DIR__ . '/../data'."/sqlite.db",
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
