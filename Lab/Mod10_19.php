<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Série Faça um Site – PHP 5 com MySQL</title>
</head>

<?PHP
// Inclui a folha de estilo (CSS) com o layout da página 
// este arquivo foi baixado com o kit de trabalho deste livro
// Sua inclusão é opcional
include "estilo1.inc";

// Faz a conexão dom o banco de dados
include "dbConexao.php";

// Armazena na variável $sql a sentence SQL
$sql = "SELECT categorias.cat_nome, miniaturas.*  ";
$sql = $sql . " FROM categorias ";
$sql = $sql . " INNER JOIN miniaturas ";
$sql = $sql . " ON categorias.id = miniaturas.id_categoria ";
$sql = $sql . " WHERE categorias.cat_nome = 'Máquinas pesadas' ";

// Executa a sentence SQL e armazena seu resultado na variável $rs
$rs = mysql_query($sql, $conexao);

// Armazena na variável $total_registros o total de registros (linhas) retornados pela sentence SQL.
$total_registros = mysql_num_rows($rs);
?>
<body>

<p>Sentença SQL desse laboratório: <strong><?PHP print $sql; ?></strong><br />
Total de registros retornados pela consulta: <strong><?PHP print $total_registros; ?></strong></p>

<!-- Cria a tabela para exibição dos dados com 11 colunas e exibe na primeira linha seus títulos -->
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
// Inicia o laço para a exibição dos registros
// Cada linha da tabela sera armazenada na variável $reg por intermédio da função mysql_fetch_array()
while ($reg = mysql_fetch_array($rs)) {

  // Armazena nas respectivas variáveis o valor de cada campo
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

<!-- monta a próxima linha da tabela exibindo os dados nas respectivas colunas -->
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

<!-- retorna a instrução while até que seu valor seja falso -->
<?PHP
}
?>

</table>
</body>
</html>

<!-- Encerra a conexão com o banco de dados -->
<?PHP
mysql_free_result($rs);
mysql_close ($conexao);
?>
