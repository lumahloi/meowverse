<?PHP
// +---------------------------------------------------------+
// | Relatório: Itens abaixo do estoque mínimo               |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();
$titulo_pagina = "Itens abaixo do estoque minimo";
// Seleciona registros
$sql = "SELECT codigo,nome,estoque,preco FROM miniaturas";
$sql = $sql . " WHERE estoque < min_estoque ";
$sql = $sql . " ORDER BY estoque ASC";
$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo_adm.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="corpo">
<div id="topo">
  <h1>Administração do Site</h1>
</div>
<div id="caixa_menu">
	<?PHP include "inc_menu.php" ?>
</div>

<div id="caixa_conteudo">
<h1 class="c_cinza">Relatórios <img src="../imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto"><?PHP print $titulo_pagina; ?></span> </h1>
<P>Total de registros encontrados: <span class="c_preto"><?PHP print $total_registros; ?></span></P>
<table width="100%" cellspacing="0">
<tr>
<td width="8%" class="tabela_titulo">Código</td>
<td width="48%" class="tabela_titulo">Descrição</td>
<td width="12%" align="right" class="tabela_titulo">Estoque</td>
<td width="18%" align="right" class="tabela_titulo">Preço</td>
</tr>	
<?PHP
while ($reg = mysqli_fetch_array($rs)) {
$id = $reg["id"];
$codigo = $reg["codigo"];
$nome = $reg["nome"];
$estoque = $reg["estoque"];
$preco = $reg["preco"];
?>
<tr>
<td class="registro"><?PHP print $codigo; ?></td>
<td class="registro"><?PHP print $nome; ?></td>
<td class="registro" align="right"><?PHP print $estoque; ?></td>		
<td class="registro" align="right"><?PHP print $preco; ?></td>		
</tr>
<?PHP } ?>	
</table>
</div>
<!-- rodape da página -->
<?PHP include "inc_rodape.php" ?>
</div>
</body>
</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>