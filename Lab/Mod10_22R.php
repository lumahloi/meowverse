<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Série Faça um Site – PHP 5 com MySQL</title>
</head>
<body>

<?PHP
$campo = $_POST['campo'];
$operador = $_POST['operador'];
$valor = $_POST['valor'];
$ordenar = $_POST['ordenar'];
$forma_ordem = $_POST['forma_ordem'];

include "estilo2.inc";
include "dbConexao.php";

$sql = "SELECT * ";
$sql = $sql . " FROM miniaturas ";

if ($operador <> "CONTEM") {
  $sql = $sql . " WHERE " . $campo . $operador . "'" . $valor . "'";
} else {
  $sql = $sql . " WHERE " . $campo . " LIKE " . "'%" . $valor . "%'";
}

$sql = $sql . " ORDER BY " . $ordenar . " " . $forma_ordem;

$rs = mysql_query($sql, $conexao);
$total_registros = mysql_num_rows($rs);
?>

<p>
  Você solicitou a seguinte pesquisa: <strong><?PHP print $campo . " " . $operador . " " . $valor ?></strong><br />
  Total de registros retornados: <strong><?PHP print $total_registros; ?></strong><br />
  Ordem de exibição dos registros: <strong><?PHP print $ordenar . " - " . $forma_ordem; ?></strong><br />
  Sentença SQL criada para a pesquisa: <strong><?PHP print $sql; ?></strong>
</p>

<table width="320" border="0" cellspacing="15" cellpadding="0">

<?PHP
while ($reg = mysql_fetch_array($rs)) {
  $codigo = $reg["codigo"];
  $nome = $reg["nome"];
  $preco = $reg["preco"];
  $desconto = $reg["desconto"];
  $credito = $reg["credito"];
  $valor_desconto = $preco - ($preco * $desconto / 100);
?>
<tr>
  <td valign="top"><img src="../imagens/<?PHP print $codigo; ?>.jpg" width="140" height="85"></td>
  <td valign="top">
    <span class="titulo_miniatura"><?PHP print $nome; ?></span>
    <span class="preco_normal">de: R$ <?PHP print number_format($preco,2,',','.'); ?></span><br />
    Por: <span class="destaque_preco">R$ <?PHP print number_format($valor_desconto,2,',','.'); ?></span> à vista<br />
    <span class="credito_imagem">crédito da imagem: <?PHP print $credito; ?></span><br />
  </td>
</tr>

<?PHP
}
?>
</table>
</body>
</html>

<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?> 
