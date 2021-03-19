<?php
    header('Content-Type: application/json');
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM pais";
    $sql = mysqli_query($link, $sql);
    
    while( $result = mysqli_fetch_array($sql) ){
        $pais[] = array(
            "id" => $result['id'],
            "nome" => $result['nome']
        );
    }
    $paisJSON = json_encode($pais);
    echo $paisJSON;
?>