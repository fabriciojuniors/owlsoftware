<?php
include $_SERVER['DOCUMENT_ROOT'] . '/owlsoftware/conexao.php';

if (isset($_GET['n']) && $_GET['n'] != '') {
	$sql = "SELECT * FROM nota_fiscal_entrada WHERE numero = $_GET[n]";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
	<link rel="stylesheet" href="/owlsoftware/common/css/style.css">
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/buscarFornecedor.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/moment.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/funcoes.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/salvarNF.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/adicionarItens.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/carregaItens.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/gerarParcelas.js"></script>
	<script src="/owlsoftware/modulos/estoque/entrada_xml/cadastro/js/finalizarEntrada.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
	<title>Nota fiscal de entrada</title>
</head>

<body>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h4 mb-0 text-gray-800">Nota fiscal de Entrada</h1>

		<div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
			<div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
				<button type="button" id="confirmar" onclick="salvarNF()" class="btn btn-square btn-success">Confirmar</button>
			</div>
			<div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
				<button type="button" onclick="window.location.href = '/owlsoftware/modulos/index.php?pag=entrada_xml'" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
			</div>
			<div class="btn-group" role="group" aria-label="Terceiro grupo">
				<button type="button" class="btn btn-primary btn-square" onclick="window.location.href = '/owlsoftware/modulos/index.php?pag=consulta_nf_entrada'">Pesquisar</button>
			</div>
		</div>
	</div>
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Cadastro</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php echo (isset($row['id'])) ? '' : 'disabled' ?>" id="profile-tab" onclick="carregaItens()" data-toggle="tab" href="#perfil" role="tab" aria-controls="profile" aria-selected="false">Itens</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php echo (isset($row['id'])) ? '' : 'disabled' ?>" id="contact-tab" data-toggle="tab" href="#contato" role="tab" aria-controls="contact" aria-selected="false">Financeiro</a>
		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><?php include "cadastro.php"; ?></div>
		<div class="tab-pane fade" id="perfil" role="tabpanel" aria-labelledby="profile-tab"><?php include "itens.php"; ?></div>
		<div class="tab-pane fade" id="contato" role="tabpanel" aria-labelledby="contact-tab"><?php include "financeiro.php"; ?></div>
	</div>

</body>

</html>