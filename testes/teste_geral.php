<html>
<head>
<title>Acessando dados de um banco de dados MySQL</title>
</head>
<body>
<h2>Teste de instalação e configuração do Apache, PHP5 e MySQL</h2>
<p>Parabéns! você instalou e configurou com sucesso todas as ferramentas necessárias para a utilização deste livro.</p>
<?php
$conexao = mysql_connect("localhost","root","admin");
$db = mysql_select_db("db_php5", $conexao);
$sql = "SELECT * FROM teste";
$rs = mysql_query($sql, $conexao);
while ($reg = mysql_fetch_array($rs)) {
$teste = $reg["campo1"];
print $teste . "<br />";
}
mysql_free_result($rs);
mysql_close ($conexao);
?>
</body>
</html>



