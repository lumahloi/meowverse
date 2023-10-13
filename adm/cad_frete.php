<?PHP
// +---------------------------------------------------------+
// | Edição de registros - frete                             |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrÔnico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();
$acao = $_GET['acao'];
$id = $_GET['id'];
$titulo_pagina = $_GET['titulo'];
if ($acao == "ver") {
	// modo de edição das caixas de texto do formulário
	$editar = "readonly='true'";
	$editar_combo = "disabled='disabled'";
	$estilo_caixa = "caixa_texto_des";
} else {
	$editar = "";
	$editar_combo = "";	
	$estilo_caixa = "caixa_texto";
}
// Recupera registro 
$sql = "SELECT * FROM tb_estados ";
$sql = $sql . " WHERE id = '" . $id . "' ";
$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$id = $reg['id'];
$uf = $reg['uf'];
$nome = $reg['nome'];
$frete = $reg['frete'];
$cepi = $reg['cepi'];
$cepf = $reg['cepf'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo_adm.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form name="form_cad" method="post" action="cad_frete1.php">	
<div id="corpo">
<div id="topo">
  <h1>Administração do Site</h1>
</div>

<div id="caixa_menu">
<?PHP include "inc_menu.php" ?>
</div>

<div id="caixa_conteudo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="62%"><h1 class="c_cinza">Manutenção Cadastral <img src="../imagens/marcador_setaDir.gif" align="absmiddle" /> Frete <img src="../imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto"><?PHP print $titulo_pagina; ?></span> </h1>
</td>
<td width="38%"><div align="right">
<?PHP if($acao == "ins" or $acao == "alt") { ?>
	<a href="cad_frete_grid.php?id=<?PHP print $id; ?>"><img src="../imagens/btn_fechar_ss.gif" alt="Fechar" border="0" /></a>
	<input type="image" name="imageField" src="../imagens/btn_salvar.gif" />
	<input type="hidden" name="acao" value="<?PHP print $acao; ?>" />
	<input type="hidden" name="id" value="<?PHP print $id; ?>" />	
<?PHP } ?>	
<?PHP if($acao == "exc") { ?>
	<input type="image" name="imageField" src="../imagens/btn_excluir.gif" />
	<input type="hidden" name="acao" value="<?PHP print $acao; ?>" />
	<input type="hidden" name="id" value="<?PHP print $id; ?>" />	
	<a href="cad_frete_grid.php?id=<?PHP print $id; ?>"><img src="../imagens/btn_nao_excluir.gif" alt="Fechar" border="0" /></a>	
<?PHP } ?>
<?PHP if($acao == "ver") { ?>
		<a href="cad_frete_grid.php?id=<?PHP print $id; ?>"><img src="../imagens/btn_fechar.gif" alt="Fechar" border="0" /></a>
<?PHP } ?>
</div></td>
</tr>
</table>

<div id="caixa_cad">
<p><label>UF:</label><input name="uf" type="text" class="<?PHP print $estilo_caixa; ?>" size="2" maxlength="2" value="<?PHP print $uf; ?>" <?PHP print $editar; ?> /></p>
<p><label>Estado:</label><input name="nome" type="text" class="<?PHP print $estilo_caixa; ?>" size="20" maxlength="20" value="<?PHP print $nome; ?>" <?PHP print $editar; ?> /></p>
<p><label>Frete:</label><input name="frete" type="text" class="<?PHP print $estilo_caixa; ?>" size="11" maxlength="11" value="<?PHP print $frete; ?>" <?PHP print $editar; ?> /></p>
<p><label>CEP inicial:</label><input name="cepi" type="text" class="<?PHP print $estilo_caixa; ?>"  size="8" maxlength="8" value="<?PHP print $cepi; ?>" <?PHP print $editar; ?> /></p>
<p><label>CEP final:</label><input name="cepf" type="text" class="<?PHP print $estilo_caixa; ?>"  size="8" maxlength="8" value="<?PHP print $cepf; ?>" <?PHP print $editar; ?> /></p>
</div>

</div>
<!-- rodape da página -->
<?PHP include "inc_rodape.php" ?>
</div>
</form>
</body>
</html>
<?PHP
// Libera os recursos usados pela conexâo atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>
