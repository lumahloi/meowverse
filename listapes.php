<?php

session_start();

include "inc_dbConexao.php";

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select id, nome from miniaturas where nome like '%$q%'";

$rsd = mysqli_query($conexao, $sql);

while($rs = mysqli_fetch_array($rsd)) {
	echo $rs['nome']."\n";
}
?>