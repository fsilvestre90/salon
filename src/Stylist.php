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
            try {
                $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylistName()}');");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

            $result_id = $GLOBALS['DB']->lastInsertId();
            $this->setId($result_id);
         }

        static function getAll() {
            try {
                $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

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
            try {
                $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = ('{$this->getId()}');");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

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

        function update() {
            try {
                $GLOBALS['DB']->exec("UPDATE stylists SET stylist_name = ('{$this->getStylistName()}') WHERE id = ('{$this->getId()}');");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        static function deleteAll() {
            try {
                $GLOBALS['DB']->exec("DELETE FROM stylists;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        function deleteOne() {
            try {
                $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = ('{$this->getId()}');");
                $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = ('{$this->getId()}');");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }
    }

 ?>
