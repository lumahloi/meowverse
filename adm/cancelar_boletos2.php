<?PHP
// +---------------------------------------------------------+
// | cancelar boletos                                        |
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
$status = $_POST['status'];
$data_pag = date('Y-m-d');

if ($acao == "alt") {
$titulo_pagina = "Alteração cadastral";
$mensagem = "<h1 class='c_laranja'>A alteração do registro foi efetuada com sucesso.</h1>";
// Altera registro
$sql = "UPDATE pedidos SET ";
$sql = $sql . "status = 'Pedido cancelado', ";
$sql = $sql . "data_pag = '$data_pag' ";
$sql = $sql . " WHERE id = '" . $id . "' ";	
mysqli_query($conexao, $sql);
}
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rsm);
mysqli_close ($conexao);
print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=baixar_boletos.php?id=" . $id . "'>";
?>

