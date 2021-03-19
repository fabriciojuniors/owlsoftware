<?php
        include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM tp_movto_estoque WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $tpmovto[] = $row;
        
    };
    $tpmovtoJson = json_encode($tpmovto);
    echo $tpmovtoJson;
?>