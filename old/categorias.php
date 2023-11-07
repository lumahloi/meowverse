<?PHP
// +---------------------------------------------------------+
// | Exibição das miniaturas por categoria                   |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "inc_dbConexao.php";
SESSION_START();

// Recupera id da categoria, nome da categoria e modo de ordenação e modo de ordenação pelo método GET

// Passados pelo inc_menu_sup e os links Menor Preço e Maior preço desta página
$cat_id		=	 $_GET['cat_id'];
$cat_nome	= 	$_GET['cat_nome'];
$ordenar	= 	$_GET['ordenar'];

// Seleciona miniaturas pelo id de categoria
$sql	 			= 	"SELECT * FROM miniaturas ";
$sql				.= 	"WHERE id_categoria = '" . $cat_id . "' ";
$sql				.= 	"ORDER BY " . $ordenar;
//echo $sql;
//exit;

$rs 				=	 mysqli_query($conexao, $sql);
$total_registros	= mysqli_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo_site.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
// Função para abertura da janela de imagens ampliadas
function ampliar_imagem(url,nome_janela,parametros) { 
  window.open(url,nome_janela,parametros);
}
//-->
</script>
</head>
<body>
<div id="corpo">

<!-- Logomarca e mneu superior -->
<div id="topo">
	<?PHP include "inc_menu_superior.php" ?>	
</div>

<!-- Menu de categorias -->		
<div id="menuSup">
	<?PHP include "inc_menu_categorias.php" ?>	
</div>

<!-- Decoração  -->
<div id="deco">
	<img src="imagens/deco_<?PHP print $cat_id; ?>.jpg" width="800" height="210" /></div>

<!-- Título da página e Ordenação de registros -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<!-- Título da página e total de registros exibidos -->
	<td width="45%"><h1><?PHP print $cat_nome; ?> <span class="c_cinza">[Total de itens nesta categoria: <?PHP print $total_registros; ?>]</span></h1></td>
	<!-- Links de ordenação -->
	<td width="55%" align="right" valign="bottom">Ordenar por:&nbsp;&nbsp;
		<?PHP if ($ordenar == "preco ASC") { ?>
		<span class="radio_sel">Menor preço</span><a href="categorias.php?cat_id=<?PHP print $cat_id; ?>&cat_nome=<?PHP print $cat_nome; ?>&ordenar=preco DESC" class="link_radio">Maior preço</a>
		<?PHP } else { ?>
		<a href="categorias.php?cat_id=<?PHP print $cat_id; ?>&cat_nome=<?PHP print $cat_nome; ?>&ordenar=preco ASC" class="link_radio">Menor preço</a><span class="radio_sel">Maior preço</span>
		<?PHP } ?>	
  </td>
</tr>
</table>	
	
<!-- exibição dos itens -->
<div id="caixa">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?PHP
for($contador=0; $contador < $total_registros; $contador++) {
	$reg = mysqli_fetch_array($rs); 
	$codigo = $reg["codigo"];
	$nome = $reg["nome"];
	$estoque = $reg["estoque"];
	$min_estoque = $reg["min_estoque"];
	$preco = $reg["preco"];
	$desconto = $reg["desconto"];
	$credito = $reg["credito"];
	$valor_desconto = $preco - ($preco * $desconto / 100);
				
	// Exibe dados da coluna esquerda 
	if ($contador % 2 == 0) {
		?>
		<tr>
		<td width="20%" valign="top"><a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" width="140" height="85" border="0" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a><br />
			<img src="imagens/btn_ampliar1.gif" width="140" height="16" border="0" /></td>
		<td width="30%" valign="top">
		<span class="titulo_miniatura"><?PHP print $nome; ?></span><br />
		<span class="preco_normal">de: R$ <?PHP print number_format($preco,2,',','.'); ?></span><br />
		Por: <span class="destaque_preco">R$ <?PHP print number_format($valor_desconto,2,',','.'); ?></span> à vista<br />
		<span class="credito_imagem">crédito da imagem: <?PHP print $credito; ?></span><br />
		<a href="detalhes.php?produto=<?PHP print $codigo; ?>" class="link_detalhes">Mais detalhes</a>
		<?PHP if ($estoque < $min_estoque) { ?><img src="imagens/btn_detalhes_nd.gif" hspace="15" vspace="5" border="0" align="absmiddle"><?PHP } ?>
		</td>				
		<?PHP
	// Exibe dados da coluna direita 
	} else { 
		?>
		<td width="20%" valign="top"><a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" width="140" height="85" border="0" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a><br />
			<img src="imagens/btn_ampliar1.gif" width="140" height="16" border="0" />	
		</td>
		<td width="30%" valign="top">
		<span class="titulo_miniatura"><?PHP print $nome; ?></span><br />
		<span class="preco_normal">de: R$ <?PHP print number_format($preco,2,',','.'); ?></span><br />
		Por: <span class="destaque_preco">R$ <?PHP print number_format($valor_desconto,2,',','.'); ?></span> à vista<br />
		<span class="credito_imagem">crédito da imagem: <?PHP print $credito; ?></span><br />
		<a href="detalhes.php?produto=<?PHP print $codigo; ?>" class="link_detalhes">Mais detalhes</a>
		<?PHP if ($estoque < $min_estoque) { ?><img src="imagens/btn_detalhes_nd.gif" hspace="15" vspace="5" border="0" align="absmiddle"><?PHP } ?></td>			
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<?PHP
	} // Encerra o Else
}   // Encerra o for
?>
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
