<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT IFNULL ((MAX(numero)),0) FROM pedidos";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $linha = mysqli_fetch_array($query);
    $numPedido = $linha[0] + 1;

    if($dados['numPedido']==''){
        $sql = "INSERT INTO pedidos(numero, cliente, tp_venda, dt_emissao, dt_entrega, usuario_emissao, usuario_alteracao, status) VALUES($numPedido, $dados[codCli], $dados[tpVenda], '$dados[emissao]', '$dados[entrega]', $_SESSION[id], $_SESSION[id], 1)";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    
        if($query){
            $sql = "SELECT MAX(numero) FROM pedidos";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $linha = mysqli_fetch_array($query);
            $numPedido = $linha[0];
            echo "Salvo com sucesso./".$numPedido;
        }else{
            echo "Erro ao salvar pedido de venda. ".mysqli_error($link);
        }
    }else{
        $sql = "UPDATE pedidos SET dt_entrega = '$dados[entrega]' WHERE numero = $dados[numPedido]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    
        if($query){
            echo "Salvo com sucesso./".$dados['numPedido'];
        }else{
            echo "Erro ao salvar pedido de venda. ".mysqli_error($link);
        }
    }
