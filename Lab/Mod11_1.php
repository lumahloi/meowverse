<?PHP
include "dbConexao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
<link href="estilo2.css" rel="stylesheet" type="text/css" />
<!-- Valida campos do formulário de entrega (usuários já cadastrados) -->


</head>
<body>
<form name="form1" method="post" action="Lab11_1inc.php">
<div id="caixa_cad">
<h1>Inclusão de miniaturas</h1>
<p><label>Código:</label><input name="codigo" type="text" class="caixa_texto" size="5" maxlength="5" /></p>
<p><label>Descrição:</label><input name="nome" type="text" class="caixa_texto" size="40" maxlength="60" /></p>
<p><label>Ano de fabricação:</label><input name="ano" type="text" class="caixa_texto" size="6" maxlength="4" /></p>

<p>
<label>Categoria:</label>
<select name="id_categoria" class="caixa_combo">
<?PHP
// Carrega combo de categorias
$itens_cat = "<option value='0'>-- Selecione uma categoria</option><br /> ";
$sql_cat = "SELECT * FROM categorias ";
$rs_cat = mysql_query($sql_cat, $conexao);
while ($reg_cat = mysql_fetch_array($rs_cat)) {
  $itens_cat = $itens_cat . "<option value='" . $reg_cat['id'] . "'>" . $reg_cat['cat_nome'] . "</option><br /> ";
}
print $itens_cat;
?>
</select>
</p>
	
<p><label>Subcategoria:</label><input name="subcateg" type="text" class="caixa_texto"  size="30" maxlength="30" /></p>
<p><label>Destaque Home Page:</label><input name="destaque" type="text" class="caixa_texto"  size="2" maxlength="1" /></p>
<p><label>Escala:</label><input name="escala" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Peso:</label><input name="peso" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Comprimento:</label><input name="comprimento" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Largura:</label><input name="largura" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Altura:</label><input name="altura" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Cor predominante:</label><input name="cor" type="text" class="caixa_texto" size="20" maxlength="20" /></p>
<p><label>Preço:</label><input name="preco" type="text" class="caixa_texto" size="10" maxlength="20" /></p>
<p><label>Desconto:</label><input name="desconto" type="text" class="caixa_texto" size="10" maxlength="2" /> (em porcentagem)</p>
<p><label>Desconto para boleto:</label><input name="desconto_boleto" type="text" class="caixa_texto" size="10" maxlength="2" /> (em porcentagem)</p>
<p><label>Parcelamento máximo:</label><input name="max_parcelas" type="text" class="caixa_texto" size="10" maxlength="2" /> </p>
<p><label>Em estoque:</label><input name="estoque" type="text" class="caixa_texto" size="10" maxlength="10" /></p>
<p><label>Estoque mínimo:</label><input name="min_estoque" type="text" class="caixa_texto" size="10" maxlength="2"  /></p>
<p><label>Crédito da imagem:</label><input name="credito" type="text" class="caixa_texto" size="40" maxlength="200" /></p>
<p><input type="image" name="imageField" src="../imagens/btn_inserir.gif" /></p>
	
</div>
</form>
</body>
</html>

