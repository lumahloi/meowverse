<?PHP
// +---------------------------------------------------------+
// | Carrinho de compras                                     |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

include "inc_dbConexao.php";

SESSION_START();

// Recupera valores passados pela página detalhes.php
// onde produto = código do produto selecionado
// inserir = S - adicionado ao botão comprar da página detalhes.php

$produto = $_GET['produto'];
$inserir = $_GET['inserir'];
// qt = 1, default para quantidade  por produto passado pelo campo  desta página
$qt = "1";

// Captura o último id de tabela de pedidos
$sql = "SELECT id, status ";
$sql .= " FROM pedidos ";
$sql .= " ORDER by id DESC ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$id_ped = $reg["id"];
$status = $reg["status"];

// Insere um registro na tabela de pedidos
if ($_SESSION['num_ped'] == '' and $inserir == "S") {
	// Incrementa 1 ao último id 
	$id_ped = $id_ped + 1;
	// prepara o número do pedido (id do pedido, hora e primeiro digito do minuto)
	$num_ped = $id_ped . "." . date("H") . substr(date("i"), 0, 1);
	$_SESSION['num_ped'] = $num_ped;
	$_SESSION['id_ped'] = $id_ped;

	// Número do boleto = número do pedido sem separador de milhar
	$SESSION['num_boleto'] = $id_ped . date("H") . substr(date("i"), 0, 1);

	$sqli = "INSERT INTO pedidos";
	$sqli .= " (num_ped, status) ";
	$sqli .= " VALUES('$num_ped','Em andamento') ";
	$rs = mysqli_query($conexao, $sqli);
	
	$_SESSION['status'] = 'Em andamento';
}

// Excluir itens do carrinho
$excluir = $_GET['excluir'];
$id = $_GET['id'];

if ($excluir = "S") {
	$sqld = " DELETE FROM itens ";
	$sqld .= "WHERE id = '" . $id . "' ";

	//echo $sqld;
	//exit;

	mysqli_query($conexao, $sqld);
}

// Captura dados do produto selecionado
$sql = "SELECT id, codigo, nome, preco, desconto, peso, desconto_boleto ";
$sql .= " FROM miniaturas ";
$sql .= " WHERE codigo = '" . $produto . "' ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);

