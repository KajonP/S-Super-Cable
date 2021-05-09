<?php
include ('config.ini.php');
function connect(){
    try {
        $dbh = new PDO(DSN, USER, PASS);
        $dbh->query("SET NAMES UTF8");
        return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

}
function select(String $sql,int $type = PDO::FETCH_ASSOC){
    $conn = connect();
    $result = $conn->prepare($sql);
    $result->execute();
    if($result->rowCount() > 0)
        return  $result->fetchAll($type);
    return null;
}
function update(String $sql){
    $conn = connect();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

?>