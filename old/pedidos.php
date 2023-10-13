<?PHP
// +---------------------------------------------------------+
// | Meus pedidos                                            |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Faça um Site - PHP 5 com banco de dados MySQL</title>
  <link href="estilo_site.css" rel="stylesheet" type="text/css" />
  <script language="javascript">
    function valida_form() {
      if (document.pedidos.txtemail.value == "") {
        alert("Por favor, preencha o campo e-mail.");
        pedidos.txtemail.focus();
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
      <?PHP include "inc_menu_superior.php" ?>
    </div>

    <!-- Menu de categorias -->
    <div id="menuSup">
      <?PHP include "inc_menu_categorias.php" ?>
    </div>

    <h1>Meus Pedidos</h1>

    <div id="caixa">
      <p>Para prosseguir, por favor, identifique-se utilizando os campos abaixo e depois clique no bot&atilde;o &quot;Continuar&quot;.</p>
      <p>&nbsp;</p>
      <form name="pedidos" method="post" action="pedidos1.php" onsubmit="return valida_form(this);">
        <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="8%">Seu email:</td>
            <td width="29%"><input name="txtemail" type="text" class="caixa_texto" size="40" /></td>
          </tr>
          <tr>
            <td>Sua senha:</td>
            <td><input name="txtsenha" type="password" class="caixa_texto" size="40" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="image" name="imageField" src="imagens/btn_continuar.gif" /></td>
          </tr>
        </table>
      </form>
      <p>&nbsp;</p>
    </div>

    <!-- rodape da página -->
    <?PHP include "inc_rodape.php" ?>
  </div>
</body>
</html>