<?PHP
// +---------------------------------------------------------+
// | ADM INDEX - login da área administrativa                |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
	<link href="estilo_adm.css" rel="stylesheet" type="text/css" />
	<script language="javascript">
		//<!-- Valida campos do formulário de entrega (usuários já cadastrados) -->
		function valida_form() {
			if (document.form_login.login.value == "") {
				alert("Por favor, preencha o campo [Login].");
				form_login.login.focus();
				return false;
			}
			if (document.form_login.senha.value == "") {
				alert("Por favor, preencha o campo [Senha].");
				form_login.senha.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
	<div id="corpo">

		<!-- Logomarca e mneu superior -->
		<div id="topo">
			<h1>Administração do Site</h1>
		</div>

		<table width="100%" height="300" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">
					<table width="50%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="49%" align="left" valign="top" class="caixa_cinza">
								<h1>Acesso restrito aos administradores do site</h1>
								<p class="c_vermelho"><strong><?PHP print $_SESSION['mensagem_erro']; ?></strong></p>
								<p>&nbsp;</p>
								<form name="form_login" method="post" action="login_usuario.php" onsubmit="return valida_form(this);">
									<p><label>Login:</label><input name="login" type="text" class="caixa_texto" size="30" maxlength="30" /></p>
									<p><label>Senha:</label><input name="senha" type="password" class="caixa_texto" size="8" maxlength="8" /></p>
									<p>&nbsp;</p>
									<input type="image" name="imageField" src="../imagens/btn_continuar.gif" />
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
</body>

</html>