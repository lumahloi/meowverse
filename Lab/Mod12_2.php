<?PHP
// Faz a conex�o dom o banco de dados
include "dbConexao.php";

// Seleciona os registros
$sql = "SELECT * FROM miniaturas_teste";
$rs = mysql_query($sql, $conexao);
?>

<html>
<head>
<title>S�rie Fa�a um Site � PHP 5 com MySQL</title>
<!-- As linhas entre 6 e 25 s�o opcionais. Elas usam CSS para definer o layout da tabela. -->
<style type="text/css">
body {font-family: Arial, Helvetica, sans-serif;}
table {border: 2px solid #000000; width: 100%;}
td {font-size: 11px; border-width: 1px; border-color: #999999; border-right-style: solid; border-bottom-style: solid;}
#titulo_tabela {background-color: #cccccc;}
</style>
<!-- Fim Formata��o do document usando CSS -->
</head>
<body>
<h3>Tabela de Miniaturas - Altera&ccedil;&atilde;o </h3>

<table cellspacing="0">
<tr id="titulo_tabela">
<td width="10%">C�digo</td>
<td width="57%">Descri��o</td>
<td width="18%"><div align="right">Pre&ccedil;o</div></td>
<td width="15%" align="right">Pre�o</td>
</tr>

<?PHP
while ($reg = mysql_fetch_array($rs)) {
  $id = $reg["id"];
  $codigo = $reg["codigo"];
  $nome = $reg["nome"];
  $preco = $reg["preco"];
?>
<tr>
<td><?PHP print $codigo; ?></td>
<td><?PHP print $nome; ?></td>
<td align="right">R$ <?PHP print number_format($preco,2,',','.'); ?></td>
<td><div align="right">

</div></td>
</tr>
<?PHP } ?>
</table>
</body>
</html>

<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?>
