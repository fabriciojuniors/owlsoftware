<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$pagina = intval($data['pagina']);
$qnt_result_pg = intval($data['qnt_result_pg']);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;
$tabela = "ordem_recebimento";
if($data['iemissao'] == ''){
	$imessao = '2000-01-01';
}else{
	$imessao = $data['iemissao'];
}

if($data['femissao'] ==''){
	$femissao = date("Y-m-d");
}else{
	$femissao = $data['femissao'];
}
//consultar no banco de dados
$result_banco = "SELECT ordem_recebimento.numero, clientes.nome, ordem_recebimento.valor_total, ordem_recebimento.id, ordem_recebimento.emissao, status_or.descricao FROM ordem_recebimento INNER JOIN clientes INNER JOIN status_or where ordem_recebimento.status = status_or.id AND ordem_recebimento.emissao BETWEEN '$imessao' AND '$femissao' AND ordem_recebimento.cliente = clientes.id AND ordem_recebimento.cliente LIKE '%$data[cliente]%' AND ordem_recebimento.numero LIKE '%$data[nor]%' ORDER BY id desc LIMIT $inicio, $qnt_result_pg";
$resultado_banco = mysqli_query($link, $result_banco) or die(mysqli_error($link));


//Verificar se encontrou resultado na tabela "bancos"
if(($resultado_banco) AND ($resultado_banco->num_rows != 0)){
	?>
	
	<table class="table table-hover table-sm">
		<thead>
			<tr>
				<th>OR</th>
				<th>Cliente</th>
				<th>Emissão</th>
				<th>Valor</th>
                <th>Editar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_array($resultado_banco)){
					?>

					<tr>
					<th><?php echo $row[0]; ?></th>
					<td><?php echo $row[1]; ?></td>
					<td><?php echo date("d/m/Y", strtotime($row[4])) ; ?></td>
					<td>R$<?php echo number_format((float)$row[2],2, ",",".") ?></td>
					<td><a onclick="editarOR( <?php echo $row[3] ?>)"><i class="fas fa-pen"></i></a></td>
					</tr>
					<?php
				}
				?>

		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(id) AS num_result FROM $tabela WHERE cliente LIKE '%$data[cliente]%'  AND ordem_recebimento.numero LIKE '%$data[nor]%'";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-end'>";
echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarProd(1, $qnt_result_pg)'>&laquo;</a></li>";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarProd($pag_ant, $qnt_result_pg)'>$pag_ant </a></li> ";
	}
}

echo "<li class='page-item active'><a href='#' class='page-link'> $pagina</a></li> ";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo "<li class='page-item'><a href='#' class='page-link' <a href='#' onclick='pesquisarProd($pag_dep, $qnt_result_pg)'>$pag_dep</a></li> ";
	}
}

echo "<li class='page-item'><a href='#' class='page-link' onclick='pesquisarProd($quantidade_pg, $qnt_result_pg)'>&raquo;</a></li>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}

echo "</ul>";
