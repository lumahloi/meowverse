<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Inicializa variável de erro
$erro = "0";

// Recupera e-mail e senha
if ($_POST['txtemail'] <> "") {
	$email = $_POST['txtemail'];
	$senha = $_POST['txtsenha'];
}

// Verifica se o e-mail do cliente já está cadastrado
$sql = "SELECT * ";
$sql .= " FROM cadcli ";
$sql .= " WHERE email = '" . $email . "' ";

$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);
if ($total_registros == 0) {
	$mensagem_erro = "Email não cadastrado";
	$erro = "1";
}

// Verifica senha
if ($erro == "0") {
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE senha = sha1('$senha')";

	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);
	$total_registros = mysqli_num_rows($rs);
	if ($total_registros == 0) {
		$mensagem_erro = "Senha inválida.";
		$erro = "2";
	}
}

// Recupera dados do cadastro de clientes
if ($erro == "0") {
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE email = '" . $email . "' ";
	$sql .= " AND senha = sha1('$senha')";

	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);

	// Armazena dados do cliente para as próximas páginas
	$_SESSION['email_cli'] = $reg['email'];
	$_SESSION['nome'] = $reg['nome'];
	$_SESSION['id'] = $reg['id'];

	// Captura dados do pedido
	//$sql = " select * from pedidos as p inner join cadcli as c on p.id_cliente = ".$_SESSION['id'].";";
	$sql = "select * from pedidos where id_cliente = ".$_SESSION['id'].";";

	//echo $sql;
	//exit;
	$rs = mysqli_query($conexao, $sql);
	$total_registros = mysqli_num_rows($rs);

	// Carrega dados do cliente
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE id = '" . $_SESSION['id'] . "' ";

	//echo $sql;
	//exit;
	$rs1 = mysqli_query($conexao, $sql);
	$reg1 = mysqli_fetch_array($rs1);

	// Armazena dados do cliente para as próximas páginas
	$_SESSION['email_cli'] = $reg1['email'];
	$_SESSION['nome_cli'] = $reg1['nome'];
	$_SESSION['end_nome'] = $reg1['end_nome'];
	$_SESSION['end_num'] = $reg1['end_num'];
	$_SESSION['end_comp'] = $reg1['end_comp'];
	$_SESSION['cep'] = $reg1['cep'];
	$_SESSION['bairro'] = $reg1['bairro'];
	$_SESSION['cidade'] = $reg1['cidade'];
	$_SESSION['uf'] = $reg1['uf'];
	$_SESSION['id'] = $reg1['id'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Meowverse</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
	<link rel="stylesheet" href="fonts/icomoon/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/aos.css">
	<link rel="stylesheet" href="css/style.css">

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
</head>

<body>

	<?php include "inc_menuSuperiorCat.php" ?>

	<div class="site-wrap">
		<div class="site-section">
			<div class="container">
				<?php if ($erro == 0) { ?>
					<?PHP if ($total_registros <> 0) { ?>
						<table class="table table-borderless">
							<thead>
								<td></td>
								<th>N° pedido</th>
								<th>Data do pedido</th>
								<th>Vencimento</th>
								<th>Status</th>
								<th>Valor</th>
							</thead>
							<tbody>
								<?PHP
								while ($reg = mysqli_fetch_array($rs)) {
									$num_ped = $reg["num_ped"];
									$data = $reg["data"];
									$hora = $reg["hora"];
									$valor = $reg["valor"];
									$status = $reg["status_ped"];
									$vencimento = $reg["vencimento"];
									$frete = $reg['frete'];
									$desconto = $reg['desconto'];
									?>
									<tr>
										<td>
											<button class="btn btn-primary btn-sm"
												onclick="window.location='detalhe_ped.php?det_ped=<?php echo $num_ped ?>'">Detalhar
												esse pedido</button>
										</td>
										<td>
											<?php print $num_ped ?>
										</td>
										<td>
											<?php print substr($data, 8, 2) . " / " . substr($data, 5, 2) . " / " . substr($data, 0, 4) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $hora; ?>
										</td>
										<td>
											<?php print substr($vencimento, 8, 2) . " / " . substr($vencimento, 5, 2) . " / " . substr($vencimento, 0, 4); ?>
										</td>
										<td>
											<?php print $status ?>
										</td>
										<td>R$
											<?php print number_format(($valor + $frete - $desconto), 2, ',', '.'); ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
						<div class="row text-center">
							<div class="col">
								<h4 class="mb-3">
									Você não efetuou nenhuma compra em nosso site
								</h4>
							</div>
						</div>
						<div class="row text-center">
							<div class="col">
								<a href="index.php" class="btn btn-primary" role="button" aria-pressed="true">Voltar</a>
							</div>
						</div>
				<?php } } else { ?>
					<?php if ($erro == 1) { ?>
						<div class="row text-center">
							<div class="col">
								<h4 class="mb-3">
									<?php print $mensagem_erro ?>
								</h4>
							</div>
						</div>
						<div class="row text-center">
							<div class="col">
								<a href="index.php" class="btn btn-primary" role="button" aria-pressed="true">Voltar</a>
							</div>
						</div>
					<?php }
					if ($erro == 2) { ?>
						<div class="row text-center">
							<div class="col">
								<h4 class="mb-3">
									<?php print $mensagem_erro ?>
								</h4>
							</div>
						</div>
						<div class="row text-center">
							<div class="col">
								<a href="index.php" class="btn btn-primary" role="button" aria-pressed="true">Voltar</a>
							</div>
						</div>
					<?php } } ?>
			</div>
		</div>
	</div>

	<?php include "inc_rodape.php" ?>

	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/main.js"></script>
</body>

</html>

<?PHP
mysqli_free_result($rs);
mysqli_close ($conexao);
?>