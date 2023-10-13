<?PHP
// +---------------------------------------------------------+
// | ampliar imagem                                          |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site        |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero             |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

SESSION_START();
// Recupera código e nome da imagem
$codigo = $_GET['codigo'];
$nome = $_GET['nome'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Faça um Site - PHP 5 com banco de dados MySQL</title>
  <link rel="stylesheet" href="style.css">
  <style type="text/css">
    <!--
    body {
      margin-left: 0px;
      margin-top: 0px;
      margin-right: 0px;
      margin-bottom: 0px;
      background-color: #FFFFFF;
    }
    -->
  </style>
</head>

<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td class="titulo_imagem"><?PHP print $nome; ?></td>
    </tr>
    <tr>
      <td valign="top"><img src="imagens/<?PHP print $codigo; ?>G.jpg" width="516" height="310" /></td>
    </tr>
  </table>
</body>

</html>