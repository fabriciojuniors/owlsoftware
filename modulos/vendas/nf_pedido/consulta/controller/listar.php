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
if(!isset($data['inicio']) || $data['inicio'] == ''){
	$data['inicio'] = '2000-01-01';
}
if(!isset($data['fim']) || $data['fim'] == ''){
	$data['fim'] = date("Y-m-d", strtotime("+1 day"));
}
if(!isset($data['nota'])){
    $data['nota'] = '';
}
if(!isset($data['pedido'])){
    $data['pedido'] = '';
}
if(!isset($data['order'])){
	$data['order'] = "nota_fiscal.numero";
}
if(!isset($data['descAsc'])){
	$data['descAsc'] = "DESC";
}
if($data['descAsc'] == "DESC"){
	$order = "ASC";
}else{
	$order = "DESC";
};

//consultar no banco de dados
$result_banco = "SELECT nota_fiscal.id, nota_fiscal.numero, pedidos.cliente, clientes.nome, nota_fiscal.emissao, nota_fiscal.status, status_nf.descricao, pedidos.numero, IFNULL((SELECT SUM(valor_total) FROM item_nf WHERE item_nf.nota_fiscal = nota_fiscal.id) ,0) as valor, clientes.email, IFNULL((nota_fiscal.nota_referenciada),0),tp_venda.descricao
FROM nota_fiscal INNER JOIN clientes INNER JOIN status_nf INNER JOIN pedidos INNER JOIN tp_venda
WHERE nota_fiscal.tp_venda = tp_venda.id AND nota_fiscal.pedido = pedidos.id AND pedidos.cliente = clientes.id AND nota_fiscal.status = status_nf.id AND pedidos.cliente LIKE '%$data[cliente]%' AND nota_fiscal.emissao BETWEEN '$data[inicio]' AND '$data[fim]' AND nota_fiscal.numero LIKE '%$data[nota]%' AND pedidos.numero LIKE '%$data[pedido]%'
				 ORDER BY $data[order] $order LIMIT $inicio, $qnt_result_pg";
$resultado_banco = mysqli_query($link, $result_banco) or die(mysqli_error($link));


//Verificar se encontrou resultado na tabela "bancos"
if(($resultado_banco) AND ($resultado_banco->num_rows != 0)){
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.buttonload {
			background-color: #4CAF50; /* Green background */
			border: none; /* Remove borders */
			color: white; /* White text */
			padding: 12px 16px; /* Some padding */
			font-size: 16px /* Set a font size */
		}
	</style>
	<table class="table table-hover table-sm">
		<thead>
			<tr>
                <th onclick="pesquisarNota(1, 'nota_fiscal.numero', '<?php echo $order; ?>')">Nota <?php echo ($order == "DESC") ? "<i class='fas fa-caret-up'></i>" : "<i class='fas fa-caret-down'></i>"; ?></th>
                <th onclick="pesquisarNota(1, 'pedidos.numero',  '<?php echo $order; ?>')">Pedido <?php echo ($order == "DESC") ? "<i class='fas fa-caret-up'></i>" : "<i class='fas fa-caret-down'></i>"; ?></th>
				<th onclick="pesquisarNota(1, 'clientes.id', '<?php echo $order; ?>')">Cliente <?php echo ($order == "DESC") ? "<i class='fas fa-caret-up'></i>" : "<i class='fas fa-caret-down'></i>"; ?></th>
                <th onclick="pesquisarNota(1, 'nota_fiscal.emissao',  '<?php echo $order; ?>')">Emissão <?php echo ($order == "DESC") ? "<i class='fas fa-caret-up'></i>" : "<i class='fas fa-caret-down'></i>"; ?></th>
				<th>Valor</th>
				<th>Tipo de Venda</th>
                <th onclick="pesquisarNota(1, 'nota_fiscal.status',  '<?php echo $order; ?>')">Status <?php echo ($order == "DESC") ? "<i class='fas fa-caret-up'></i>" : "<i class='fas fa-caret-down'></i>"; ?></th>
                <th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_array($resultado_banco)){
					?>

					<tr>
                    <th><?php echo $row[1]; ?></th>
                    <th><?php echo $row[7]; ?></th>
					<td><?php echo $row[2]. " - ".$row[3]; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row[4])) ; ?></td>
					<td>R$<?php echo number_format($row[8],2, ",","."); ?></td> 
					<td><?php echo $row[11];?></td>
                    <td><?php echo $row[6]; ?></td>
					<?php $ativo = ($row[5] == 1) ? "all" : "none" ?>
					<td><a style="pointer-events: <?php echo $ativo ?>" onclick="editarNF(<?php echo $row[1]; ?>, <?php echo $row[10]; ?>)"><i class="fas fa-pen"></i></a> <a onclick="imprimirNF(<?php echo $row[1]; ?>)" > <i class="fas fa-print"></i> </a> 
						<div class="btn-group dropup">
						<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fas fa-info-circle"></i> </a>   
						<div class="dropdown-menu">
							<a class="dropdown-item" data-toggle="modal" onclick="preencherEmail('<?php echo $row[9] ?>', '<?php echo $row[1]; ?>')" data-target="#modalEmail" href="">Enviar E-mail</a>
						</div>
						</div>

						<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Enviar nota fiscal</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form>
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Destinatário:</label>
									<input type="text" class="form-control" id="emailCli">
								</div>
								<div class="form-group">
									<input type="hidden" id="notaEnviar">
									<label for="message-text" class="col-form-label">Mensagem:</label>
									<textarea class="form-control" id="mensagem"></textarea>
								</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" id="fecharmodal" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
								<button id="btnEnviarEmail" type="button" class="btn btn-primary btn-square" onclick="enviarEmail()">Enviar</button>
							</div>
							</div>
						</div>
						</div>
					</td>
					</tr>
					<?php
				}
				?>

		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(nota_fiscal.id) AS num_result from nota_fiscal INNER JOIN pedidos where nota_fiscal.pedido = pedidos.id AND nota_fiscal.numero LIKE '%$data[nota]%' AND pedidos.numero LIKE '%$data[pedido]%' AND pedidos.cliente LIKE '%$data[cliente]%' AND nota_fiscal.emissao BETWEEN '$data[inicio]' AND '$data[fim]' ";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-center'>";
echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarNota(1)'>&laquo;</a></li>";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarNota($pag_ant)'>$pag_ant </a></li> ";
	}
}

echo "<li class='page-item active'><a href='#' class='page-link'> $pagina</a></li> ";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo "<li class='page-item'><a href='#' class='page-link' <a href='#' onclick=pesquisarNota($pag_dep)>$pag_dep</a></li> ";
	}
}

echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarNota($quantidade_pg)'>&raquo;</a></li>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}

echo "</ul>";
