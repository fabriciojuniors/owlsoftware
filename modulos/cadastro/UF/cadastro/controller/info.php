<?php
    header('Content-Type: application/json');
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM pais";
    $sql = mysqli_query($link, $sql);
    
    while( $result = mysqli_fetch_array($sql) ){
        $paises[] = array(
            "id" => $result['id'],
            "nome" => $result['nome']
        );
    }
    $paisesJSON = json_encode($paises);
    echo $paisesJSON;
?>