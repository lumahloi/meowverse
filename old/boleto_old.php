<?PHP
// +---------------------------------------------------------+
// | Pagamento com boleto bancário                           |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

SESSION_START();
include "inc_dbConexao.php";

// Captura os itens da cesta 
$sql = "SELECT * FROM itens ";
$sql .= "WHERE num_ped = '" . $_SESSION['num_ped'] . "' ";
$sql .= "ORDER BY id ";
$rs = mysqli_query($conexao, $sql);

// Atualiza a tabela de pedidos
$sqlp = "UPDATE pedidos set ";
$sqlp .= "id_cliente = '" . $_SESSION['id_cli'] . "', ";
$sqlp .= "status = 'Aguardando pagamento do boleto', ";
$sqlp .= "data = '" . $_SESSION['dataped'] . "', ";
$sqlp .= "hora = '" . $_SESSION['horaped'] . "', ";
$sqlp .= "valor = '" . $_SESSION['valor'] . "', ";
$sqlp .= "vencimento = '" . $_SESSION['datavenc'] . "', ";
$sqlp .= "frete = '" . $_SESSION['valor_frete'] . "', ";
$sqlp .= "peso = '" . $_SESSION['peso'] . "', ";
$sqlp .= "desconto = '" . $_SESSION['desconto'] . "', ";
$sqlp .= "formpag = 'B', ";
$sqlp .= "cartao = '-', ";
$sqlp .= "num_cartao = '-', ";
$sqlp .= "venc_cartao = '-', ";
$sqlp .= "nome_cartao = '-', ";
$sqlp .= "cods_cartao = '-', ";
$sqlp .= "parcelas = '1' ";
$sqlp .= "WHERE num_ped = '" . $_SESSION['num_ped'] . "';";
//echo $sqlp;
//exit;
mysqli_query($conexao, $sqlp);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Faça um Site - PHP 5 com banco de dados MySQL</title>
	<link rel="stylesheet" href="style.css">
	<script language="javascript">
		function valida_form() {
			if (document.boleto.rdboleto.checked == false) {
				alert("Por favor, selecione a opção [Boleto bancário].");
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
	<div id="corpo">
		<div id="etapa4"><a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" border="0" /></a></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="69%">
					<h1><span class="c_cinza">Etapa 4 <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> Confirmação do seu pedido</span> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_laranja">Pagamento com Boleto Bancário</span> </h1>
				</td>
				<td width="31%">
					<div align="right">Número do seu pedido: <span class="num_pedido"><?PHP print $_SESSION['num_ped']; ?></span></div>
				</td>
			</tr>
		</table>

		<div id="caixa">
			<h4>Instruções para pagamento</h4>
			<p class="c_cinza">Obrigado por comprar em nossa loja. Seu pedido foi aceito e está aguardando pagamento. Por favor, clique no botão abaixo, imprima o boleto bancário e pague em qualquer banco. Se preferir, pague por intermédio do Internet Banking. Para isso, utilize o <span class="c_preto"><strong>código de barras </strong></span>localizado na parte superior direita da ficha de compensação do boleto.</p>
			<p>&nbsp;</p>
			<p class="c_preto"><span class="c_cinza"><img src="imagens/marcador_atencao.gif" width="20" height="15" align="left" />Após recebermos a confirmação de pagamento, nós lhe enviaremos um e-mail de notificação confirmando a entrega do pedido</span>.</p>
			<p>&nbsp;</p>
			<p class="c_cinza"><img src="imagens/marcador_atencao.gif" width="20" height="15" align="left" />A data de vencimento do boleto é de <span class="c_preto"><strong>5 (cinco)</strong></span> dias após o fechamento do pedido. ATENÇÃO: <span class="c_preto"><strong>Não pague após o vencimento</strong></span>. Após esta data o pedido será cancelado e o boleto perderá a validade.</p>
			<p align="right"><a href="emitir_boleto.php"><img src="imagens/btn_imprimirBoleto.gif" vspace="5" border="0" /></a></p>

			
			<h4>Informações gerais sobre sua compra</h4>
			<h2>Resumo do pedido</h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="19%">Data do pedido: <span class="c_laranja"><?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?></span> </td>
					<td width="18%">Vencimento: <span class="c_laranja"><?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?></span></td>
					<td width="11%">Peso: <span class="c_laranja"><?PHP print $_SESSION['peso']; ?></span> Kg</td>
					<td width="25%">Forma de pagamento: <span class="c_laranja">Boleto bancário </span></td>
					<td width="27%">
						<div align="right">Status:<span class="c_laranja"> Aguardando pagamento do boleto </span> </div>
					</td>
				</tr>
			</table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="42%" class="caixa_pedido_item"><strong>Descrição do produto </strong></td>
					<td width="10%" class="caixa_pedido_item">
						<div align="center"><strong>Quantidade</strong></div>
					</td>
					<td width="17%" align="right" class="caixa_pedido_item"><strong>Preço unitário R$ </strong></td>
					<td width="13%" align="right" class="caixa_pedido_item"><strong>Total R$ </strong></td>
				</tr>

				<?php
					$subtotal = 0;
					$n = 0;
					while ($reg = mysqli_fetch_array($rs)) {
						$n = $n + 1;
						$id = $reg["id"];
						$codigo = $reg["codigo"];
						$nome = $reg["nome"];
						$qt = $reg["qt"];
						$preco = $reg["preco"];
						$preco_boleto = $reg["preco_boleto"];
						$peso = $reg["peso"];

						// valores para pagamento com cartão de crédito
						$preco_total = $preco * $qt;
						$subtotal = $subtotal + $preco_total;
						$peso_pac = $peso_pac + ($peso * $qt);

						// valores para pagamento com boleto bancário
						$preco_total_boleto = $preco_boleto * $qt;
						$subtotal_boleto = $subtotal_boleto + $preco_total_boleto;
						$_SESSION['desconto_boleto'] = $subtotal - $subtotal_boleto
				?>

					<tr>
						<td class="caixa_pedido_item"><?PHP print $codigo; ?> - <?PHP print $nome; ?></td>
						<td class="caixa_pedido_item">
							<div align="center"><?PHP print $qt; ?></div>
						</td>
						<td align="right" class="caixa_pedido_item">R$ <?PHP print number_format($preco, 2, ',', '.'); ?></td>
						<td align="right" class="caixa_pedido_item">R$ <?PHP print number_format($preco_total, 2, ',', '.'); ?></td>
					</tr>
				<?php
				}
				?>

				<tr>
					<td colspan="3" class="caixa_pedido_item"><strong>Subtotal</strong></td>
					<td align="right" class="caixa_pedido_item"><strong>R$ <?PHP print number_format($subtotal, 2, ',', '.'); ?></strong></td>
				</tr>
				<tr>
					<td colspan="3" class="caixa_pedido_item">Desconto para pagamento com boleto banc&aacute;rio </td>
					<td align="right" class="caixa_pedido_item"><strong class="c_preto">R$ -<?PHP print number_format(($_SESSION['desconto_boleto']), 2, ',', '.'); ?></strong></td>
				</tr>
				<tr>
					<td colspan="3" class="caixa_pedido_item"><strong>Frete</strong></td>
					<td align="right" class="caixa_pedido_item"><strong>R$ <?PHP print number_format($_SESSION['valor_frete'], 2, ',', '.'); ?></strong></td>
				</tr>
				<tr>
					<td colspan="3" class="caixa_pedido_item">
						<h3>Total da fatura </h3>
					</td>
					<td align="right" class="caixa_pedido_item">
						<h3>R$ <?PHP print number_format($_SESSION['valor_boleto'], 2, ',', '.'); ?></h3>
					</td>
				</tr>
			</table>

			<p>&nbsp;</p>
			<h2>Informações para envio de sua compra</h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>Nome do comprador: <strong class="c_laranja"><?PHP print $_SESSION['nome_cli']; ?></strong></td>
				</tr>
				<tr>
					<td>E-mail: <strong class="c_laranja"><?PHP print $_SESSION['email_cli']; ?></strong></td>
				</tr>
				<tr>
					<td> <span class="c_laranja"><?PHP print ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']); ?></span><br />
						<span class="c_laranja"><?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . " " . ltrim($_SESSION['bairro']) . " - " . ltrim($_SESSION['cidade']) . " - " . ltrim($_SESSION['uf']); ?></span>
					</td>
				</tr>
				<tr>
					<td><span class="c_preto"><strong>* E-mail de confirmação:</strong></span> <span class="c_cinza">se você não receber um e-mail de confirmação do pedido em breve, verifique sua pasta/diretório de spam ou e-mails indesejados (junk folder) na sua caixa de correio eletrônico. Se encontrar o e-mail em uma dessas pastas, seu provedor da Internet, bloqueador de spam ou software de filtragem está redirecionando as nossas mensagens.</span></td>
				</tr>
				<tr>
					<td><span class="c_preto"><strong>* Status do pedido:</strong></span> <span class="c_cinza">você pode acompanhar o status do seu pedido, bem como visualizar todas as suas informações, clicando no botão "Meus pedidos" que se encontra na parte superior desse site. </span></td>
				</tr>
			</table>
		</div>
		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>
</body>

</html>
<?PHP
// Envio de e-mail com a confirmação do pedido
$nome = $_SESSION['nome_cli'];
$num_ped = $_SESSION['num_ped'];
$valor = number_format($_SESSION['valor_boleto'], 2, ',', '.');
$email_cli = $_SESSION['email_cli'];
$link = "http://www.oliviero.com.br/php5/detalhe_ped.php?det_ped=" . $_SESSION['num_ped'];

$assunto = "Confirmação do seu pedido";

$msg = "***** TESTE DO LIVRO - FAÇA UM SITE PHP4 COM MYSQL - COMÉRCIO ELETRÔNICO\n\n";
$msg = $msg . "Olá\t$nome\n";
$msg = $msg . "Agradecemos sua preferência pelo Faça um Site Miniaturas.\n\n";
$msg = $msg . "A confirmação de seu pedido N° \t$num_ped, no valor total de R$ \t$valor foi realizada com sucesso.\n\n";
$msg = $msg . "Você optou em pagar sua compra por intermédio de boleto bancário.\n";
$msg = $msg . "Caso ainda não tenha impresso o referido boleto, clique no link abaixo para efetuar sua impressão.\n\n";
$msg = $msg . "\t$link\n\n";
$msg = $msg . "Para acompanhar este pedido visite nosso site e selecione a opção 'Meus pedidos'\n\n";
$msg = $msg . "Atenciosamente.\n";
$msg = $msg . "Faça um Site Miniaturas.\n\n";

$cabecalho = "From: Faça um Site\n";

mail($email_cli, $assunto, $msg, $cabecalho);
?>
<?PHP $_SESSION['num_ped1'] = $_SESSION['num_ped'] ?>
<?PHP $_SESSION['num_ped'] = "" ?>
<?PHP $_SESSION['total_itens'] = 0 ?>
<?PHP
// Libera os recursos usados pela conexço atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>