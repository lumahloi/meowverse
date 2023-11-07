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

// Armazena na variável $sql a sentença SQL
$sql = "SELECT id_categoria, AVG(preco) AS media_preco  ";
$sql = $sql . " FROM miniaturas ";
$sql = $sql . " GROUP BY id_categoria ";
$sql = $sql . " HAVING AVG(preco) > '150.00' ";
$sql = $sql . " ORDER BY id_categoria ";

// Executa a sentence SQL e armazena seu resultado na variável $rs
$rs = mysql_query($sql, $conexao);

// Armazena na variável $total_registros o total de registros (linhas) retornados pela sentence SQL.
$total_registros = mysql_num_rows($rs);
?>
<body>

<p>Sentença SQL desse laboratório: <strong><?PHP print $sql; ?></strong><br />
Total de registros retornados pela consulta: <strong><?PHP print $total_registros; ?></strong></p>

<!-- Cria a tabela para exibição dos dados com 2 colunas e exibe na primeira linha seus títulos -->
<table cellspacing="0">
<thead>
<tr>
  <td>Categoria</td>
  <td align="right">Média de preços</td>
</tr>
</thead>

<?PHP
// Inicia o laço para a exibição dos registros
// Cada linha da tabela sera armazenada na variável $reg por intermédio da função mysql_fetch_array()
while ($reg = mysql_fetch_array($rs)) {

  // Armazena nas respectivas variáveis o valor de cada campo
  $id_categoria = $reg["id_categoria"];
  $media_preco = $reg["media_preco"];
?>

<!-- monta a próxima linha da tabela exibindo os dados nas respectivas colunas -->
<tr>
<td><?PHP print $id_categoria; ?></td>
<td align="right">R$ <?PHP print number_format($media_preco,2,',','.'); ?></td>
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
