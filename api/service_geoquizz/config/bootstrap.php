<?php

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as DB;
use Slim\Factory\AppFactory;

session_start();

$builder = new ContainerBuilder();

$builder->addDefinitions(
    include('dependencies/services_dependencies.php'),
    include('dependencies/action_dependencies.php')
);

$c = $builder->build();

$app = AppFactory::createFromContainer($c);
$container = $app->getContainer();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('');

$db = new DB();
$db->addConnection(parse_ini_file('geoquizz.db.ini'), 'geoquizz');
$db->setAsGlobal();
$db->bootEloquent();

return $app;
