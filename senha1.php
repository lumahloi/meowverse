<?PHP
// +---------------------------------------------------------+
// | Esqueci minha senha - envio do e-mail                   |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";
$email = $_POST['txtemail'];

$sql = " SELECT nome, email, senha ";
$sql .= " FROM cadcli ";
$sql .= " WHERE email = '" . $email . "' ";

//echo $sql;
//exit;

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$total_registros = mysqli_num_rows($rs);

// Armazena dados do cliente nas variáveis de seção para serem usados nas próximas páginas
$email = $reg['email'];
$nome = $reg['nome'];
$senha = $reg['senha'];



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
	<script language="javascript">
		function valida_form() {
			if (document.senha.txtemail.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				pedidos.txtemail.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>

	<div class="container">
		<!-- Se clicado no botão Meu cadastro do menu superior -->
		<?PHP if ($_SESSION['cadastro'] == "S") { ?>
			<?PHP $tit_etapa = "Meu Cadastro"; ?>
			<div id="topo"><?PHP include "inc_menu_superior.php" ?></div>
			<div id="menuSup"><?PHP include "inc_menu_categorias.php" ?></div>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
		<?PHP } else { ?>
			<?PHP $tit_etapa = "Etapa 1"; ?>
			<div id="etapa1"><a href="index.php"><img src="imagens/logo.png" alt="Faça um Site" border="0" /></a></div>
		<?PHP } ?>

		<h3 class="mt-3 mb-2">Esqueceu sua senha? </h3>

		<div class="container border bg-light">
			<p>&nbsp;</p>

			<?PHP if ($total_registros <> 0) { ?>
				<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<p>Olá <span class="c_laranja"><strong><?PHP print $nome; ?></strong></span>,</p>
							<p>Agradecemos sua preferência pela Faça um Site Miniaturas. Sua senha foi enviada para a caixa postal: <span class="c_laranja"> <strong><?PHP print $email; ?></strong></span>.</p>
						</td>
					</tr>
					<tr>
						<td>
							<div align="center"><a href="login.php?cadastro=<?PHP print $_SESSION['cadastro']; ?>"><img src="imagens/btn_continuar.gif" width="95" height="20" vspace="3" border="0" /></a> </div>
						</td>
					</tr>
				</table>
			<?PHP } else { ?>
				
				<div class="row">
					<h4 align="center" class="c_vermelho">E-mail não cadastrado.</h4>
				</div>
						
				<div class="row text-center"><a href="login.php?cadastro=<?PHP print $_SESSION['cadastro']; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Voltar</button></a></div>
						
			<?PHP } ?>

			<p>&nbsp;</p>
		</div>

		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
<?PHP
// Envio de e-mail com a senha solicitada
$assunto = "Solicitação de sua senha";

$msg = "***** TESTE DO LIVRO - FAÇA UM SITE PHP4 COM MYSQL - COMÉRCIO ELETRÔNICO\n\n";
$msg = $msg . "Olá\t$nome\n";
$msg = $msg . "Agradecemos sua preferência pelo Faça um Site Miniaturas.\n\n";
$msg = $msg . "Sua senha de acesso ao nosso site é a seguinte: \t$senha.\n\n";
$msg = $msg . "Para sua segurança nâo revele sua senha a ninguêm.\n";
$msg = $msg . "Essa mensagem foi enviada apenas para o seu e-mail, e só você tem acesso a ela.\n\n";
$msg = $msg . "Atenciosamente.\n";
$msg = $msg . "Faça um Site Miniaturas.\n\n";

$cabecalho = "From: Faça um Site\n";


?>
</div>
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>