<?PHP
// +---------------------------------------------------------+
// | Login do cliente                                        |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

// cadastro = S (se entrada for pelo menu Meu cadastro(neste caso exibe o menu de categorias))
// cadastro = "" se entrada for pelo carrinho de compras (neste caso exibe as etapas de uma compra e
// não exibe o menu superior e menu  de categorias)
$_SESSION['cadastro'] = $_GET['cadastro'];

// Armazena na variavel de sessao o modo de visualização cadastral
$_SESSION['acao'] = "ver";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
	<link href="estilo_site.css" rel="stylesheet" type="text/css" />
	<script language="javascript">
		//Valida campos do formulário de entrega (usuários já cadastrados)-->
		function valida_form() {
			if (document.form_cadastro.txtemail1.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail1.focus();
				return false;
			}
			if (document.form_cadastro.txtsenha1.value == "") {
				alert("Por favor, preencha o campo [Senha].");
				form_cadastro.txtsenha1.focus();
				return false;
			}
			return true;
		}

		// Valida campos do formulário de cadastro (novos usuários) -->
		function valida_form1() {
			if (document.form_cadastro.txtemail2.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail2.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>

	<div id="corpo">
		<!-- Se clicado no botão Meu cadastro do menu superior -->
		<?PHP if (['cadastro'] == "S") { ?>
			<?PHP $tit_etapa = "Meu Cadastro"; ?>
			<div id="topo"><?PHP include "inc_menu_superior.php" ?></div>
			<div id="menuSup"><?PHP include "inc_menu_categorias.php" ?></div>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
		<?PHP } else { ?>
			<?PHP $tit_etapa = "Etapa 1"; ?>
			<div id="etapa1"><a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" border="0" /></a></div>
		<?PHP } ?>

		<!-- Título da página -->
		<h1><?PHP print $tit_etapa; ?> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_cinza">Identificação</span></h1>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="49%" valign="top" class="caixa_cinza">
					<h1>Já sou cadastrado</h1>
					<p>Para prosseguir, por favor, identifique-se utilizando os campos abaixo e depois clique no bot&atilde;o &quot;Continuar&quot;.</p>
					<p>(1) Para testar corretamente o projeto deste site é fundamental que você utilize uma<span class="c_preto"><strong> conta de e-mail </strong></span>válida.</p>
					<p>&nbsp;</p>

					<!-- Formulário para usuários castrados (login) -->
					<form name="form_entrega" method="post" action="login1.php" onsubmit="return valida_form(this);">
						<p><label>(1) Seu E-mail:</label><input name="txtemail1" type="text" class="caixa_texto" id="txtemail1" size="35" />
						</p>
						<p><label>Sua senha:</label><input name="txtsenha1" type="password" class="caixa_texto" id="txtsenha1" size="35" />
						</p>
						<p>&nbsp;</p>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="69%"><a href="senha.php" class="link_detalhes">Esqueci minha senha</a></td>
								<td width="31%" align="right"><input type="image" name="imageField" src="imagens/btn_continuar.gif" /></td>
							</tr>
						</table>
					</form>
				</td>
				<td width="2%">&nbsp;</td>
				<td width="49%" valign="top" class="caixa_cinza">
					<h1>Quero me cadastrar</h1>
					<p>Caso esta seja sua primeira compra na Fa&ccedil;a um Site miniaturas, preencha o campo com seu e-mail e clique no bot&atilde;o &quot;Continuar&quot;.</p>
					<p>(1) Para testar corretamente o projeto deste site é fundamental que você utilize uma<span class="c_preto"><strong> conta de e-mail </strong></span>válida.</p>
					<p>&nbsp;</p>

					<!-- Formulário para novos usuários castrados (efetua cadastro) -->
					<form name="form_cadastro" method="post" action="cadastro.php" onsubmit="return valida_form1(this);">
						<p><label>(1) Seu E-mail:</label><input name="txtemail2" type="text" class="caixa_texto" id="txtemail2" size="35" maxlength="60" />
						</p>
						<p><label>Sua senha:</label><input name="txtsenha2" type="text" disabled="disabled" class="caixa_texto_des" id="txtsenha2" value="Ser&aacute; solicitada na pr&oacute;xima etapa" size="35" /></p>
						<p>&nbsp;</p>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="right"><input type="image" name="imageField2" src="imagens/btn_continuar.gif" /></td>
							</tr>
						</table>
						<input type="hidden" name="acao" value="inc" />
					</form>
				</td>
			</tr>
		</table>
		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
</body>

</html>