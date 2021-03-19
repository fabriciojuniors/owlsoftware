<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT valor_movimentacao, parcela_op FROM liquidacao_op WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) > 0){
        $resultado = mysqli_fetch_array($query);
        $valor = $resultado[0];
        $parcela = $resultado[1];
        
        $sql = "SELECT valor_movimentacao FROM liquidacao_op WHERE id= $dados[id]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $linha = mysqli_fetch_array($query);
        $valorMovimentacao = $linha[0];
        $sql = "DELETE FROM liquidacao_op WHERE id= $dados[id]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        if(mysqli_affected_rows($link) > 0){
            $sql = "SELECT valor, valor_saldo, numero FROM parcela_op WHERE id = $parcela";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            
            if(mysqli_num_rows($query) > 0){
                $resultado = mysqli_fetch_array($query);
                $valorParcela = $resultado[0];
                $saldoParcela = $resultado[1];
                $numParcela = $resultado[2];
                $saldoAjustado = $saldoParcela + $valor;
                ($saldoAjustado == $valorParcela) ? $status = 1 : $status = 3;

                $sql = "UPDATE parcela_op SET valor_saldo = $saldoAjustado, status = $status WHERE id = $parcela";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                if(mysqli_affected_rows($link) > 0){
                    $sql = "SELECT ordem_pagamento FROM parcela_op WHERE id = $parcela";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                    if(mysqli_num_rows($query) > 0){
                        $resultado = mysqli_fetch_array($query);
                        $or = $resultado[0];
                        $sql = "SELECT SUM(valor_movimentacao) 
                                FROM liquidacao_op INNER JOIN ordem_pagamento 
                                                   INNER JOIN parcela_op
                                WHERE liquidacao_op.parcela_op = parcela_op.id AND parcela_op.ordem_pagamento = ordem_pagamento.id AND ordem_pagamento.id = $or";
                        $query = mysqli_query($link, $sql);

                        if(mysqli_num_rows($query) > 0){
                            $resultado = mysqli_fetch_array($query);
                            $valorMovimentado = $resultado[0];

                            $sql = "SELECT valor_total FROM ordem_pagamento WHERE id = $or";
                            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                            if(mysqli_num_rows($query)> 0){
                                $resultado = mysqli_fetch_array($query);
                                $valorOR = $resultado[0]; 
                                $saldoAtualOR = $valorOR - $valorMovimentado;
                                ($saldoAtualOR == $valorOR)? $status = 1 : $status = 3;

                                $sql = "UPDATE ordem_pagamento SET valor_saldo = $saldoAtualOR, status = $status WHERE id = $or";
                                $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                                if(mysqli_affected_rows($link) > 0){
                                    $sql = "INSERT INTO comentario_op(comentario, usuario, ordem_pagamento) VALUES('Movimentação no valor de R$$valorMovimentacao referente a parcela $numParcela foi excluída. (Comentário automático)', '$_SESSION[usuario]', $or)";
                                    //echo $sql;
                                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    echo "Movimentação excluída com sucesso.";
                                }else{
                                    echo "Erro ao atualizar saldo da OP. ". mysqli_error($link);
                                }
                            }else{
                                echo "Não foi possível obter o valor da OP. " . mysqli_error($link);
                            }
                        }else{
                            echo "Não foi possível obter o valor de movimentação da OP." . mysqli_error($link);
                        }
                    }else{
                        echo "Não foi possível selecionar a ordem de pagamento. " . mysqli_error($link);
                    }
                }else{
                    echo "Não foi possível atualizar o saldo da parcela. " . mysqli_error($link);
                }
            }else{
                echo "Não foi possível obter o saldo da parcela. " . mysqli_error($link);
            }
        }else{
            echo "Não foi possível excluir movimentação. " . mysqli_error($link);
        }
    }else{
        echo "Não foi possível obter o valor da movimentação.". mysqli_error($link);
    }
?>    