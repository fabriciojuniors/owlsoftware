<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
		$pagina = intval($data['pagina']);
		$qnt_result_pg = intval($data['qnt_result_pg']);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;
$tabela = "cidade";
//consultar no banco de dados
$result_banco = "SELECT * FROM $tabela ORDER BY codigo_ibge ASC LIMIT $inicio, $qnt_result_pg";
$resultado_banco = mysqli_query($link, $result_banco);


//Verificar se encontrou resultado na tabela "bancos"
if(($resultado_banco) AND ($resultado_banco->num_rows != 0)){{
	?>
	
	<table class="table table-sm table-sm table-hover">
		<thead>
			<tr>
				<th>Código</th>
				<th>Descrição</th>
				<th>UF</th>
                <th>Editar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_assoc($resultado_banco)){
				?>
					<tr>
						<td><?php echo $row['codigo_ibge'] ?> </td>
						<td><?php echo $row['nome'] ?> </td>
						<?php
						$sql = "SELECT nome from uf WHERE id = '$row[codigo_uf]'";
						$result = mysqli_query($link, $sql);
						$linha = mysqli_fetch_array($result);?>
						<td><?php echo $linha[0] ?> </td>
						<?php
							$sql = "select id_pais from uf where id = $row[codigo_uf]";
							$query = mysqli_query($link, $sql);
							$pais = mysqli_fetch_array($query);
							$pais = $pais[0];
						?>
						<td><a onclick="editar(<?php echo $row['id'] ?> ,'<?php echo $row['codigo_ibge'] ?>', 
                    	'<?php echo $row['nome'] ?>', '<?php echo $row['codigo_uf'] ?>', '<?php echo $pais ?>')"><i class="fas fa-pen"></i></a></td>
					</tr>
					<?php
				}
			}?>
		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(id) AS num_result FROM $tabela";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-end'>";
echo "<li class='page-item'><a href='#' class='page-link' onclick='listar(1, $qnt_result_pg)'>&laquo;</a></li>";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo "<li class='page-item'><a href='#' class='page-link' onclick='listar($pag_ant, $qnt_result_pg)'>$pag_ant </a></li> ";
	}
}

echo "<li class='page-item active'><a href='#' class='page-link'> $pagina</a></li> ";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo "<li class='page-item'><a href='#' class='page-link' <a href='#' onclick='listar($pag_dep, $qnt_result_pg)'>$pag_dep</a></li> ";
	}
}

echo "<li class='page-item'><a href='#' class='page-link' onclick='listar($quantidade_pg, $qnt_result_pg)'>&raquo;</a></li>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}

echo "</ul>";
