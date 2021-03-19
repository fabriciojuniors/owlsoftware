<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "INSERT INTO ajuste(origem_estoque, data, observacao) VALUES(1, '$dados[data]', '$dados[obs]')";
    $query = mysqli_query($link, $sql);

    if($query){
        $sql = "SELECT MAX(ID) FROM ajuste";
        $query = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($query);
        $ajuste = $result[0];
        echo $ajuste;
    }else{
        echo "Erro ao salvar Ajuste de Estoque. " . mysqli_error($link);
    }
?>