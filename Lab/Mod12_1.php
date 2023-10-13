<html>
<head>
<title>Série Faça um Site – PHP 5 com MySQL</title>

<!-- As linhas entre 6 e 25 são opcionais. Elas usam CSS para definer o layout da tabela. -->
<style type="text/css">
body {
  font-family: Arial, Helvetica, sans-serif;
}
table {
  border: 2px solid #000000;
  width: 100%;
}
td {
  font-size: 11px;
  border-width: 1px;
  border-color: #999999;
  border-right-style: solid;
  border-bottom-style: solid;

}
#titulo_tabela {
  background-color: #cccccc;
}
</style>
<!-- Fim Formatação do document usando CSS -->

</head>

<?PHP
$conexao = mysql_connect("localhost","root","admin");
$db = mysql_select_db("db_php5", $conexao);

// Cria a sentença SQL de atualização
$sql = "UPDATE miniaturas_teste SET preco = preco * 1.05 ";
mysql_query($sql, $conexao);

// Seleciona os registros
$sql = "SELECT * FROM miniaturas_teste";
$rs = mysql_query($sql, $conexao);
?>

<body>
<h3>Produtos da Faça um Site Miniaturas.</h3>

<table cellspacing="0">
<tr id="titulo_tabela">
<td>Código</td>
<td>Descrição</td>
<td>Categoria</td>
<td align="right">Preço</td>
</tr>

<?PHP
while ($reg = mysql_fetch_array($rs)) {
  $codigo = $reg["codigo"];
  $nome = $reg["nome"];
  $id_categoria = $reg["id_categoria"];
  $preco = $reg["preco"];
?>

<tr>
<td><?PHP print $codigo; ?></td>
<td><?PHP print $nome; ?></td>
<td><?PHP print $id_categoria; ?></td>
<td align="right">R$ <?PHP print number_format($preco,2,',','.'); ?></td>
</tr>

<?PHP } ?>

</table>
</body>
</html>

<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?>
