<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>S�rie Fa�a um Site � PHP 5 com MySQL</title>
</head>

<?PHP
// Inclui a folha de estilo (CSS) com o layout da p�gina 
// este arquivo foi baixado com o kit de trabalho deste livro
// Sua inclus�o � opcional
include "estilo1.inc";

// Faz a conex�o dom o banco de dados
include "dbConexao.php";

// Armazena na vari�vel $sql a sentence SQL
$sql = "SELECT categorias.cat_nome, miniaturas.*  ";
$sql = $sql . " FROM categorias ";
$sql = $sql . " INNER JOIN miniaturas ";
$sql = $sql . " ON categorias.id = miniaturas.id_categoria ";
$sql = $sql . " WHERE categorias.cat_nome = 'M�quinas pesadas' ";

// Executa a sentence SQL e armazena seu resultado na vari�vel $rs
$rs = mysql_query($sql, $conexao);

// Armazena na vari�vel $total_registros o total de registros (linhas) retornados pela sentence SQL.
$total_registros = mysql_num_rows($rs);
?>
<body>

<p>Senten�a SQL desse laborat�rio: <strong><?PHP print $sql; ?></strong><br />
Total de registros retornados pela consulta: <strong><?PHP print $total_registros; ?></strong></p>

<!-- Cria a tabela para exibi��o dos dados com 11 colunas e exibe na primeira linha seus t�tulos -->
<table cellspacing="0">
<thead>
<tr>
  <td>ID</td>
  <td>C�digo</td>
  <td>Descri��o</td>
  <td>Cat</td>
  <td>Ano</td>
  <td>Cor</td>
  <td>Escala</td>
  <td align="right">Pre�o</td>
  <td align="right">Qt.Est</td>
  <td align="right">Est.Min</td>
  <td>Dt.Cad</td>
</tr>
</thead>

<?PHP
// Inicia o la�o para a exibi��o dos registros
// Cada linha da tabela sera armazenada na vari�vel $reg por interm�dio da fun��o mysql_fetch_array()
while ($reg = mysql_fetch_array($rs)) {

  // Armazena nas respectivas vari�veis o valor de cada campo
  $id = $reg["id"];
  $codigo = $reg["codigo"];
  $nome = $reg["nome"];
  $id_categoria = $reg["cat_nome"];
  $escala = $reg["escala"];
  $ano = $reg["ano"];
  $cor = $reg["cor"];
  $preco = $reg["preco"];
  $estoque = $reg["estoque"];
  $min_estoque = $reg["min_estoque"];
  $data_cad = $reg["data_cad"];
?>

<!-- monta a pr�xima linha da tabela exibindo os dados nas respectivas colunas -->
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

<!-- retorna a instru��o while at� que seu valor seja falso -->
<?PHP
}
?>

</table>
</body>
</html>

<!-- Encerra a conex�o com o banco de dados -->
<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?>
