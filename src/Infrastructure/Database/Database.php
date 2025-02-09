<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
$dotenv->safeLoad();

//Normally paths and credentials should be written in .env but I did not configured it yet
$_ENV['DB_DATABASE'] = 'C:\Users\umut.uygun\Desktop\ChatApp\database\database.sqlite';
$_SERVER['DB_DATABASE'] = 'C:\Users\umut.uygun\Desktop\ChatApp\database\database.sqlite';
putenv("DB_DATABASE=C:\Users\umut.uygun\Desktop\ChatApp\database\database.sqlite");

$envPath = realpath(dirname(__DIR__, 3) . '/.env');
if (!$envPath) {
    die("check .env file path" . dirname(__DIR__, 3));
}
echo ".env path" . $envPath . PHP_EOL;

$dbPath = getenv('DB_DATABASE');
if (!$dbPath || !file_exists($dbPath)) {
    die(".env path could not be found" . $dbPath);
}
if (!is_writable($dbPath)) {
    die("Please check access : " . $dbPath);
}
echo "Database connection successful. File : " . $dbPath . PHP_EOL;

$capsule = new Capsule;

try {
    $capsule->addConnection([
        'driver'    => 'sqlite',
        'database'  => $dbPath,
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    Model::setConnectionResolver($capsule->getDatabaseManager());

    echo "Eloquent successful" . PHP_EOL;

} catch (Exception $e) {
    die('Error: Database connection error' . $e->getMessage());
}

$GLOBALS['capsule'] = $capsule;
return $capsule;
