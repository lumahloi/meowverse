<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo2.css" rel="stylesheet" type="text/css" />
<!-- Valida campos -->
<script language="javascript">
function valida_form() {
if (document.form1.codigo.value == "")	{
	alert("Por favor, preencha o campo [Código].");
	form1.codigo.focus();
	return false;
}

if (document.form1.nome.value == "") {
	alert("Por favor, preencha o campo [Descrição].");
	form1.nome.focus();
	return false;
}

if (document.form1.ano.value == "") {
	alert("Por favor, preencha o campo [Ano].");
	form1.ano.focus();
	return false;
}

if (document.form1.ano.value == "") {
	alert("Por favor, preencha o campo [Ano].");
	form1.ano.focus();
	return false;
}

if (document.form1.id_categoria.value == "0") {
	alert("Por favor, selecione uma categoria.");
	form1.id_categoria.focus();
	return false;
}

if (document.form1.subcateg.value == "") {
	alert("Por favor, preencha o campo [Subcategoria].");
	form1.subcateg.focus();
	return false;
}

if (document.form1.destaque.value == "") {
	alert("Por favor, preencha o campo [Destaque Home Page].");
	form1.destaque.focus();
	return false;
}

if (document.form1.escala.value == "") {
	alert("Por favor, preencha o campo [Escala].");
	form1.escala.focus();
	return false;
}

if (document.form1.peso.value == "") {
	alert("Por favor, preencha o campo [Peso].");
	form1.peso.focus();
	return false;
}

if (document.form1.comprimento.value == "") {
	alert("Por favor, preencha o campo [Comprimento].");
	form1.comprimento.focus();
	return false;
}

if (document.form1.largura.value == "") {
	alert("Por favor, preencha o campo [Largura].");
	form1.largura.focus();
	return false;
}

if (document.form1.altura.value == "") {
	alert("Por favor, preencha o campo [Altura].");
	form1.altura.focus();
	return false;
}

if (document.form1.cor.value == "") {
	alert("Por favor, preencha o campo [Cor predominante].");
	form1.cor.focus();
	return false;
}

if (document.form1.preco.value == "") {
	alert("Por favor, preencha o campo [Preço].");
	form1.preco.focus();
	return false;
}

if (document.form1.desconto.value == "") {
	alert("Por favor, preencha o campo [Desconto].");
	form1.desconto.focus();
	return false;
}

if (document.form1.desconto_boleto.value == "") {
	alert("Por favor, preencha o campo [Desconto para boleto].");
	form1.desconto_boleto.focus();
	return false;
}

if (document.form1.max_parcelas.value == "") {
	alert("Por favor, preencha o campo [Parcelamento máximo].");
	form1.max_parcelas.focus();
	return false;
}

if (document.form1.estoque.value == "") {
	alert("Por favor, preencha o campo [Em estoque].");
	form1.estoque.focus();
	return false;
}

if (document.form1.min_estoque.value == "") {
	alert("Por favor, preencha o campo [Estoque mínimo].");
	form1.min_estoque.focus();
	return false;
}

if (document.form1.credito.value == "") {
	alert("Por favor, preencha o campo [Crédito da imagem].");
	form1.credito.focus();
	return false;
}
return true;
}

// Aceita somente valores numéricos.
function numero_inteiro(e){
var tecla=(window.event)?event.keyCode:e.which;
if((tecla > 47 && tecla < 58)) return true;
else{
if (tecla != 8) return false;
else return true;
}
}

// Aceita somente valores numéricos com separador decimal (vírgula ou ponto).
// Aceita somente valores numéricos com separador decimal (vírgula ou ponto).
function numero_fracionario(e){
var tecla=(window.event)?event.keyCode:e.which;
if((tecla > 47 && tecla < 58) || tecla == 46 || tecla == 44) return true;
else{
if (tecla != 8) return false;
else return true;
}
}

</script>

</head>
<body>
<form name="form1" method="post" action="Lab12_2B.php" onsubmit="return valida_form(this);">
<div id="caixa_cad">
<h1>Tabela de miniaturas - Alteração</h1>
<p><label>Código:</label><input name="codigo" type="text" class="caixa_texto" size="5" maxlength="5" /></p>
<p><label>Descrição:</label><input name="nome" type="text" class="caixa_texto" size="40" maxlength="60" /></p>
<p><label>Ano de fabricação:</label><input name="ano" type="text" class="caixa_texto" size="6" maxlength="4" /></p>

<p>
<label>Categoria:</label>
<select name="id_categoria" class="caixa_combo">
<?PHP
// Carrega combo de categorias
$itens_cat = "<option value='0'>-- Selecione uma categoria</option><br /> ";
$sql_cat = "SELECT * FROM categorias_teste ";
$rs_cat = mysql_query($sql_cat, $conexao);

print $itens_cat;
?>
</select>
</p>
	
<p><label>Subcategoria:</label><input name="subcateg" type="text" class="caixa_texto"  size="30" maxlength="30" /></p>
<p><label>Destaque Home Page:</label><input name="destaque" type="text" class="caixa_texto"  size="2" maxlength="1" /></p>
<p><label>Escala:</label><input name="escala" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Peso:</label><input name="peso" type="text" class="caixa_texto" size="10" maxlength="10" onkeypress="return numero_fracionario(event)" /></p>
<p><label>Comprimento:</label><input name="comprimento" type="text" class="caixa_texto" size="10" maxlength="10" onkeypress="return numero_fracionario(event)" /></p>
<p><label>Largura:</label><input name="largura" type="text" class="caixa_texto" size="10" maxlength="10" onkeypress="return numero_fracionario(event)" /></p>
<p><label>Altura:</label><input name="altura" type="text" class="caixa_texto" size="10" maxlength="10" onkeypress="return numero_fracionario(event)" /></p>
<p><label>Cor predominante:</label><input name="cor" type="text" class="caixa_texto" size="20" maxlength="20" /></p>
<p><label>Preço:</label><input name="preco" type="text" class="caixa_texto" size="10" maxlength="20" onkeypress="return numero_fracionario(event)" /></p>
<p><label>Desconto:</label><input name="desconto" type="text" class="caixa_texto" size="10" maxlength="2" onkeypress="return numero_inteiro(event)" /> (em porcentagem)</p>
<p><label>Desconto para boleto:</label><input name="desconto_boleto" type="text" class="caixa_texto" size="10" maxlength="2" onkeypress="return numero_inteiro(event)" /> (em porcentagem)</p>
<p><label>Parcelamento máximo:</label><input name="max_parcelas" type="text" class="caixa_texto" size="10" maxlength="2" onkeypress="return numero_inteiro(event)" /> </p>
<p><label>Em estoque:</label><input name="estoque" type="text" class="caixa_texto" size="10" maxlength="10" onkeypress="return numero_inteiro(event)" /></p>
<p><label>Estoque mínimo:</label><input name="min_estoque" type="text" class="caixa_texto" size="10" maxlength="2" onkeypress="return numero_inteiro(event)" /></p>
<p><label>Crédito da imagem:</label><input name="credito" type="text" class="caixa_texto" size="40" maxlength="200" /></p>
<p><input type="image" name="imageField" src="../imagens/btn_salvar.gif" /></p>
</div>
</form>
</body>
</html>
