<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $usuario = $_SESSION['id'];
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['nota'] == ''){
        $sql = "SELECT IFNULL((MAX(numero)),0)+1 FROM nota_fiscal";
        $query = mysqli_query($link, $sql);
        $linha=  mysqli_fetch_array($query);
        $numero = ($linha[0] == '')? 1 : $linha[0];
        
        $sqlPedido = "SELECT * FROM pedidos WHERE numero = $dados[numPedido]";
        $queryPedido = mysqli_query($link, $sqlPedido);
        $pedido = mysqli_fetch_array($queryPedido);

        $sql = "INSERT INTO nota_fiscal(numero, pedido, emissao, entrega, usuario, status, condicao_pagamento, forma_pagamento, tp_venda) VALUES($numero, (SELECT id FROM pedidos WHERE numero = $dados[numPedido]), '$dados[emissao]', '$dados[entrega]', $usuario, 1, $pedido[condicao_pagamento], $pedido[forma_pagamento], $pedido[tp_venda])";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    
        if($query){
            echo "Salvo com sucesso./".$numero;
        }else{
            echo "Erro ao salvar nota fiscal. \n" . mysqli_error($link);
        }
    }else{
        $sql = "UPDATE nota_fiscal SET entrega = '$dados[entrega]' WHERE numero = $dados[nota]";
        $query = mysqli_query($link, $sql);
        if($query){
            echo "Salvo com sucesso./".$dados['nota'];
        }else{
            echo "Erro ao salvar nota fiscal.\n" . mysqli_error($link);
        }
    }

