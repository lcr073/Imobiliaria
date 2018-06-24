<?php
// Valida no banco as informações recebidas
include "include/db/connect.php";



// Inserindo no DB
//$image = addslashes(file_get_contents($_FILES['images']['tmp_name']));

try {
    // Verifica no banco se ja tem algum usuario com aquele nome ou email escolhido
    //Prepara para a query
    $stmt = $dbh->prepare("SELECT * FROM contratos;");

    // Realmente realiza a execucao da query
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para cada elemento de result
    foreach ($result as $row) {

            // Vincula seu id nessa sessao criada
echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img_contrato'] ).'"/>';            

    }    
}catch (Exception $e) {
    echo 'Exceção capturada: ', $e->getMessage(), "\n";
}

?>