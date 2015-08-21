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

    }


 ?>
