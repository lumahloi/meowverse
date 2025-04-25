<?PHP
// +---------------------------------------------------------+
// | Baixar cartao de crédito                                |
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
$sql = $sql . "status = 'Pagamento confirmado', ";
$sql = $sql . "data_pag = '$data_pag' ";
$sql = $sql . " WHERE id = '" . $id . "' ";	
mysqli_query($conexao, $sql);

// Baixa do estoque
// Recupera número do pedido 
$sql = "SELECT * FROM pedidos ";
$sql = $sql . " WHERE id = '" . $id . "' ";
$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$num_ped = $reg['num_ped'];


// Verifica os itens do pedido
$sqli = "SELECT * FROM itens";
$sqli = $sqli . " WHERE num_ped = '" . $num_ped . "' ";
$rsi = mysqli_query($conexao, $sqli);
$total_registros = mysqli_num_rows($rsi);
// Captura os itens do pedido
while ($regi = mysqli_fetch_array($rsi)) {
$codigo = $regi["codigo"];
$qt = $regi["qt"];

// Recupera quantidade em estoque do item
$sqlm = "SELECT * FROM miniaturas";
$sqlm = $sqlm . " WHERE codigo = '" . $codigo . "' ";	
$rsm = mysqli_query($conexao, $sqlm);
$regm = mysqli_fetch_array($rsm);
$qt_estoque = $regm['estoque'];

// Armazena na variável qt_estoque_atual a quantidade em estoque menos a quantidade vendida
$qt_estoque_atual = $qt_estoque - $qt;

// Baixa o item do estoque
$sqlu = "UPDATE miniaturas SET ";
$sqlu = $sqlu . "estoque = '$qt_estoque_atual' ";
$sqlu = $sqlu . " WHERE codigo = '" . $codigo . "' ";	
mysqli_query($conexao, $sqlu);
} 
}
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rsm);
mysqli_close ($conexao);
print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=baixar_boletos.php?id=" . $id . "'>";
?>

