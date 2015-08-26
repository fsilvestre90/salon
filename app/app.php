<?php
    // DEPENDENCIES
        require_once __DIR__."/../vendor/autoload.php"; // frameworks
        require_once __DIR__."/../src/Stylist.php";
        require_once __DIR__."/../src/Client.php";

        use Symfony\Component\HttpFoundation\Request;
        Request::enableHttpMethodParameterOverride();

    // INITIALIZE Database SESSION
        try{
            $server = 'mysql:host=localhost;dbname=hair_salon';
            $username = 'root';
            $password = 'root';
            $DB = new PDO($server, $username, $password);
            $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception
        } catch (PDOException $e) {
            echo "There was an error: " . $e->getMessage();
        }


    // INITIALIZE APPLICATION
        $app = new Silex\Application();
        $app['debug'] = true;
        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__."/../views"
        ));

    // ROUTES FOR STYLISTS
        $app->get('/', function() use ($app) {
            $stylists = Stylist::getAll();
            return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
        });

        $app->post('/add_stylist', function() use ($app) {
            $new_stylist = new Stylist($_POST['stylist']);
            $new_stylist->save();
            $stylists = Stylist::getAll();
            return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
        });

        $app->get('/update_stylist/{id}', function($id) use ($app) {
            $stylist = Stylist::find($id);
            return $app['twig']->render('edit_stylist.html.twig', array('stylist' => $stylist));
        });

        $app->patch('/update_stylist/{id}', function($id) use ($app) {
            $stylist = Stylist::find($id);
            $stylist->setStylistName($_POST['stylist']);
            $stylist->update();
            return $app['twig']->render('edit_stylist.html.twig', array('stylist' => $stylist));
        });

        $app->delete('/remove_stylist/{id}', function($id) use ($app) {
            $stylist = Stylist::find($id);
            $stylist->deleteOne();
            $stylists = Stylist::getAll();
            return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
        });

    //ROUTES FOR CLIENTS

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

        $app->patch('/update_client/{id}', function($id) use ($app) {
            $client = Client::find($id);
            $client->setClientName($_POST['client']);
            $client->update();
            return $app['twig']->render('edit_client.html.twig', array('client' => $client));
        });

        $app->delete('/remove_client/{id}', function($id) use ($app) {
            $client = Client::find($id);
            $client->deleteOne();
            $stylist = Stylist::find($client->getStylistId());
            $clients = $stylist->getClients();
            return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $clients));
        });

    return $app;

?>
