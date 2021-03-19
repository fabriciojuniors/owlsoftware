<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$pagina = intval($data['pagina']);
$qnt_result_pg = intval($data['qnt_result_pg']);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;
if(!isset($data['pedido'])){
	$data['pedido'] = '';
}
if(!isset($data['cliente'])){
	$data['cliente'] = '';
}
if(!isset($data['tpVenda']) || $data['tpVenda'] == '#'){
	$data['tpVenda'] = '';
}
if(!isset($data['inicio']) || $data['inicio'] == ''){
	$data['inicio'] = '2000-01-01';
}
if(!isset($data['fim']) || $data['fim'] == ''){
	$data['fim'] = date("Y-m-d");
}
//consultar no banco de dados
$result_banco = "SELECT pedidos.numero, clientes.nome, pedidos.dt_emissao, pedidos.dt_entrega, status_pedido.descricao, pedidos.id, pedidos.status, pedidos.cliente, (SELECT SUM(item_pedido.preco_total) FROM item_pedido WHERE item_pedido.pedido = pedidos.id)
                 FROM pedidos INNER JOIN clientes
			                  INNER JOIN status_pedido
                 WHERE pedidos.cliente = clientes.id AND pedidos.status = status_pedido.id AND pedidos.numero LIKE '%$data[pedido]%' AND pedidos.cliente LIKE '%$data[cliente]%' AND pedidos.tp_venda LIKE '%$data[tpVenda]%' AND pedidos.dt_emissao BETWEEN '$data[inicio]' AND '$data[fim]'
				 ORDER BY pedidos.id DESC LIMIT $inicio, $qnt_result_pg";
$resultado_banco = mysqli_query($link, $result_banco) or die(mysqli_error($link));


//Verificar se encontrou resultado na tabela "bancos"
if(($resultado_banco) AND ($resultado_banco->num_rows != 0)){
	?>
	
	<table class="table table-hover table-sm">
		<thead>
			<tr>
				<th>Número</th>
				<th>Cliente</th>
                <th>Emissão</th>
                <th>Entrega</th>
                <th>Valor</th>
                <th>Status</th>
				
                <th>Editar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_array($resultado_banco)){
					?>

					<tr>
					<th><?php echo $row[0]; ?></th>
					<td><?php echo $row[7]. " - ".$row[1]; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row[2])) ; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row[3])) ; ?></td>
                    <td>R$<?php echo number_format((float)$row[8],2, ",",".")  ; ?></td> 
                    <td><?php echo $row[4]; ?></td>
					<?php $ativo = ($row[6] == 1 || $row[6] == 2) ? "all" : "none" ?>
					<td><a style="pointer-events: <?php echo $ativo ?>" onclick="editarPedido(<?php echo $row[0]; ?>)"><i class="fas fa-pen"></i></a></td>
					</tr>
					<?php
				}
				?>

		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(id) AS num_result from pedidos where pedidos.numero LIKE '%$data[pedido]%' AND pedidos.cliente LIKE '%$data[cliente]%' AND pedidos.tp_venda LIKE '%$data[tpVenda]%' AND pedidos.dt_emissao BETWEEN '$data[inicio]' AND '$data[fim]' ";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-end'>";
echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarPedido(1, $qnt_result_pg)'>&laquo;</a></li>";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarPedido($pag_ant, $qnt_result_pg)'>$pag_ant </a></li> ";
	}
}

echo "<li class='page-item active'><a href='#' class='page-link'> $pagina</a></li> ";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo "<li class='page-item'><a href='#' class='page-link' <a href='#' onclick='pesquisarPedido($pag_dep, $qnt_result_pg)'>$pag_dep</a></li> ";
	}
}

echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarPedido($quantidade_pg, $qnt_result_pg)'>&raquo;</a></li>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}

echo "</ul>";
