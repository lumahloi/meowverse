<?PHP
// +---------------------------------------------------------+
// | Esqueci minha senha                                     |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

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
				document.senha.txtemail.focus();
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
			<!-- Se a página for chamada por intermédio do botâo "Fechar pedido" do carrinho de compras -->
			<!-- Nâo exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
		<?PHP } else { ?>
			<?PHP $tit_etapa = "Etapa 1"; ?>
			<div id="etapa1"><a href="index.php"><img src="imagens/logo.png" alt="Faça um Site" border="0" /></a></div>
		<?PHP } ?>

		<h3 class="mt-3 mb-2">Esqueceu sua senha? </h3>

		<div class="container bg-light border p-3 mt-3 mb-3">
			
			<div class="row text-center">
				<p>Digite seu e-mail no campo abaixo e depois clique no botão &quot;Continuar&quot;. Sua senha será enviada para o e-mail informado. </p>
			</div>

			<div class="row row-cols-3">
					<div class="col-md-3 text-center">
						<form name="senha" method="post" action="senha1.php" onsubmit="return valida_form(this);">
							<label>Seu email:</label>
					</div>
					<div class="col-md-6">
							<input name="txtemail" type="text" class="caixa_texto" size="60" />
					</div>
					<div class="col-md-3">
							<button class="btn btn-success" style="background-color: purple; border-color: purple;">Continuar</button>
						</form>
					</div>
			</div>
		</div>

		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>