<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT banco.nome, conta_bancaria.id, conta_bancaria.agencia, conta_bancaria.conta FROM conta_bancaria INNER JOIN banco WHERE banco.id = conta_bancaria.banco AND conta_bancaria.inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        while($row = mysqli_fetch_array($query)){
            @$conta[] = $row;
        }
        echo json_encode(@$conta);
    }
?>