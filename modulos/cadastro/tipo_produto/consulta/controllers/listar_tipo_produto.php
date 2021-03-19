<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
		$pagina = intval($data['pagina']);
		$qnt_result_pg = intval($data['qnt_result_pg']);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

//consultar no banco de dados
$result_usuario = "SELECT * FROM tipo_produto ORDER BY CAST(cod as int) DESC LIMIT $inicio, $qnt_result_pg";
$resultado_usuario = mysqli_query($link, $result_usuario);


//Verificar se encontrou resultado na tabela "usuarios"
if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	?>
	
	<table class="table table-sm table-hover">
		<thead>
			<tr>
				<th>Código</th>
                <th>Descrição</th>
                <th>Editar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
				if ($row_usuario['inativo'] == 1){
					?>
					<tr style="color: red">
					<th><?php echo $row_usuario['cod']; ?></th>
                    <td><?php echo $row_usuario['descricao']; ?></td>
					<td><a onclick="editar(<?php echo $row_usuario['id'] ?> ,
					'<?php echo $row_usuario['cod'] ?>', 
					'<?php echo $row_usuario['descricao'] ?>',
					<?php echo $row_usuario['inativo'] ?>, 
					'<?php echo $row_usuario['usuario_criacao'] ?>')"><i class="fas fa-pen"></i></a></td>
				</tr>
					<?php
				} else{
					?>
					<tr>
						<th><?php echo $row_usuario['cod']; ?></th>
                    	<td><?php echo $row_usuario['descricao']; ?></td>
                    	<td><a onclick="editar(<?php echo $row_usuario['id'] ?> ,'<?php echo $row_usuario['cod'] ?>', 
                    	'<?php echo $row_usuario['descricao'] ?>', <?php echo $row_usuario['inativo'] ?>, '<?php echo $row_usuario['usuario_criacao'] ?>')"><i class="fas fa-pen"></i></a></td>
					</tr>
					<?php
				}
				?>

				<?php
			}?>
		</tbody>
	</table>
<?php
//Paginação - Somar a quantidade de usuários
$result_pg = "SELECT COUNT(id) AS num_result FROM tipo_produto";
$resultado_pg = mysqli_query($link, $result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);

//Quantidade de pagina
$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

//Limitar os link antes depois
$max_links = 2;
echo "<ul class='pagination justify-content-end'>";
echo "<li class='page-item'><a href='#' class='page-link' onclick='listar_usuario(1, $qnt_result_pg)'>&laquo;</a></li>";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo "<li class='page-item'><a href='#' class='page-link' onclick='listar_usuario($pag_ant, $qnt_result_pg)'>$pag_ant </a></li> ";
	}
}

echo "<li class='page-item active'><a href='#' class='page-link'> $pagina</a></li> ";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo "<li class='page-item'><a href='#' class='page-link' <a href='#' onclick='listar_usuario($pag_dep, $qnt_result_pg)'>$pag_dep</a></li> ";
	}
}

echo "<li class='page-item'><a href='#' class='page-link' onclick='listar_usuario($quantidade_pg, $qnt_result_pg)'>&raquo;</a></li>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}

echo "</ul>";
