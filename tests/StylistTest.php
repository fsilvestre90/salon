<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown() {
            Stylist::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $stylist_name = "Suzie";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            //Act
            $result = Stylist::getAll();
            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $stylist_name = "Suzie";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            $stylist_name2 = "Bob";
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();
            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_find()
        {
            //Arrange
            $stylist_name = "Suzie";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            //Act
            $result = Stylist::find($test_stylist->getId());
            //Assert
            $this->assertEquals($test_stylist, $result);
        }

        function test_update() {
            //Arrange
            $stylist_name = "Suzie";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            //Act
            $result = Stylist::find($test_stylist->getId());
            $result->setStylistName("Neil");
            $result->update();
            $result = $result->getStylistName();
            //Assert
            $this->assertEquals("Neil", $result);
        }
    }
?>
