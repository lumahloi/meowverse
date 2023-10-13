<?PHP
// +---------------------------------------------------------+
// | Recupera dados da página login.php                      |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

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
$sql .= " WHERE email = '" . $email . "' ";
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
	$sql .= "WHERE senha = '" . $senha . "' ";
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
	$sql .= "AND senha = '" . $senha . "' ";
	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);

	// Armazena dados do cliente nas variáveis de sessão para serem usados nas próximas páginas
	$_SESSION['id_cli'] = $reg['id'];
	$_SESSION['email_cli'] = $reg['email'];
	$_SESSION['nome_cli'] = $reg['nome'];
	$_SESSION['cpf'] = $reg['cpf'];
	$_SESSION['rg'] = $reg['rg'];
	$_SESSION['sexo'] = $reg['sexo'];
	$_SESSION['senha'] = $reg['senha'];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça um Site - PHP 5 com Banco de Dados MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

	<div class="container">
		<!-- Se clicado no botão Meu cadastro do menu superior -->
		<?PHP if (['cadastro'] == "S") { ?>
			<?PHP $tit_etapa = "Meu Cadastro"; ?>
			<div id="topo"><?PHP include "inc_menu_pesquisa.php" ?></div>
			<div id="menuSup"><?PHP include "inc_menu_sup.php" ?></div>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
		<?PHP } else { ?>
			<?PHP $tit_etapa = "Etapa 1"; ?>
			<div id="etapa1"><a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" border="0" /></a></div>
		<?PHP } ?>

		<!-- Título da página -->
		<h3 class="mt-5 mb-3"><?PHP print $tit_etapa; ?> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_cinza">Identificação</span></h3>

		<div class="container bg-light border">
			<div align="center">
				<table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							<!-- Exibe mensagens de erro -->
							<?PHP if ($erro == 1) { ?>
								<h4 class="c_vermelho"><?PHP print $mensagem_erro; ?></h4>
								<p><a href="javascript:history.go(-1)"><button class="btn btn-success">Voltar</button></a></p>
							<?PHP } ?>

							<?PHP if ($erro == 2) { ?>
								<h4 class="c_vermelho"><?PHP print $mensagem_erro; ?></h4>
								<p><a href="javascript:history.go(-1)"><button class="btn btn-success">Voltar</button></a></p>
							<?PHP } ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?PHP include "inc_rodape.php" ?>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>