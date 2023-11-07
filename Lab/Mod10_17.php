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

// Armazena na vari�vel $sql a senten�a SQL
$sql = "SELECT id_categoria, AVG(preco) AS media_preco  ";
$sql = $sql . " FROM miniaturas ";
$sql = $sql . " GROUP BY id_categoria ";
$sql = $sql . " HAVING AVG(preco) > '150.00' ";
$sql = $sql . " ORDER BY id_categoria ";

// Executa a sentence SQL e armazena seu resultado na vari�vel $rs
$rs = mysql_query($sql, $conexao);

// Armazena na vari�vel $total_registros o total de registros (linhas) retornados pela sentence SQL.
$total_registros = mysql_num_rows($rs);
?>
<body>

<p>Senten�a SQL desse laborat�rio: <strong><?PHP print $sql; ?></strong><br />
Total de registros retornados pela consulta: <strong><?PHP print $total_registros; ?></strong></p>

<!-- Cria a tabela para exibi��o dos dados com 2 colunas e exibe na primeira linha seus t�tulos -->
<table cellspacing="0">
<thead>
<tr>
  <td>Categoria</td>
  <td align="right">M�dia de pre�os</td>
</tr>
</thead>

<?PHP
// Inicia o la�o para a exibi��o dos registros
// Cada linha da tabela sera armazenada na vari�vel $reg por interm�dio da fun��o mysql_fetch_array()
while ($reg = mysql_fetch_array($rs)) {

  // Armazena nas respectivas vari�veis o valor de cada campo
  $id_categoria = $reg["id_categoria"];
  $media_preco = $reg["media_preco"];
?>

<!-- monta a pr�xima linha da tabela exibindo os dados nas respectivas colunas -->
<tr>
<td><?PHP print $id_categoria; ?></td>
<td align="right">R$ <?PHP print number_format($media_preco,2,',','.'); ?></td>
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
