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
$titulo_pagina = "Liberação de cartão de crédito";

// Seleciona registros
$sql = "SELECT * FROM pedidos ";
$sql = $sql . " WHERE status = 'Aguardando aprovação do cartão' ";
$sql = $sql . " ORDER BY id ASC";
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
<h1 class="c_cinza">Contas a Receber <img src="../imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto"><?PHP print $titulo_pagina; ?></span> </h1>

<P>Total de registros encontrados: <span class="c_preto"><?PHP print $total_registros; ?></span></P>
<table width="100%" cellspacing="0">
<tr>
<td width="14%" class="tabela_titulo">N° do pedido</td>
<td width="16%" class="tabela_titulo">Cartão</td>
<td width="33%" class="tabela_titulo">Status</td>
<td width="12%" class="tabela_titulo">Data</td>
<td width="14%" align="right" class="tabela_titulo">Valor</td>
<td width="11%" class="tabela_titulo">&nbsp;</td>
</tr>	

<?PHP
// Exibe registros a serem baixados
while ($reg = mysqli_fetch_array($rs)) {
$id = $reg["id"];
$num_ped = $reg["num_ped"];
$cartao = $reg["cartao"];
$status = $reg["status"];
$data = $reg["data"];
$valor = $reg["valor"];
$total = $total + $valor;
?>
<tr>
<td class="registro"><?PHP print $num_ped; ?></td>
<td class="registro"><?PHP print $cartao; ?></td>
<td class="registro"><?PHP print $status; ?></td>		
<td class="registro"><?PHP print substr($data,8,2) . "/" . substr($data,5,2) . "/" . substr($data,0,4); ?></td>	
<td class="registro" align="right"><?PHP print number_format($valor,2,',','.'); ?></td>		
<td class="registro"><div align="right">
<a href="baixar_cartao1.php?acao=alt&id=<?PHP print $id; ?>&titulo=Liberação de cartão de crédito"><img src="../imagens/btn_baixar.gif" alt="Baixar pagamento" width="55" height="16" border="0" /></a></div></td>
</tr>
<?PHP } ?>	
<tr>
<td colspan="4" class="registro"><strong>Total a receber</strong></td>
<td align="right" class="registro"><strong><?PHP print number_format($total,2,',','.'); ?></strong></td>
<td class="registro">&nbsp;</td>		
</tr>
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