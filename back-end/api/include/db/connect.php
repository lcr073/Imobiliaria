<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 16:52
 */

$user = "teste";
$pass = "12345678";

try {
    $dbh = new PDO('mysql:host=localhost;dbname=imob_db', $user, $pass);
	$dbh->setAttribute("PDO::ATTR_ERRMODE", PDO::ERRMODE_EXCEPTION);
    // Prepara para a query
    // $stmt = $dbh->prepare("SELECT ....BAUBAUBAU;");

    // $stmt -> execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);

 //   foreach($dbh->query('SELECT * from tbl_user') as $row) {
//        print_r($row);
//    }


  //  $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>