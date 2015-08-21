<?php

    // DEPENDENCIES
        require_once __DIR__."/../vendor/autoload.php"; // frameworks
        require_once __DIR__."/../src/Sylist.php";
        require_once __DIR__."/../src/Client.php";

    // INITIALIZE Database SESSION
        $server = 'mysql:host=localhost:8889;dbname=hair_salon';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);


    // INITIALIZE APPLICATION
        $app = new Silex\Application();
        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__."/../views"
        ));
    // ROUTES

        // display index webpage
        $app->get('/', function() use ($app) {

            return $app['twig']->render('index.html.twig');
        });


    return $app;

?>
