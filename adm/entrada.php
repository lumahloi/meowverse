<?PHP
// +---------------------------------------------------------+
// | Página de entrada da área administrativa                |
// +---------------------------------------------------------+
// | Parte integrante do livro da serie Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();
// Verifica se a página está liberada para uso 
// fs_liberado foi armazenado na variável de sessão da página login_usuario.php
// Este procedimento evita que um usuario tente executar esta página sem passar pelo login.
if ($_SESSION['acesso'] <> "fs_liberado") {
  print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=liberacao.php'>";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo_adm.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="corpo">
<div id="topo">
  <h1>Administração do Site</h1>
</div>
<div id="caixa_menu">
<?PHP include "inc_menu.php" ?>
</div>
<div id="caixa_conteudo">
<table width="100%" height="400" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<!-- rodape da página -->
<?PHP include "inc_rodape.php" ?>
</div>
</body>
</html>