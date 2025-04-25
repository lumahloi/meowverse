<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// Inicializa variavel de erro
$erro = "0";

// Captura de dados enviados pelo método POST da página login.php
if ($_POST["txtemail1"] <> "") {
	$email = $_POST['txtemail1'];
	$senha = $_POST['txtsenha1'];
}

// Verifica se o e-mail do cliente já está cadastrado
$sql = "SELECT * ";
$sql .= " FROM cadcli ";
$sql .= " WHERE email = '".$email."'";
$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);
if ($total_registros == 0) {
	$mensagem_erro = "Email não cadastrado";
	$erro = "1";
}

// Verifica se a senha digitada para um e-mail já cadastrado é válida
if ($erro == "0") {
	$sql = "SELECT * ";
	$sql .= "FROM cadcli ";
	$sql .= "WHERE senha = sha1('$senha');";
	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);
	$total_registros = mysqli_num_rows($rs);
	if ($total_registros == 0) {
		$mensagem_erro = "Senha inválida.";
		$erro = "2";
	}
}

// Recupera dados do cliente
if ($erro == "0") {
	$sql = "SELECT * ";
	$sql .= "FROM cadcli ";
	$sql .= "WHERE email = '" . $email . "' ";
	$sql .= "AND senha = sha1('$senha');";
	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);

	// Armazena dados do cliente nas variáveis de sessão para serem usados nas próximas páginas
	$_SESSION['id_cli'] = $reg['id'];
	$_SESSION['email_cli'] = $reg['email'];
	$_SESSION['nome_cli'] = $reg['nome'];
	$_SESSION['cpf'] = $reg['cpf'];
	$_SESSION['rg'] = $reg['rg'];
	$_SESSION['sexo'] = $reg['sexo'];
	//$_SESSION['senha'] = $reg['senha'];
	$_SESSION['senha'] = $senha;
	$_SESSION['end_nome'] = $reg['end_nome'];
	$_SESSION['end_num'] = $reg['end_num'];
	$_SESSION['end_comp'] = $reg['end_comp'];
	$_SESSION['cep'] = $reg['cep'];
	$_SESSION['bairro'] = $reg['bairro'];
	$_SESSION['cidade'] = $reg['cidade'];
	$_SESSION['uf'] = $reg['uf'];
	// Executa a página cadastro.php
	print "<meta HTTP-EQUIV='Refresh' CONTENT='0; URL=cadastro.php'>";
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
	<div class="site-wrap">
		<?php include "inc_menuSuperiorCat.php" ?>

		<div class="site-section">
			<div class="container">
				<?PHP if ($erro == 1) { ?>
					<div class="container mx-auto text-center mt-5 mb-5">
						<div class="row">
							<div class="col">
								<h4 class="mb-3"><?PHP print $mensagem_erro; ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<a href="javascript:history.go(-1)" class="btn btn-primary" role="button" aria-pressed="true">Voltar à loja</a>
							</div>
						</div>
					</div>
				<?PHP } ?>
				<?PHP if ($erro == 2) { ?>
					<div class="container mx-auto text-center mt-5 mb-5">
						<div class="row">
							<div class="col">
								<h4 class="mb-3"><?PHP print $mensagem_erro; ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<a href="javascript:history.go(-1)" class="btn btn-primary" role="button" aria-pressed="true">Voltar à loja</a>
							</div>
						</div>
					</div>
				<?PHP } ?>
			</div>
		</div>


		<?php include "inc_rodape.php" ?>
	</div>

	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/main.js"></script>
</body>

</html>

<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>