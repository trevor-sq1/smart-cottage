<?php

require_once 'DBManager.php';
require_once 'PreparedStatements.php';

class DBInsert extends DBManager {
    
    public function __construct($servername, $username, $password, $dbname) {
        parent::__construct($servername, $username, $password, $dbname);
    }

    public function __destruct() {
        $this->dbconn = null;
    }
    
    public function insertNewUser($username, $firstName, $lastName, $email, $password) {
        global $insertNewUser;
        $statement = $this->prepareStatement($insertNewUser);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        return $statement->execute();
    }
    
    public function insertNewFriends($username, $friendName) {
        global $insertNewFriends;
        $statement = $this->prepareStatement($insertNewFriends);
        $statement->bindParam(':username1', $username);
        $statement->bindParam(':friendName1', $friendName);
        $statement->bindParam(':username2', $friendName);
        $statement->bindParam(':friendName2', $username);
        return $statement->execute();
    }
    
    public function insertNewOrder($username, $storeName) {
        global $insertNewOrder;
        $this->dbconn->open();
        $statement = $this->dbconn->getConnection()->prepare($insertNewOrder);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':storeName', $storeName);
        $statement->execute();
        $orderID = $this->dbconn->getConnection()->lastInsertId();
        $this->dbconn->close();
        return $orderID;
    }
    
    public function insertNewOrderItem($orderID, $storeName, 
            $itemName, $quantity, $price) {
        global $insertNewOrderItem;
        $statement = $this->prepareStatement($insertNewOrderItem);
        $statement->bindParam(':orderID', $orderID);
        $statement->bindParam(':storeName', $storeName);
        $statement->bindParam(':itemName', $itemName);
        $statement->bindParam(':quantity', $quantity);
        $statement->bindParam(':price', $price);
        return $statement->execute();
    }
   
    
}
