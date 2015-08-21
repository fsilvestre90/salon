<?php

    class Stylist {

        private $id;
        private $stylist_name;

        function __construct($stylist_name, $id = NULL) {
            $this->stylist_name = $stylist_name;
            $this->id = $id;
        }

        function getStylistName() {
            return $this->stylist_name;
        }
        function getId() {
            return $this->id;
        }
        function setStylistName($newStylistName) {
            $this->stylist_name = $newStylistName;
        }
        function setId($newId) {
            $this->id = $newId;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylistName()}');");
            $result_id = $GLOBALS['DB']->lastInsertId();
            $this->setId($result_id);
         }

        static function getAll() {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylists as $stylist) {
                $stylist_name = $stylist['stylist_name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($stylist_name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function find($searchId) {
            $result_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $stylist) {
                $stylist_id = $stylist->getId();
                if ($stylist_id == $searchId) {
                    $result_stylist = $stylist;
                }
            }
            return $result_stylist;

        }

        function getClients() {
            $clients = array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = ('{$this->getId()}');");
            foreach($returned_clients as $client) {
                $client_name = $client['client_name'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($client_name, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }
        function update() {
             $GLOBALS['DB']->exec("UPDATE stylists SET stylist_name = ('{$this->getStylistName()}') WHERE id = ('{$this->getId()}');");
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        function deleteOne() {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = ('{$this->getId()}');");
        }
    }

 ?>
