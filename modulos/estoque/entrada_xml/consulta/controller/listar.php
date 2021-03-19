<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$pagina = intval($data['pagina']);
$qnt_result_pg = intval($data['qnt_result_pg']);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;
$nota= '';
$fornecedor ='';
$tp_entrada = '';
if(isset($data['nota']) && $data['nota'] !=''){
	$nota = "nota_fiscal_entrada.numero=". $data['nota']. " AND ";
}
if(isset($data['fornecedor']) && $data['fornecedor'] !=''){
	$fornecedor = "nota_fiscal_entrada.fornecedor=". $data['fornecedor']. " AND ";
}
if(isset($data['tpEntrada']) && $data['tpEntrada'] !='#'){
	$tp_entrada = "nota_fiscal_entrada.tp_entrada=". $data['tpEntrada']. " AND ";
}
//consultar no banco de dados
$result_banco = "SELECT clientes.nome, nota_fiscal_entrada.emissao, nota_fiscal_entrada.numero, tp_entrada.descricao, nota_fiscal_entrada.status, status_nf.descricao as nomeStatus, (SELECT sum(valor) FROM item_nf_entrada WHERE nota = nota_fiscal_entrada.id) as valor
FROM nota_fiscal_entrada, clientes, tp_entrada, status_nf
WHERE $nota $fornecedor $tp_entrada nota_fiscal_entrada.fornecedor = clientes.id AND nota_fiscal_entrada.tp_entrada = tp_entrada.id AND status_nf.id = nota_fiscal_entrada.status ORDER BY nota_fiscal_entrada.emissao DESC LIMIT $inicio, $qnt_result_pg";
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
                <th>Nota</th>
				<th>Fornecedor</th>
				<th>Emissão</th>
				<th>Tp. Entrada</th>
				<th>Valor</th>
				<th>Status</th>
                <th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_array($resultado_banco)){
					?>

					<tr>
						<td><?php echo $row['numero']; ?></td>
						<td><?php echo $row['nome']; ?></td>
						<td><?php echo date("d/m/Y", strtotime($row['emissao'])); ?></td>
						<td><?php echo $row['descricao']; ?></td>
						<td><?php echo"R$". number_format($row['valor'],2,",","."); ?></td>
						<td><?php echo $row['nomeStatus']; ?></td>
						<td><a <?php echo ($row['status']<> 1) ? '' : "onclick='editarNF($row[numero])'" ?>><i class="fas fa-pen"></i></a></td>
					</tr>
					<?php
				}
				?>

		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(id) AS num_result from nota_fiscal_entrada ";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-end'>";
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
