<?PHP
include "../inc_dbConexao.php";
SESSION_START();
// Ação a ser executada nesta página (ins=inserir, alt=alterar, del=excluir, ver=visualizar
$acao = $_POST['acao'];

// Campos da tabela
$id = $_POST['id'];
$codigo = $_POST['codigo'];
$destaque = $_POST['destaque'];
$nome = $_POST['nome'];
$id_categoria = $_POST['id_categoria'];
$subcateg = $_POST['subcateg'];
$altura = $_POST['altura'];
$preco = $_POST['preco'];
$desconto = $_POST['desconto'];
$desconto_boleto = $_POST['desconto_boleto'];
$max_parcelas = $_POST['max_parcelas'];
$estoque = $_POST['estoque'];
$min_estoque = $_POST['min_estoque'];
$fabrica = $_POST['fabrica'];
$descricao = $_POST['descricao'];

// Ação de inclusão
if ($acao == "ins") {
$titulo_pagina = "Inserir novo registro";
$mensagem = "<h1 class='c_laranja'>A inclusão do registro foi efetuada com sucesso.</h1>";
$mensagem = $mensagem . $codigo . " - " . $nome;
// Insere registro
$sql = "INSERT INTO miniaturas ";
$sql = $sql . "(codigo, destaque, nome, id_categoria, subcateg, altura, preco, desconto, desconto_boleto, max_parcelas, estoque, min_estoque, fabrica, descricao) ";
$sql = $sql . "VALUES('$codigo', '$destaque', '$nome', '$id_categoria', '$subcateg', '$altura', '$preco', '$desconto', '$desconto_boleto', '$max_parcelas', '$estoque', '$min_estoque', '$fabrica', '$descricao') ";

mysqli_query($conexao, $sql);
}

// Ação de alteração
if ($acao == "alt") {
$titulo_pagina = "Alteração cadastral";
$mensagem = "<h1 class='c_laranja'>A alteração do registro foi efetuada com sucesso.</h1>";
$mensagem = $mensagem . $codigo . " - " . $nome;
// Altera registro
$sql = "UPDATE miniaturas SET ";
$sql = $sql . "codigo = '$codigo', ";
$sql = $sql . "nome = '$nome', ";
$sql = $sql . "id_categoria = '$id_categoria', ";
$sql = $sql . "subcateg = '$subcateg', ";
$sql = $sql . "destaque = '$destaque', ";
$sql = $sql . "altura = '$altura', ";
$sql = $sql . "preco = '$preco', ";
$sql = $sql . "desconto = '$desconto', ";
$sql = $sql . "desconto_boleto = '$desconto_boleto', ";
$sql = $sql . "max_parcelas = '$max_parcelas', ";
$sql = $sql . "estoque = '$estoque', ";
$sql = $sql . "min_estoque = '$min_estoque', ";
$sql = $sql . "fabrica = '$fabrica', ";
$sql = $sql . "descricao = '$descricao', ";
$sql = $sql . "WHERE id = '" . $id . "' ";	
mysqli_query($conexao, $sql);
}

// Ação de exclusão
if ($acao == "exc") {
// Exclui registro
$sql = "DELETE FROM miniaturas ";
$sql = $sql . " WHERE id = '" . $id . "' ";	
mysqli_query($conexao, $sql);
}
// Executa página cad_miniaturas_grid.php
print "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=cad_miniaturas_grid.php?id=" . $id . "'>";	
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>

