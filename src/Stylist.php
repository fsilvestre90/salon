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

    }

 ?>
