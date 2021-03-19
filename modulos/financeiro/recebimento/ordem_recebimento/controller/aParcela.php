<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "UPDATE ordem_recebimento SET observacao = '$dados[obs]' WHERE numero = $dados[nor]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    $sql = "SELECT ID FROM ordem_recebimento WHERE numero = $dados[nor]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $linha = mysqli_fetch_array($query);
    $idOr = $linha[0];

    $sql = "UPDATE parcela_or SET vencimento = '$dados[vencimento]' , valor = $dados[valorParcela], valor_saldo = $dados[valorParcela] WHERE ordem_recebimento = $idOr AND numero = $dados[seqnor]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    $sql = "SELECT SUM(valor) FROM parcela_or WHERE ordem_recebimento = $idOr";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $linha = mysqli_fetch_array($query);
    $valor = $linha[0];

    $sql = "SELECT SUM(valor_saldo) FROM parcela_or WHERE ordem_recebimento = $idOr";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $linha = mysqli_fetch_array($query);
    $valorSaldo = $linha[0];
    

    $sql = "UPDATE ordem_recebimento SET valor_total = $valor, valor_saldo = $valorSaldo WHERE id=$idOr";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    echo $idOr;
?>