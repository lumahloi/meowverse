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

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

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

$num_ped = $_SESSION['num_ped'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meowverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
	<div class="container">
		<a href="index.php"><img src="imagens/logo.png" alt="Faça um Site" /></a>

		<h3>Etapa 4 <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> Confirmação do seu pedido <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> Pagamento com Boleto Bancário</h3>
		<p class="text-end">Número do seu pedido: <?PHP print $_SESSION['num_ped']; ?></p>

		<div class="container">
			<h4>Instruções para pagamento</h4>
			<div class="container bg-light border mt-3 mb-5 p-3">
				<p>Obrigado por comprar em nossa loja. Seu pedido foi aceito e está aguardando pagamento. Por favor, clique no botão abaixo, imprima o boleto bancário e pague em qualquer banco. Se preferir, pague por intermédio do Internet Banking. Para isso, utilize o <strong>código de barras </strong>localizado na parte superior direita da ficha de compensação do boleto.</p>
				<p><img src="imagens/marcador_atencao.gif" width="20" height="15"  />Após recebermos a confirmação de pagamento, nós lhe enviaremos um e-mail de notificação confirmando a entrega do pedido.</p>
				<p><img src="imagens/marcador_atencao.gif" width="20" height="15"  />A data de vencimento do boleto é de <strong>5 (cinco)</strong> dias após o fechamento do pedido. ATENÇÃO:<strong>Não pague após o vencimento</strong>. Após esta data o pedido será cancelado e o boleto perderá a validade.</p>
				<div class="row text-end"><a href="emitir_boleto.php"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Imprimir boleto</button></a></div>
			</div>

			<h4 class="mt-4">Informações gerais sobre sua compra</h4>
			<div class="container border p-3 mt-3 mb-3">
				<h5>Resumo do pedido</h5>

				<div class="row row-cols-2 p-3">
					<div class="col-md-4 col-12">
						<p><span style="font-weight:bold;">Data do pedido</span>: <?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?></p>
						<p><span style="font-weight:bold;">Vencimento</span>: <?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?></p>
						<p><span style="font-weight:bold;">Peso</span>: <?PHP print $_SESSION['peso']; ?> Kg</p>
						<p><span style="font-weight:bold;">Forma de pagamento</span>: Boleto bancário</p>
						<p><span style="font-weight:bold;">Status</span>: Aguardando pagamento do boleto</p>
					</div>
					<div class="col-md-8 col-12">
						<table class="table table-striped">
							<thead>
								<th>Descrição do produto</th>
								<th>Quantidade</th>
								<th>Preço unitário R$</th>
								<th>Total R$</th>
							</thead>

							<tbody>
								<?PHP
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
											<td><?PHP print $codigo; ?> - <?PHP print $nome; ?></td>
											<td><?PHP print $qt; ?></td>
											<td>R$ <?PHP print number_format($preco, 2, ',', '.'); ?></td>
											<td>R$ <?PHP print number_format($preco_total, 2, ',', '.'); ?></td>
										</tr>
									<?PHP
									}
									?>

								<tr>
									<td colspan="3"><span style="font-weight:bold;">Subtotal</span></td>
									<td><strong>R$ <?PHP print number_format($subtotal, 2, ',', '.'); ?></strong></td>
								</tr>
								
								<tr>
									<td colspan="3"><span style="font-weight:bold;">Desconto para pagamento com boleto bancário</span> </td>
									<td><strong class="c_preto">R$ -<?PHP print number_format(($_SESSION['desconto_boleto']), 2, ',', '.'); ?></strong></td>
								</tr>

								<tr>
									<td colspan="3"><strong>Frete</strong></td>
									<td><strong>R$ <?PHP print number_format($_SESSION['valor_frete'], 2, ',', '.'); ?></strong></td>
								</tr>

								<tr>
									<td colspan="3"><h3>Total da fatura </h3></td>
									<td><h3>R$ <?PHP print number_format($_SESSION['valor_boleto'], 2, ',', '.'); ?></h3></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
				
			<h4 class="mt-4">Informações para envio de sua compra</h4>
			<div class="container border p-3 mt-3 mb-3">
				<p>Nome do comprador: <strong class="c_laranja"><?PHP print $_SESSION['nome_cli']; ?></strong></p>

				<p>E-mail: <strong class="c_laranja"><?PHP print $_SESSION['email_cli']; ?></strong></p>

				<p><?PHP print ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']); ?><br /><?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . " " . ltrim($_SESSION['bairro']) . " - " . ltrim($_SESSION['cidade']) . " - " . ltrim($_SESSION['uf']); ?></p>

				<p><strong>* E-mail de confirmação:</strong> se você não receber um e-mail de confirmação do pedido em breve, verifique sua pasta/diretório de spam ou e-mails indesejados (junk folder) na sua caixa de correio eletrônico. Se encontrar o e-mail em uma dessas pastas, seu provedor da Internet, bloqueador de spam ou software de filtragem está redirecionando as nossas mensagens.</p>

				<p><strong>* Status do pedido:</strong> você pode acompanhar o status do seu pedido, bem como visualizar todas as suas informações, clicando no botão "Meus pedidos" que se encontra na parte superior desse site.</p>
			</div>
		</div>
		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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