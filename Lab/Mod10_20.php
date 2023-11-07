<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Série Faça um Site – PHP 5 com MySQL</title>
</head>

<?PHP
// Inclui a folha de estilo (CSS) com o layout da página 
// este arquivo foi baixado com o kit de trabalho deste livro
// Sua inclusão é opcional
include "estilo1.inc";
?>

<body>
<form method="post" action="Lab10_20R.php">
<h3>Pesquisa de registros na tabela Miniaturas</h3>
<p class="destaque"><strong>Etapa 1</strong> -  Sele&ccedil;&atilde;o dos registros :</p>
  <label>Campo
  <select name="campo">
	  <option value="Id">Id</option>
	  <option value="codigo" selected="selected">Código</option>
	  <option value="nome">Descrição</option>
	  <option value="ano">Ano de fabricação</option>
	  <option value="escala">Escala</option>
	  <option value="cor">Cor</option>
	  <option value="estoque">Quantidade estoque</option>
	  <option value="preco">Preçode venda</option>
	</select>
  </label>
  <label>Operador
	<select name="operador">
		<option value="=" selected="selected">Igual</option>
		<option value=">">Maior que</option>
		<option value=">=">Maior ou igual a</option>
		<option value="<">Menor que</option>
		<option value=">=">Menor ou igual a</option>
		<option value="<>">Diferente de</option>
		<option value="CONTEM">Cont&eacute;m</option>
	</select>
  </label>
  <label>Valor
  <input type="text" name="valor" width="150" />
  <br />
  <br />
  </label>

<p class="destaque"><strong>Etapa 2</strong> -  Ordenação dos registros:</p>	
  <label>Ordenar por
  <select name="ordenar">
	  <option value="Id">Id</option>
	  <option value="codigo" selected="selected">Código</option>
	  <option value="nome">Descrição</option>
	  <option value="ano">Ano de fabricação</option>
	  <option value="escala">Escala</option>
	  <option value="cor">Cor</option>
	  <option value="estoque">Quantidade estoque</option>
	  <option value="preco">Preçode venda</option>
	</select>
  </label>
	<select name="forma_ordem">
		<option value="ASC" selected="selected">Crescente</option>
		<option value="DESC">Decrescente</option>
	</select>
	
	<input type="submit" class="botao" name="Submit" value="Pesquisar" />
</form>
</body>
</html>
