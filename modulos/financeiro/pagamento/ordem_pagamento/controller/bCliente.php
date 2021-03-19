<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM clientes WHERE id = $dados[cod] AND inativo = 0 AND fornecedor =1";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        while($row = mysqli_fetch_array($query)){
            @$cliente[] = $row;
        }
        echo json_encode(@$cliente);
    }
?>