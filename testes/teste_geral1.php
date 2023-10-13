<html>
<head>
<title>Acessando dados de um banco de dados MySQL</title>
</head>
<body>
<font face="arial" size="2" color="red"><b>Olá pessoal! Estes são alguns dados do primeiro registro da Tabela miniaturas</font></b><Br><Br>
<?php
$conexao = mysql_connect("localhost","root","2943215");
$db = mysql_select_db("db_php5", $conexao);
$sql = "SELECT * FROM miniaturas";
$rs = mysql_query($sql, $conexao);
$linha = mysql_fetch_array($rs);
$nome = $linha["nome"];
echo "Código: $nome";
echo "<br>";

mysql_free_result($rs);
mysql_close ($conexao);
?>
</body>
</html>



