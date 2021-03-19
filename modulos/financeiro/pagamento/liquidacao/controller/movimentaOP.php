<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    //Busca o saldo da parcela
    $sql = "SELECT valor_saldo FROM parcela_op WHERE id = $dados[parcelaID]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    if($query){
        $linha = mysqli_fetch_array($query);
        $saldo = $linha[0];
        if($saldo < $dados['valorMovimentacao']){
            echo "Não foi possível movimentar a OP " . $dados['orparcela'] . " devido o valor da movimentação superior ao valor do saldo. \n";
        }else{
            $sql = "SELECT liquidacao FROM tp_movto_financeiro WHERE id = $dados[tpmovto]";
            $query = mysqli_query($link, $sql);
            $linha = mysqli_fetch_array($query);
            $liquidacao = $linha[0];
            ($liquidacao == 1)? $sql = "INSERT INTO liquidacao_op(data, parcela_op, valor_movimentacao, conta_bancaria, tp_movto_financeiro) VALUES('$dados[dataMovimentacao]', $dados[parcelaID], $dados[valorMovimentacao], $dados[conta], $dados[tpmovto])" : $sql = "INSERT INTO liquidacao_op(data, parcela_op, valor_movimentacao, tp_movto_financeiro) VALUES('$dados[dataMovimentacao]', $dados[parcelaID], $dados[valorMovimentacao],  $dados[tpmovto])";

            //$sql = "INSERT INTO liquidacao_or(data, parcela_or, valor_movimentacao, conta_bancaria, tp_movto_financeiro) VALUES('$dados[dataMovimentacao]', $dados[parcelaID], $dados[valorMovimentacao], $dados[conta], $dados[tpmovto])";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            if(mysqli_affected_rows($link)>0){
                $saldoAtual = $saldo - $dados['valorMovimentacao'];
                $statusAtual = ($saldoAtual == 0) ? 2 : 3;
                $sql = "UPDATE parcela_op SET valor_saldo = $saldoAtual, status = $statusAtual  WHERE id = $dados[parcelaID]";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                $sql = "SELECT ordem_pagamento FROM parcela_op WHERE id = $dados[parcelaID]";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                $linha = mysqli_fetch_array($query);
                $or = $linha[0];

                $sql = "SELECT valor_saldo FROM ordem_pagamento WHERE id = $or";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                $linha = mysqli_fetch_array($query);
                $saldoOr = $linha[0];

                $saldoOrAtual = $saldoOr - $dados['valorMovimentacao'];
                $statusAtualOR = ($saldoOrAtual == 0) ? 2 : 3;

                $sql = "UPDATE ordem_pagamento SET valor_saldo = $saldoOrAtual, status = $statusAtualOR WHERE id = $or";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                //echo $sql . " parcela: ".$dados['opparcela'];
                    $sql = "select numero from parcela_op where id = $dados[parcelaID]";
                    $query = mysqli_query($link, $sql);
                    $linha = mysqli_fetch_array($query);
                    $numParcela = $linha[0];
                    if($liquidacao == 1){
                        $sql = "INSERT INTO comentario_op(comentario, usuario, ordem_pagamento) VALUES('Liquidação no valor de R$$dados[valorMovimentacao] referente a parcela $numParcela. (Comentário automático)', '$_SESSION[usuario]', $or)";    
                    }else{
                        $sql = "INSERT INTO comentario_op(comentario, usuario, ordem_pagamento) VALUES('Desconto no valor de R$$dados[valorMovimentacao] referente a parcela $numParcela. (Comentário automático)', '$_SESSION[usuario]', $or)";
                    }
                    
                    //echo $sql;
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                    echo "sucesso";
                

            }else{
                echo "Erro ao salvar movimentação OP ". $dados['opparcela']. "" . mysqli_error($link) . ". \n";
            }

        }

    }else{
        echo "Erro ao obter saldo da parcela. \n" + mysqli_error($link) . ". \n";
    }

