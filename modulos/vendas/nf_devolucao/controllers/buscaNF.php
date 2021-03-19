<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM nota_fiscal WHERE numero = $dados[nf] AND status NOT IN(1,3)";
    $query = mysqli_query($link, $sql);

    if(mysqli_num_rows($query) >0){
        $linha = mysqli_fetch_array($query);
        $nota = json_encode($linha);
        echo $nota;
    }else{
        echo "0";
    }