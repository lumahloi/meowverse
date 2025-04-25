<?PHP
// +---------------------------------------------------------+
// | Cadastro de usuários                                    |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();
// Ação a ser executada nesta página (ins=inserir, alt=alterar, del=excluir, ver=visualizar
$acao = $_POST['acao'];
// Campos da tabela
$id = $_POST['id'];
$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];
// Ação de inclusão
if ($acao == "ins") {
	$titulo_pagina = "Inserir novo registro";
	$mensagem = "<h1 class='c_laranja'>A inclusão do registro foi efetuada com sucesso.</h1>";
	$mensagem = $mensagem . $nome . " - ";
	// Insere registro
	$sql = "INSERT INTO usuarios ";
	$sql = $sql . "(nome,login,senha,acesso) ";
	$sql = $sql . "VALUES('$nome','$login','$senha','1') ";
	mysqli_query($conexao, $sql);
}
// Ação de alteração
if ($acao == "alt") {
	$titulo_pagina = "Alteração cadastral";
	$mensagem = "<h1 class='c_laranja'>A alteração do registro foi efetuada com sucesso.</h1>";
	$mensagem = $mensagem . $uf . " - " . $nome;
	// Altera registro
	$sql = "UPDATE usuarios SET ";
	$sql = $sql . "nome = '$nome', ";
	$sql = $sql . "login = '$login', ";
	$sql = $sql . "senha = '$senha' ";
	$sql = $sql . " WHERE id = '" . $id . "' ";	
	mysqli_query($conexao, $sql);
}
// Exclusão de registro
if ($acao == "exc") {
	// Insere registro
	$sql = "DELETE FROM usuarios ";
	$sql = $sql . " WHERE id = '" . $id . "' ";	
	mysqli_query($conexao, $sql);
}
print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=cad_usuario_grid.php?id=" . $id . "'>";
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>


