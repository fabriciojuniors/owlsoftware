<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT valor, valor_adicional FROM parametros_financeiros WHERE id = 1";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $row = mysqli_fetch_array($query);
    if($row[1] == 0){
        cancelar($link, true, $dados);
    }else{
        $sql = "SELECT * FROM parametros_financeiros WHERE id = 1 AND valor_adicional = $dados[senha]";
        $query = mysqli_query($link, $sql) or die (mysqli_error($link));
        if(mysqli_num_rows($query)>0){
            cancelar($link, true, $dados);
        }else{
            cancelar($link, false, $dados);
        }
    }
    function cancelar($link, $liberado, $dados){
        if($liberado){
            if($dados['opcao'] == 1){
                $sql = "SELECT valor, valor_saldo, status FROM parcela_op WHERE ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]) AND numero = $dados[seqnop]";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                if(mysqli_num_rows($query)>0){
                    $row = mysqli_fetch_array($query);
                    if($row[2] == 4){
                        echo "Parcela selecionada já se encontrada cancelada";
                    }
                    else if($row[0] != $row[1]){
                        echo "Não foi possível realizar o cancelamento da parcela. \nMotivo: Parcela com movimentação financeira. \nSugestão de correção: Efetue a exclusão da movimentação e tente novamente. ";
                    } else{
                        $sql = "UPDATE parcela_op SET status = 4, valor_saldo = 0 WHERE ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]) AND numero = $dados[seqnop]";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        if(mysqli_affected_rows($link)>0){
                            $sql = "INSERT INTO comentario_op(comentario, usuario, ordem_pagamento) VALUES('Realizado cancelamento da parcela $dados[seqnop]. (Comentário automático)', '$dados[usuario]', (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]))";
                            //echo $sql;
                            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                            echo "Cancelamento realizado com sucesso.";
                            statusOR($link, $dados);
                        }else{
                            echo "Não foi possível cancelar a parcela. \n". mysqli_error($link);
                        }
                    }
                }else{
                    echo "Não foi possível obter valores da OR. \n" . mysqli_error($link);
                }
            }else{
                $sql = "SELECT valor, valor_saldo, status FROM parcela_op WHERE ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]) AND status<>4 AND status<>2 AND status<>3";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                if(mysqli_num_rows($query)>0){
                    $row = mysqli_fetch_array($query);
                    if($row[2] == 4){
                        echo "OP selecionada já se encontrada cancelada";
                    }
                    else if($row[0] != $row[1]){
                        echo "Não foi possível realizar o cancelamento da parcela. \nMotivo: Parcela com movimentação financeira. \nSugestão de correção: Efetue a exclusão da movimentação e tente novamente. ";
                    }else{
                        $sql = "UPDATE ordem_pagamento SET status = 4, valor_saldo = 0 WHERE id = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop])";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        $sql = "UPDATE parcela_op SET status = 4, valor_saldo = 0 WHERE ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]) AND status<>2 AND status<>3";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        if(mysqli_affected_rows($link) > 0){
                            $sql = "INSERT INTO comentario_op(comentario, usuario, ordem_pagamento) VALUES('Realizado cancelamento das parcelas sem movimento referente a ordem pagamento $dados[nop]. (Comentário automático)', '$dados[usuario]', (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]))";
                            //echo $sql;
                            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                            echo "Cancelamento realizado com sucesso. ";
                            statusOR($link, $dados);
                        }else{
                            echo "Não foi possível realizar o cancelamento. \n" . mysqli_error($link);
                        }
                    }
                }else{
                    echo "Não foi possível obter valores da OP. \nPossível motivo: OP selecionada já se encontra cancelada." . mysqli_error($link);
                }
            }
        }else{
            echo 1;
        }
        
    }   

    function statusOR($link, $dados){
        $sql = "SELECT status FROM parcela_op where ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop])";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        while($row = mysqli_fetch_array($query)){
            if($row[0] == 4){
                $sql = "UPDATE ordem_pagamento SET status = 4 WHERE numero = $dados[nop]";
            }else if($row[0] == 3 ){
                $sql = "UPDATE ordem_pagamento SET status = 3 WHERE numero = $dados[nop]";
            }else if($row[0] == 2){
                $sql = "UPDATE ordem_pagamento SET status = 2 WHERE numero = $dados[nop]";
            }else{
                $sql = "UPDATE ordem_pagamento SET status = 1 WHERE numero = $dados[nop]";
            }
        }
        $query = mysqli_query($link, $sql);
    }