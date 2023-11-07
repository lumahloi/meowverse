<?PHP
// +---------------------------------------------------------+
// | Detalhes da miniatura                                   |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";


// Recupera o produto (método POST) passado por index.php, categorias.php e pesquisa.php

$produto = $_GET['produto'];

$sql = " SELECT categorias.cat_nome, miniaturas.* FROM categorias ";
$sql .= "INNER JOIN miniaturas ";
$sql .= "ON categorias.id = miniaturas.id_categoria ";
$sql .= "WHERE miniaturas.codigo = '" . $produto . "' ";

//echo $mysqli;
//exit;
$rs = mysqli_query($conexao,$sql);
$reg = mysqli_fetch_array($rs);

// Carrega as variaveis com os valores dos campos
$codigo = $reg["codigo"];
$nome = $reg["nome"];
$ano = $reg["ano"];
$nome_cat = $reg["nome_cat"];
$cat_sub = $reg["cat_sub"];
$preco = $reg["preco"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$max_parcelas = $reg["max_parcelas"];
$escala = $reg["escala"];
$peso = $reg["peso"];
$comprimento = $reg["comprimento"];
$largura = $reg["largura"];
$altura = $reg["altura"];
$cor = $reg["cor"];
$estoque = $reg["estoque"];
$min_estoque = $reg["min_estoque"];
$credito = $reg["credito"];
// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio do cartão de credito
$valor_desconto = $preco - ($preco * $desconto / 100);
// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio de boleto bancário
$valor_boleto = $valor_desconto - ($valor_desconto * $desconto_boleto / 100);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
	<link rel="stylesheet" href="style.css">
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

		<!-- Título da página (exibe o nome da categoria) -->
		<h1><span class="c_cinza">Detalhes <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <?PHP print $nome_cat; ?></span> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto"><?PHP print $nome; ?></span></h1>

		<div id="caixa">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="20%" valign="top">
						<!-- Exibe imagem da miniatura com opção de ampliação -->
						<a href="#"><img src="imagens/<?PHP print $codigo; ?>G.jpg" width="200" height="121" border="0" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a><br />
						<a href="#"><img src="imagens/btn_ampliar.gif" border="0" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a><br />

						<h1>Dados Técnicos</h1>
						<table width="100%" border="0" cellspacing="2" cellpadding="0">
							<!-- Exibe detalhes da miniatura -->
							<tr>
								<td width="32%" valign="top" class="data8">
									Código:<br />
									Categoria:<br />
									Tipo:<br />
									Ano:<br />
									Escala:<br />
									Peso<br />
									Cor:<br />
									Dimensões:
								</td>
								<td width="68%" valign="top" class="data8">
									<?PHP print $codigo; ?><br />
									<?PHP print $nome_cat; ?><br />
									<?PHP print $cat_sub; ?><br />
									<?PHP print $ano; ?><br />
									<?PHP print $escala; ?> - Die Caste Models<br />
									<?PHP print number_format($peso, 3, ',', '.'); ?> Kg<br />
									<?PHP print $cor; ?><br />
									(C x L x A): <?PHP print number_format($comprimento, 1, ',', '.'); ?> x <?PHP print number_format($largura, 1, ',', '.'); ?> x <?PHP print number_format($altura, 1, ',', '.'); ?> cm</td>
							</tr>
						</table>
						<p><span class="credito_imagem"><strong>Crédito da imagem</strong>: <?PHP print $credito; ?></span><br /></p>
					</td>
					<td width="80%" valign="top">
						<div id="caixa_detalhes">
							<span class="titulo_miniatura"><?PHP print $nome ?></span>
							<!-- Se a quantidade em estoque for maior que o estoque mínimo exibe o botão com opcão de compra -->
							<?PHP if ($estoque > $min_estoque) { ?>
								<a href="cesta.php?produto=<?PHP print $codigo; ?>&inserir=S"><img src="imagens/btn_comprar.gif" alt="Comprar" hspace="5" border="0" align="right" /></a>
							<?PHP } else { ?>
								<!-- Se a quantidade em estoque for menor que o estoque mínimo exibe banner com produto indisponível -->
								<img src="imagens/btn_comprar_nd.gif" alt="Não disponivel no estoque" hspace="5" border="0" align="right" />
							<?PHP } ?>

							<p><span class="preco_normal">de: R$ <?PHP print number_format($preco, 2, ',', '.'); ?></span><br />
								Por: <span class="destaque_preco"> R$ <?PHP print number_format($valor_desconto, 2, ',', '.'); ?> </span></p>

							<!-- Exibe as opções de parcelamento no cartão de crédito -->
							<h6>Parcelamento no cartão de crédito </h6>
							<!-- Verifica o número máximo de parcelas para compras com mais de mais de um item -->
							<!-- Armazena em $_SESSION['max_parcelas'] o maior número de parcelas entre os vários itens selecionados -->
							<!-- Ex: se um ptem pode ser pago em 4 parcelas e um outro em 6 parcelas o parcelamento da compra será calculado -->
							<!-- pelo maior número de parcelas entre os itens -->
							<?PHP if ($max_parcelas >= $_SESSION['max_parcelas']) {
								$_SESSION['max_parcelas'] = $max_parcelas;
							} ?>

							<!-- Exibe o valor de cada parcela dividindo o valor da miniatura pelo número de parcelas -->
							<!-- O número de parcelas é atribuida à variável $contador -->
							<table width="100%" border="0" cellspacing="2" cellpadding="0">
								<?PHP for ($contador = 1; $contador <= $max_parcelas; $contador++) { ?>
									<?PHP if ($contador % 2 == 1) { ?>
										<tr>
											<td width="50%" valign="top" class="parcelas"><?PHP print $contador; ?> x de R$ <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?> sem juros <br /></td>
										<?PHP } else { ?>
											<td width="50%" valign="top" class="parcelas"><?PHP print $contador; ?> x de R$ <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?> sem juros <br /></td>
										</tr>
								<?PHP
									} // Encerra o Else
								}   // Encerra o for
								?>
							</table>
							<p><span class="data8">* Pague com Boleto Bancário e ganhe + <?PHP print number_format(($desconto_boleto), 0, ',', '.'); ?>% de desconto:<span class="c_preto"> R$ <?PHP print number_format(($valor_boleto), 2, ',', '.'); ?></span></span></p>
							<p><span class="data8">* Este produto pode ser pago com cartão de crédito em até <span class="c_preto"><?PHP print $max_parcelas; ?></span> parcelas. </span></p>

							<h6>Formas de pagamento</h6>
							<img src="imagens/banner_formapag.gif" alt="formas de pagamento" width="297" height="23" vspace="5" />
							<h6>Prazos de entrega</h6>
							<span class="data8">
								2 dias úteis para o estado de São Paulo. <br />
								5 dias úteis para os demais estados.<br /> </span>

							<h6>Observações</h6>
							<span class="data8">As mercadorias adquiridas serão despachadas, via Sedex(Sedex ou e_Sedex), no primeiro dia útil após a comprovação de pagamento, estando a entrega condicionada à disponibilidade de estoque. Prazo médio de entrega dos Correios: 24 a 72 horas.</span>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?PHP include "inc_rodape.php" ?>
	</div>
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>