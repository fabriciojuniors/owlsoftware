<?php
    function gerarPDF($nota){
        include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
        if(isset($nota)){
            $nota = $nota;
            $sql = "SELECT * FROM empresa";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $empresa = mysqli_fetch_array($query);
        
            $sql = "SELECT * from nota_fiscal WHERE numero = $nota";
            $query = mysqli_query($link, $sql);
            $notaFiscal = mysqli_fetch_array($query);
        
            $sql = "SELECT * FROM clientes WHERE id = (SELECT cliente FROM pedidos WHERE id = (SELECT pedido FROM nota_fiscal WHERE numero = $nota))";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $cliente = mysqli_fetch_array($query);
        
            $sql = "SELECT clientes.CEP, pais.nome as pais, uf.sigla as uf, cidade.nome as cidade, clientes.bairro, clientes.rua, clientes.numero, clientes.complemento
                    FROM clientes INNER JOIN pais INNER JOIN uf INNER JOIN cidade
                    WHERE clientes.pais = pais.id AND clientes.uf = uf.id AND clientes.cidade = cidade.id AND clientes.id = $cliente[id]";
            $query = mysqli_query($link, $sql);
            $endereco = mysqli_fetch_array($query);
        
            $sql = "SELECT DISTINCT produto.descricao, item_nf.quantidade_faturar, item_nf.valor_unitario, item_nf.valor_total, item_pedido.desconto
                    FROM item_nf INNER JOIN produto INNER JOIN item_pedido INNER JOIN nota_fiscal
                    WHERE item_nf.produto = produto.id AND item_pedido.produto = produto.id AND item_pedido.pedido = (SELECT pedido FROM nota_fiscal WHERE numero = $nota) AND item_nf.nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero = $nota)";
            $queryItens = mysqli_query($link, $sql);
        
            $sql = "SELECT * FROM parcela_nf WHERE nota = (SELECT id FROM nota_fiscal WHERE numero = $nota)";
            $queryFinanceiro = mysqli_query($link, $sql);
            $parcelas = mysqli_num_rows($queryFinanceiro);
            $html = '';
            $html .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';
            $html .= '<div id="empresa" style="margin: 2%">
            <div class="row" style="margin-top: 1%; margin-bottom: 1%">
                <div class="col" style="background-color: gray; color: white; height: 25px"> <p>Dados da empresa</p> </div>
            </div>
            <div class="row">
                <div class="col-md-auto">
                    <img src="/owlsoftware/modulos/adm/empresa/logo/'.$empresa['logo'].'" style="width: 150px; height: 150px" alt="N??o foi poss??vel carregar a logo">
                </div>
                <div class="col">
                    <p> 
                        <strong>Raz??o Social:</strong>'.  $empresa['razao'] .'<br>
                        <strong>Nome Fantasia:</strong>'. $empresa['fantasia'].' <br> 
                        <strong>CNPJ:</strong>'.$empresa['cnpj'].' <br>
                        <strong>Inscri????o Estadual:</strong> '.$empresa['ie'].'  
                    </p>
                </div>
                <div class="col-md">
                    <p>
                        <strong>Nota: </strong>'.$notaFiscal['numero'].' <br>
                        <strong>Emiss??o: </strong>'.date("d/m/Y", strtotime($notaFiscal['emissao'])).'<br>
                        <strong>Entrega: </strong>'.date("d/m/Y", strtotime($notaFiscal['entrega'])).'<br>
                    </p>
                </div>
            </div>
            <div class="row" style="margin-top: 1%">
                <div class="col" style="background-color: gray; color: white; height: 25px"> <p>Dados do cliente</p> </div>
            </div>
            <div class="row" style="margin-top: 1%">
                <div class="col">
                    <p>
                        <strong>Nome:</strong> '.$cliente['nome'].' <br>
                        <strong>Raz??o Social:</strong> '.$cliente['razao_social'].' <br>
                        <strong>CPF/CNPJ:</strong> '.$cliente['CPF_CNPJ'].' <br>
                        <strong>Telefone:</strong> '.$cliente['telefone'].' <br>
                        <strong>E-Mail:</strong> '.$cliente['email'].' <br>
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Pa??s:</strong> '.$endereco['pais'].' 
                        <strong>UF:</strong> '.$endereco['uf'].' <br>
                        <strong>Cidade:</strong> '.$endereco['cidade'].'<br>
                        <strong>CEP:</strong> '.$endereco['CEP'].' <br>
                        <strong>Bairro:</strong> '.$endereco['bairro'].' <br>
                        <strong>Rua:</strong> '.$endereco['rua'].' <br>
        
                    </p>
                </div>
            </div>
            <div class="row" style="margin-top: 1%">
                <div class="col" style="background-color: gray; color: white; height: 25px"> <p>Produtos</p> </div>
            </div>
            <div style="margin-top: 1%" class="row">
                <table style="margin-left: 1%; width: 100%">
                    <thead>
                        <th style="width: 45%">Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Unit??rio</th>
                        <th>Desconto Unit??rio</th>
                        <th>Valor Total</th>
                    </thead>
                    <tbody>';
                            $total = 0;
                            while($item = mysqli_fetch_array($queryItens)){
                                $total += floatval($item['valor_total']) ;
                                $html.='
                                    <tr>
                                        <td>'.$item['descricao'].'</td>
                                        <td>'.str_replace(".", ",",$item['quantidade_faturar']).'</td>
                                        <td>'."R$ ".str_replace(".", ",",$item['valor_unitario']).'</td>
                                        <td>'."% ".str_replace(".", ",",$item['desconto']).'</td>
                                        <td>'."R$ ".str_replace(".", ",",$item['valor_total']).'</td>
                                    </tr>
        
                            }
        
                        <tr>
                            <td colspan="4"></td>
                            <td> Total: R$'.str_replace(".", ",",$total).'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" style="margin-top: 1%">
                <div class="col" style="background-color: gray; color: white; height: 25px"> <p>Financeiro</p> </div>
            </div>
            <div class="row">';
                for ($i=0; $i < $parcelas; $i++) { 
                    $parcela = mysqli_fetch_array($queryFinanceiro);
                        $html .='                    
                            <div class="col">
                                <p>
                                    <strong>N??mero:</strong> '.$parcela['numero'].' <br>
                                    <strong>Vencimento:</strong> '.date("d/m/Y", strtotime($parcela['vencimento'])).' <br>
                                    <strong>Valor:</strong> '."R$". str_replace(".", ",",$parcela['valor']).' <br>
                                </p>
                            </div>';
          
                $html .='
            </div> 
        </div>';
                }} 
            
        }else{
            echo "N??o foi poss??vel abrir a nota fiscal.";
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/owlsoftware/vendor/autoload.php';
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html, 2);
        $nome = "nota".$notaFiscal['numero'].".pdf";
        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/owlsoftware/modulos/vendas/nf_pedido/espelhos/'.$nome, 'F');
    }
?>