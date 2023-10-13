<?PHP
// +---------------------------------------------------------+
// | Recupera dados da página index.php                      |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();

// Captura dados enviados pelo método POST da página index.php
$login = $_POST['login'];
$senha = $_POST['senha'];

// Verifica se o e-mail do cliente já está cadastrado
$sql = " SELECT * ";
$sql .= " FROM usuarios ";
$sql .= " WHERE login = '" . $login . "' ";
$sql .= " AND senha = '" . $senha . "' ";

//echo $sql;
//exit;
$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
// Recupera o número de acesso do usuário
$id = $reg['id'];
$acesso = $reg['acesso'];
$total_registros = mysqli_num_rows($rs);

if ($total_registros == 0) {
	$_SESSION['mensagem_erro'] = "Login ou senha inválidos";
	print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
} else {
	$_SESSION['mensagem_erro'] = "";
	// Autoriza liberação para as páginas de administração do site
	$_SESSION['acesso'] = "fs_liberado";	
	// Executa a página entrada.php
	print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=entrada.php'>";	
}
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>