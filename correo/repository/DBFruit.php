<?php

require_once "DB.php";

class DBFruit {

    public static function findAll()
    {
        try {
            $db = DB::getConnection();
    
            $arrGroup = [];
            $sql = "SELECT * FROM fruitdb.fruit;";
            $result = $db->query($sql);
    
            // Process
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                $arrGroup[] = ["id" => $row["id"], "name" => $row["name"]];
            }
    
            return $arrGroup;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving data from the group table " . $e->getMessage(), 500);
        }
    }    

}
?>