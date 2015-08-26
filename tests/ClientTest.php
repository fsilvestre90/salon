<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown() {
            Client::deleteAll();
        }

        function testGetId() {
            //Arrange
            $Client_name = "Suzie";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();

            //Act
            $result = $test_Client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetClientName() {
            //Arrange
            $Client_name = "Suzie";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();

            //Act
            $result = $test_Client->getClientName();

            //Assert
            $this->assertEquals("Suzie", $result);
        }

        function test_save()
        {
            //Arrange
            $Client_name = "Suzie";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();
            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals($test_Client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $Client_name = "Suzie";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();

            $Client_name2 = "Bob";
            $stylist_id = 2;
            $test_Client2 = new Client($Client_name2, $stylist_id);
            $test_Client2->save();

            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals([$test_Client, $test_Client2], $result);
        }

        function test_find()
        {
            //Arrange
            $Client_name = "Suzie";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();
            //Act
            $result = Client::find($test_Client->getId());
            //Assert
            $this->assertEquals($test_Client, $result);
        }

        function test_update() {
            //Arrange
            $Client_name = "Neil";
            $stylist_id = 1;
            $test_Client = new Client($Client_name, $stylist_id);
            $test_Client->save();
            //Act
            $result = Client::find($test_Client->getId());
            $result->setClientName("Jamie");
            $result->update();
            $result = $result->getClientName();
            //Assert
            $this->assertEquals("Jamie", $result);
        }

    }
?>
