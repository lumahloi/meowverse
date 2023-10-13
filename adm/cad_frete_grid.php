<?PHP
// +---------------------------------------------------------+
// | Tabela de estados - frete                               |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "../inc_dbConexao.php";
SESSION_START();
if ($_GET['id'] == "") {
	$idsel = $_POST['id'];
} else {
	$idsel = $_GET['id'];
}
$sql = "SELECT * FROM tb_estados";
$sql = $sql . " ORDER BY id ";
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="80%"><h1 class="c_cinza">Manutenção Cadastral <img src="../imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto">Fretes</span> </h1></td>

<!-- Incluir registroas -->
<!-- Executa o cadastro de FRETES com ação de inserção (ins) -->
<td width="20%"><h1 align="right"><a href="cad_frete.php?acao=ins&amp;titulo=Inclusão de registro"><img src="../imagens/btn_inserir.gif" alt="Inserir novo registro" border="0" /></a></h1></td>
</tr>
</table>

<P>Total de registros no cadastro: <span class="c_preto"><?PHP print $total_registros; ?></span></P>
<table width="100%" cellspacing="0">
<tr id="titulo_tabela">
<td width="8%" class="tabela_titulo">UF</td>
<td width="48%" class="tabela_titulo">Estado</td>
<td width="18%" align="right" class="tabela_titulo">Frete</td>
<td colspan="3" class="tabela_titulo"><div align="right">Ações</div></td>	
</tr>

<?PHP
// Exibe os registros na tabela
while ($reg = mysqli_fetch_array($rs)) {
$id = $reg["id"];
$uf = $reg["uf"];
$nome = $reg["nome"];
$frete = $reg["frete"];
//Destaca a linha do último registro selecionado (fundo azul claro)
if ($idsel == $id) {
$fundo = "registro_sel";
} else {
$fundo = "registro";	
}
?>
<tr>
<!-- Exibe os campos do registro -->
<td class="<?PHP print $fundo; ?>"><?PHP print $uf; ?></td>
<td class="<?PHP print $fundo; ?>"><?PHP print $nome; ?></td>
<td align="right" class="<?PHP print $fundo; ?>">R$ <?PHP print number_format($frete,2,',','.'); ?></td>

<!-- Excluir registros -->
<!-- Executa o cadastro de FRETES com ação de exclusão (exc) -->
<td width="6%" class="<?PHP print $fundo; ?>"><a href="cad_frete.php?acao=exc&id=<?PHP print $id; ?>&titulo=Exclusão de registro"><img src="../imagens/btn_cancelar_reg.gif" alt="Cancelar esse registro" border="0" /></a></td>	

<!-- Alterar registros -->
<!-- Executa o cadastro de FRETES com ação de alteração (alt) -->
<td width="5%" class="<?PHP print $fundo; ?>"><a href="cad_frete.php?acao=alt&id=<?PHP print $id; ?>&titulo=Alteração de registro"><img src="../imagens/btn_alterar_reg.gif" alt="Alterar esse registro" border="0" /></a></td>	

<!-- Visualizar registros -->
<!-- Executa o cadastro de FRETES com ação de visualização (ver) -->
<td width="3%" class="<?PHP print $fundo; ?>"><a href="cad_frete.php?acao=ver&id=<?PHP print $id; ?>&titulo=Detalhes do registro"><img src="../imagens/btn_ver_detalhes.gif" alt="Ver detalhes desse registro" border="0" /></a></td>			
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