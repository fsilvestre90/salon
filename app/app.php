<?php

    // DEPENDENCIES
        require_once __DIR__."/../vendor/autoload.php"; // frameworks
        require_once __DIR__."/../src/Stylist.php";
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
            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
        });

        $app->post('/add_stylist', function() use ($app) {
            $new_stylist = new Stylist($_POST['stylist']);
            $new_stylist->save();

            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
        });

        $app->get('/clients/{id}', function($id) use ($app) {
            $stylist = Stylist::find($id);
            $clients = $stylist->getClients();

            return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $clients));
        });

        $app->post('/clients/{id}', function($id) use ($app) {
            $new_client = new Client($_POST['client'], $id);
            $new_client->save();
            $stylist = Stylist::find($id);
            $clients = $stylist->getClients();

            return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $clients));
        });

        $app->get('/update_client/{id}', function($id) use ($app) {
            $client = Client::find($id);
            return $app['twig']->render('edit_client.html.twig', array('client' => $client));
        });

        $app->post('/update_client/{id}', function($id) use ($app) {
            $client = Client::find($id);
            $client->setClientName($_POST['client']);
            $client->update();
            return $app['twig']->render('edit_client.html.twig', array('client' => $client));
        });

    return $app;

?>
