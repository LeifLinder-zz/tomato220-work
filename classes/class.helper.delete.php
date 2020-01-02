<?PHP
class delete extends conn{

    function delete_single_instance_of_anything($dbase_table, $item_id){
        /*
            $stmt = $pdo->prepare("UPDATE myTable SET name = :name WHERE id = :id");
            $stmt->execute([':name' => 'David', ':id' => $_SESSION['id']]);
            $stmt = null;
        */
        try{
        //  $sth = $this->conn->prepare("DELETE FROM `keywords` WHERE `keywords`.`id` = 92");
            $stmt = $this->conn->prepare("DELETE FROM `tomato220`.:DBASETABLE  WHERE :DBASETABLE .`id` = :ITEMID LIMIT 1");
            $stmt->bindValue(':DBASETABLE', $dbase_table);
            $stmt->bindValue(':ITEMID', $item_id);
            $stmt->execute();
            $deleted_rows = $stmt->rowCount();
            $stmt = NULL;
            return $deleted_rows;
        }
        catch (Exception $e) {
            error_log($e->getMessage());
            exit('Something weird happened'); //something a user can understand
        }
    }

}
?>