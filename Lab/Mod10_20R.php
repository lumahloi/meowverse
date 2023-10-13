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

include "estilo1.inc";
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
  Ordem de exibição dos registros: <strong><?PHP print $ordenar . " - " . $forma_ordem; ?></strong><br /><br />
  Sentença SQL criada para a pesquisa: <strong><?PHP print $sql; ?></strong>
</p>

<table cellspacing="0">
<thead>
<tr>
  <td>ID</td>
  <td>Código</td>
  <td>Descrição</td>
  <td>Cat</td>
  <td>Ano</td>
  <td>Cor</td>
  <td>Escala</td>
  <td align="right">Preço</td>
  <td align="right">Qt.Est</td>
  <td align="right">Est.Min</td>
  <td>Dt.Cad</td>
</tr>
</thead>

<?PHP
while ($reg = mysql_fetch_array($rs)) {
  $id = $reg["id"];
  $codigo = $reg["codigo"];
  $nome = $reg["nome"];
  $id_categoria = $reg["id_categoria"];
  $escala = $reg["escala"];
  $ano = $reg["ano"];
  $cor = $reg["cor"];
  $preco = $reg["preco"];
  $estoque = $reg["estoque"];
  $min_estoque = $reg["min_estoque"];
  $data_cad = $reg["data_cad"];
?>

<tr>
  <td><?PHP print $id; ?></td>
  <td><?PHP print $codigo; ?></td>
  <td><?PHP print $nome; ?></td>
  <td><?PHP print $id_categoria; ?></td>
  <td><?PHP print $ano; ?></td>
  <td><?PHP print $cor; ?></td>
  <td><?PHP print $escala; ?></td>
  <td align="right">R$ <?PHP print number_format($preco,2,',','.'); ?></td>
  <td align="right"><?PHP print $estoque; ?></td>
  <td align="right"><?PHP print $min_estoque; ?></td>
  <td><?PHP print substr($data_cad,8,2) . '/' . substr($data_cad,5,2) . '/' . substr($data_cad,0,4); ?></td>
</tr>

<?PHP
}
?>

</body>
</html>

<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?>