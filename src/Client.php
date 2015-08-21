<?php

    class Client {
        private $id;
        private $client_name;
        private $stylist_id;

        function __construct($client_name, $stylist_id = NULL, $id = NULL) {
            $this->client_name = $client_name;
            $this->stylist_id = $stylist_id;
            $this->id = $id;
        }

        function getClientName() {
            return $this->client_name;
        }

        function getStylistId() {
            return $this->stylist_id;
        }

        function getId() {
            return $this->id;
        }

        function setClientName($newName) {
            $this->client_name = $newName;
        }

        function setStylistId($newStylistId) {
            $this->stylist_id = $newStylistId;
        }

        function setId($newId) {
            $this->id = $newId;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO clients (client_name, stylist_id) VALUES ('{$this->getClientName()}', {$this->getStylistId()});");
            $result_id = $GLOBALS['DB']->lastInsertId();
            $this->setId($result_id);
         }

        static function getAll() {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $client_name = $client['client_name'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($client_name, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function find($searchId) {
            $result_client = null;
            $clients = Client::getAll();
            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $searchId) {
                    $result_client = $client;
                }
            }
            return $result_client;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }
        function deleteOne() {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = ('{$this->getId()}');");
        }

        function update() {
             $GLOBALS['DB']->exec("UPDATE clients SET client_name = ('{$this->getClientName()}') WHERE id = ('{$this->getId()}');");
        }
    }


 ?>
