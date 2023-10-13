<?PHP
// +---------------------------------------------------------+
// | Pagamento com cartão de crédito                         |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+~
SESSION_START();
include "inc_dbConexao.php";
// Captura os itens da cesta
$sql = "SELECT * FROM itens ";
$sql .= "WHERE num_ped = '" . $_SESSION ['num_ped'] . "' ";
$sql .= "ORDER BY id ";

//echo $sql;
//exit;
$rs = mysqli_query($conexao, $sql);

// Atualiza a tabela de pedidos
$sqlp = "UPDATE pedidos SET ";
$sqlp .= "id_cliente = '" . $_SESSION['id_cli'] . "', ";
$sqlp .= "status = 'Aguardando aprovação do cartão', ";
$sqlp .= "data = '" . $_SESSION['dataped'] . "', ";
$sqlp .= "hora = '" . $_SESSION['horaped'] . "', ";
$sqlp .= "valor = '" . $_SESSION['valor'] . "', ";
$sqlp .= "vencimento = '" . $_SESSION['datavenc'] . "', ";
$sqlp .= "frete = '" . $_SESSION['valor_frete'] . "', ";
$sqlp .= "peso = '" . $_SESSION['peso'] . "', ";
$sqlp .= "desconto = '0', "; 
$sqlp .= "formpag = 'C', ";
$sqlp .= "cartao = '" . $_SESSION['nome_cartao'] . "', ";
$sqlp .= "num_cartao = '" . $_SESSION['c_numero'] . "', ";
$sqlp .= "venc_cartao = '" . $_SESSION['c_mes'] . $_SESSION['c_ano'] . "', ";
$sqlp .= "nome_cartao = '" . $_SESSION['c_nome'] . "', ";
$sqlp .= "cods_cartao = '" . $_SESSION['c_codigo'] . "', ";
$sqlp .= "parcelas = '" . $_SESSION['c_parcelas'] . "' ";
$sqlp .= " WHERE num_ped = '" . $_SESSION['num_ped'] . "' ";

//echo $sql;
//exit;
mysqli_query($conexao, $sqlp);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça um Site - PHP 5 com Banco de Dados MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">
	<a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" /></a>

	<h3>Etapa 4 <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> Confirmação do seu pedido <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> Pagamento com Cartão de Crédito</h3>
	<p class="text-end">Número do seu pedido: <?PHP print $_SESSION['num_ped']; ?></p>

	<div class="container">
		<h4>Instruções para pagamento</h4>
		<div class="container bg-light border mt-3 mb-5 p-3">
			<p>Obrigado por comprar em nossa loja. Seu pedido foi aceito e está aguardando aprovação da operadora do Cartão de Crédito. Após recebermos a confirmação de pagamento, nós lhe enviaremos um e-mail de notificação confirmando a entrega do pedido.</p>
		</div>

		<h4 class="mt-4">Informações gerais sobre sua compra</h4>
		<div class="container border p-3 mt-3 mb-3">
				<h5>Resumo do pedido</h5>

				<div class="row row-cols-2 p-3">
					<div class="col-md-4">
						<p><strong>Pagamento efetuado por intermédio do cartão de crédito</strong>: <?PHP print $_SESSION['nome_cartao']; ?></p>
						<p><strong>N° de parcelas</strong>: <?PHP print $_SESSION['c_parcelas']; ?></p>
						<p><strong>Valor da(s) parcela(s)</strong>: R$ <?PHP print number_format(($_SESSION['valor'] . $_SESSION['c_parcelas']),2,',','.'); ?></p>
						<p><span style="font-weight:bold;">Data do pedido</span>: <?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?></p>
						<p><span style="font-weight:bold;">Vencimento</span>: <?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?></p>
						<p><span style="font-weight:bold;">Peso</span>: <?PHP print $_SESSION['peso']; ?> Kg</p>
						<p><span style="font-weight:bold;">Forma de pagamento: Cartão de crédito</p>
						<p><span style="font-weight:bold;">Status</span>: Aguardando aprovação do cartão</p>
					</div>
					<div class="col-md-8">
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
$valor = number_format($_SESSION['valor'],2,',','.');
$email_cli = $_SESSION['email_cli'];

$assunto = "Confirmação do seu pedido";

$msg = "***** TESTE DO LIVRO - FAÇA UM SITE PHP COM MYSQL - COMÉRCIO ELETÔNICO\n\n";
$msg = $msg . "Olá\t$nome\n";
$msg = $msg . "Agradecemos sua preferência pelo Faça um Site Miniaturas.\n\n";
$msg = $msg . "A confirmação de seu pedido N° \t$num_ped, no valor total de R$ \t$valor foi realizada com sucesso.\n\n";
$msg = $msg . "Para acompanhar este pedido visite nosso site e selecione a opção 'Meus pedidos'\n\n";
$msg = $msg . "Atenciosamente.\n";
$msg = $msg . "Faça um Site Miniaturas.\n\n";

$cabecalho = "From: Faça um Site <email@remetente.com.br>\n";

mail($email_cli, $assunto, $msg, $cabecalho);
?>

<?PHP $_SESSION['num_ped1'] = $_SESSION['num_ped'] ?>
<?PHP $_SESSION['num_ped'] = "" ?>
<?PHP $_SESSION['total_itens'] = 0 ?>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close ($conexao);
?>