$codigo = $reg["codigo"];
$nome = $reg["nome"];
$preco = $reg["preco"];
$peso = $reg["peso"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$preco_desconto = $preco - ($preco * $desconto / 100);
$preco_boleto = $preco_desconto - ($preco_desconto * $desconto_boleto / 100);

$num_ped = $_SESSION['num_ped'];

// Verifica se o item já se encontra no carrinho
$sqld = "SELECT codigo ";
$sqld .= "FROM itens ";
$sqld .= "WHERE codigo = '" . $produto . "' ";
$sqld .= "AND num_ped = '" . $num_ped . "' ";

$rsd = mysqli_query($conexao, $sqld);
// Se nenhum registro for encontrado, $item_duplicado será igual a 0; caso contrario, será igual a 1
$item_duplicado = mysqli_num_rows($rsd);

// Adiciona o produto à tabela de itens somente se $item_duplicado for igual a 0 
if ($item_duplicado == 0 and $inserir == "S"){
	$sqli = "INSERT into itens";
	$sqli .= "(num_ped,codigo,nome,qt,preco,peso,preco_boleto,desconto,desconto_boleto) ";
	$sqli .= "VALUES('$num_ped','$codigo','$nome','$qt','$preco','$peso','$preco_boleto','$desconto','$desconto_boleto') ";
	
	mysqli_query($conexao, $sqli);
}

// Atualiza itens do carrinho de acordo com os valores digitados no campo "Quatidade" de cada item
for ($contador = 1; $contador <= $_SESSION['total_itens']; $contador++) {
	$b[$contador] = $_POST['txt' . $contador];
	$c[$contador] = $_POST['id' . $contador];

	$sqla = "UPDATE itens ";
	$sqla .= "SET qt = '" . $b[$contador] . "' ";
	$sqla .= "WHERE id = '" . $c[$contador] . "' ";

	//echo $sqla;
	//exit;
	mysqli_query($conexao, $sqla);
}

// Captura os itens adicionados ao carrinho para serem exibidos na página
$sql = "SELECT * ";
$sql .= " FROM itens ";
$sql .= " WHERE num_ped = '" . $num_ped . "' ";
$sql .= " ORDER BY id ";

//echo $sql;
//exit;
$rs = mysqli_query($conexao, $sql);
$total_itens = mysqli_num_rows($rs);
$_SESSION['total_itens'] = $total_itens;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
	<link href="estilo_site.css" rel="stylesheet" type="text/css" />
	<script language="javascript">
		function valida_form() {
			<?PHP for ($contador = 1; $contador <= $_SESSION['total_itens']; $contador++) { ?>
				if (document.cesta.txt<?PHP print $contador; ?>.value < 1) {
					alert("O campo quantidade não pode ser menor do que 1.");
					document.cesta.txt<?PHP print $contador; ?>.focus();
					return false;
				}
				if (document.cesta.txt<?PHP print $contador; ?>.value > 10) {
					alert("O campo quantidade não pode conter mais de 10 itens.");
					document.cesta.txt<?PHP print $contador; ?>.focus();
					return false;
				}
			<?PHP } ?>
			return true;
		}
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

		<?PHP if ($_SESSION['num_ped'] == "") { ?>
			<div id="caixa">
				<table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							<h1 class="c_vermelho">Seu carrinho está vazio </h1>
							<p class="c_vermelho"><a href="index.php"><img src="imagens/btn_voltarLoja.gif" alt="Voltar &agrave; loja" width="109" height="19" vspace="3" border="0" /></a></p>
						</td>
					</tr>
				</table>
			</div>
		<?PHP } else { ?>

			<!-- Exibe título da página e número do pedido caso existam produtos no carrinho -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="59%">
						<h1>Meu carrinho de compras</h1>
					</td>
					<td width="41%">
						<div align="right">Número do seu pedido: <span class="num_pedido"><?PHP print $_SESSION['num_ped']; ?></span></div>
					</td>
				</tr>
			</table>

			<!-- Exibe os itens no carrinho -->
			<form name="cesta" method="post" action="cesta.php" onsubmit="return valida_form(this);">
				<!-- Exibe os itens incluidos do carrinho -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="caixa_cesta_tit">Descrição do produto </td>
						<td width="10%" class="caixa_cesta_tit">
							<div align="center">Quantidade</div>
						</td>
						<td width="10%" class="caixa_cesta_tit">
							<div align="center">Excluir item</div>
						</td>
						<td width="15%" align="right" class="caixa_cesta_tit">Preço unitário R$ </td>
						<td width="15%" align="right" class="caixa_cesta_tit">Total R$ </td>
					</tr>

					<?PHP
					$subtotal = 0;
					$n = 0;
					while ($reg = mysqli_fetch_array($rs)) {
						$n = $n + 1;
						$id = $reg["id"];
						$codigo = $reg["codigo"];
						$nome = $reg["nome"];
						$qt = $reg["qt"];
						$preco_unitario = $reg["preco"];
						$peso = $reg["peso"];
						$preco_total = $preco_unitario * $qt;
						$subtotal = $subtotal + $preco_total;
					?>
						<tr>
							<td class="caixa_cesta_item"><img src='imagens/<?PHP print $codigo; ?>.jpg' width='53' height='32' align="absmiddle" />&nbsp;&nbsp;&nbsp;<?PHP print $codigo; ?> - <?PHP print $nome; ?></td>
							<td class="caixa_cesta_item">
								<div align="center"><input name="txt<?PHP print $n; ?>" value="<?PHP print $qt; ?>" type="text" size="2" maxlength="6" class="caixa_texto" /></div>
							</td>
							<td class="caixa_cesta_item">
								<div align="center"><a href="cesta.php?id=<?PHP print $id ?>&excluir=S"><img src='imagens/btn_removerItem.gif' alt='Comprar' hspace='5' border='0' /></a></div>
							</td>
							<td align="right" class="caixa_cesta_item">R$ <?PHP print number_format($preco_unitario, 2, ',', '.'); ?></td>
							<td align="right" class="caixa_cesta_item">R$ <?PHP print number_format($preco_total, 2, ',', '.'); ?></td>
							<!-- Armazena id e código do item nos campos ocultos para serem capturados pelo POST do formulário -->
							<input type=hidden name="id<?PHP print $n; ?>" value="<?PHP print $id; ?>">
							<input type=hidden name="cod<?PHP print $n; ?>" value="<?PHP print $codigo; ?>">
						</tr>
					<?PHP
					}
					?>

					<tr>
						<td colspan="3" class="caixa_cesta_total">* O valor total da sua compra não inclui o frete, ele será calculado no fechamento do seu pedido.</td>
						<td align="right" class="caixa_cesta_total">Subtotal</td>
						<td align="right" class="caixa_cesta_total">R$ <?PHP print number_format($subtotal, 2, ',', '.'); ?></td>
					</tr>

					<!-- Exibe os botões de opções da página -->
					<tr>
						<td colspan="4" class="caixa_cesta_btn">
							<a href="index.php"><img src="imagens/btn_comprarMais.gif" border="0" /></a>
							<input name="imageField" type="image" src="imagens/btn_atualizarValores.gif" />
						</td>
						<td class="caixa_cesta_btn">
							<div align="right"><a href="login.php"><img src="imagens/btn_fecharPedido.gif" alt="Fechar pedido" width="109" height="19" border="0" /></a></div>
						</td>
					</tr>
				</table>
			</form>
		<?PHP } ?>

		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rsd);
mysqli_close($conexao);
?>