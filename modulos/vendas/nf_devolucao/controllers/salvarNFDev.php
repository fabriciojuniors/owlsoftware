<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM nota_fiscal WHERE numero = $dados[nfDev] AND status <> 3";
    $query = mysqli_query($link, $sql);

    if(mysqli_num_rows($query) >0){
        $nota = mysqli_fetch_array($query);
        $NFDevolvida = $nota['id'];
        $sql = "SELECT MAX(numero)+1 FROM nota_fiscal";
        $query = mysqli_query($link, $sql);
        $linha = mysqli_fetch_array($query);
        $numero = $linha[0];
        $sql = "INSERT INTO nota_fiscal(numero, pedido, emissao, usuario, tp_venda, status, nota_referenciada) VALUES($numero, $nota[pedido], '$dados[emissao]', $_SESSION[id], $dados[tpDev], 1, $NFDevolvida)";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if($query){
            echo "nota/".$numero;
        }else{
            echo "Erro ao gerar nota fiscal. \n" . mysqli_error($link);
        }
    }else{
        echo "0";
    }