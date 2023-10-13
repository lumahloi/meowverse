<?PHP
// +---------------------------------------------------------+
// | Forma de pagamento                                      |
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
$sql .= " WHERE num_ped = '" . $_SESSION['num_ped'] . "' ";
$sql .= " ORDER BY id ";
$rs = mysqli_query($conexao, $sql);


// recupera uf do cliente
$sql = " SELECT * FROM tb_estados ";
$sql .= "WHERE uf = '" . $_SESSION['uf'] . "' ";
$rs2 = mysqli_query($conexao, $sql);
$reg2 = mysqli_fetch_array($rs2);
$nome_uf = $reg2['nome'];
$frete = $reg2['frete'];

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
    <title>Faça um Site - PHP 5 com Banco de Dados MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
	<script language="javascript">
		function valida_form() {
			if (document.pag.form_pag[0].checked == false && document.pag.form_pag[1].checked == false && document.pag.form_pag[2].checked == false && document.pag.form_pag[3].checked == false && document.pag.form_pag[4].checked == false) {
				alert('Por favor, selecione uma opção de pagamento.');
				return false;
			}
			if (document.pag.form_pag[0].checked == false || (document.pag.form_pag[1].checked == true && document.pag.form_pag[2].checked == true && document.pag.form_pag[3].checked == true && document.pag.form_pag[4].checked == true)) {
				if (document.pag.txtnome.value == "") {
					alert("Por favor, preencha o campo [Nome impresso no cartão].");
					pag.txtnome.focus();
					return false;
				}
				if (document.pag.txtmes.value == "") {
					alert("Por favor, preencha o campo [Mês] da data de validade do cartão.");
					pag.txtmes.focus();
					return false;
				}
				if (document.pag.txtano.value == "") {
					alert("Por favor, preencha o campo [Ano] da data de validade do cartão.");
					pag.txtano.focus();
					return false;
				}
				if (document.pag.txtcodigo.value == "") {
					alert("Por favor, preencha o campo [Código de segurança].");
					pag.txtcodigo.focus();
					return false;
				}
			}
			return true;
		}
	</script>
</head>

<body>
	<div class="container">
		<a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" border="0" /></a>

		<h3 class="mt-3">Etapa 3 <img src="imagens/marcador_setaDir.gif"/> Pagamento</h3>

		<p class="text-end">Número do pedido: <?PHP print $_SESSION['num_ped']; ?></p>

		<!-- rodape da página -->

			<div class="container">
				<h3>Seu pedido</h3>
				<p>* Antes de confirmar seu pagamento, confira as informações contidas nessa tela. Se você desejar alterá-lo agora, clique em "Alterar esse pedido".</p><br />
				
				<table class="table">
					<thead>
						<tr>
							<th>Descrição do Produto</th>
							<th>Quantidade</th>
							<th>Preço unitário R$</th>
							<th>Total R$</th>
						</tr>
					</thead>
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
						$subtotal_boleto = $subtotal_boleto +$preco_total_boleto;
					?>

					<tbody>
						<tr>
							<td><?PHP print $codigo; ?> - <?PHP print $nome; ?></td>
							<td><?PHP print $qt; ?></td>
							<td>R$ <?PHP print number_format($preco, 2, ',', '.'); ?></td>
							<td>R$ <?PHP print number_format($preco_total, 2, ',', '.'); ?></td>
						</tr>

					<?PHP
					}
					// total para cartão de crédito
					$valor_frete = $peso_pac * $frete;
					$total_pag = $subtotal + $valor_frete;
					// total para boleto bancário
					$total_pag_boleto = $subtotal_boleto + $valor_frete;
					?>

						<tr>
							<th colspan="3">Subtotal</td>
							<td>R$ <?PHP print number_format($subtotal, 2, ',', '.'); ?></td>
						</tr>

						<tr>
							<th colspan="3">Frete</th>
							<td>R$ <?PHP print number_format($valor_frete, 2, ',', '.'); ?></td>
						</tr>

						<tr>
							<td colspan="3"><h4>Total a pagar</h4></td>
							<td><h4>R$ <?PHP print number_format($total_pag, 2, ',', '.'); ?></h4></td>
						</tr>
					</tbody>
				</table>

				<div class="row">
						<div class="col-md-10"></div>
						<div class="col-md-2 text-end">
							<a href="cesta.php"><button class="btn btn-secondary">Alterar esse pedido</button></a>
						</div>
				</div>

				<h4 class="mt-5 mb-3">Local de entrega</h4>
				<div class="row row-cols-2 bg-light border p-3">
							<div class="col-md-10">
								<div class="row">
									<p><?PHP print ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']); ?></p>
								</div>
								<div class="row">
									<p><?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . " " . ltrim($_SESSION['bairro']) . " - " . ltrim($_SESSION['cidade']) . " - " . ltrim($_SESSION['uf']); ?></p>
								</div>
							</div>
							<div class="col-md-2 text-end">
								<a href="cadastro.php?txtemail2=<?PHP print $_SESSION['email_cli']; ?>"><button class="btn btn-secondary">Alterar endereço</button></a>
							</div>
				</div>
						
				<!-- Informações gerais do pedido -->
				<?PHP
					$_SESSION['valor_boleto'] = $total_pag_boleto;				// Valor da fatura com boleto bancário
					$_SESSION['valor'] = $subtotal;												// Valor da fatura com cartão de credito
					$_SESSION['valor_frete'] = $valor_frete;							// Valor do frete
					$_SESSION['peso'] = $peso_pac;												// Peso do pacote
					$_SESSION['dataped'] = date("Y-m-d");									// Data do pedido
					$_SESSION['horaped'] = date("H:i:s");									// Hora do pedido
					$data_futura = strtotime("5 days");										// Número de dias para pag do boleto
					$_SESSION['datavenc'] = date("Y-m-d", $data_futura);	// data de vencimento
					$_SESSION['desconto'] = $subtotal - $subtotal_boleto	// Valor do desconto
				?>
								
			<form name="pag" method="post" action="pagamento1.php" onsubmit="return valida_form(this);">
				<h4 class="mt-5 mb-3">Formas de pagamento</h4>
				<div class="border bg-light p-3">
					<!-- Pagamento com boleto bancário -->
					<div class="container">
							<div class="row">
								<h2><strong>Opção 1:</strong> Quero pagar este pedido por intermédio de <strong>BOLETO BANCÁRIO</strong></h2>
							</div>
							<div class="row row-cols-2">
								<div class="col-md-4">
									<p style="font-weight:bold;">Selecione esta opção para pagar por intermédio de boleto bancário</p>
									<input name="form_pag" type="radio" value="boleto" /><img src="imagens/marcador_boleto.gif" alt="codigo de barras" hspace="3" align="absmiddle" /> (Boleto bancário)
								</div>
								<div class="col-md-8">
									<p>Valor da fatura para pagamento com boleto bancário: <span style="font-weight: bold">R$ <?PHP print number_format($total_pag_boleto, 2, ',', '.'); ?></span></p>
									<p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" align="left" />O boleto deve ser impresso após a confirmação do pedido, pois não o enviamos via correio. </p>
									<p><small>A data de vencimento do boleto é de 5 dias corridos após o fechamento do pedido, após esta data, ele perderá a validade. Na impossibilidade de imprimi-lo, faça o pagamento do boleto pelo Home Banking de seu banco. Para isso, utilize o código de barras localizado na parte superior esquerda da ficha de compensação do boleto. Não é possível pagar o seu pedido através de DOC, transferência ou depósito para conta indicada neste boleto.</small></p>
									<div class="row text-end"><a href="cesta.php"><button class="btn btn-success">Confirmar forma de pagamento</button></a></div>
								</div>
							</div>
					</div> <!-- boleto--->

					<div class="container mt-5">
						<h2><strong>Opção 2:</strong> Quero pagar este pedido por intermédio de <span class="c_preto"><strong>CARTÂO DE CRÉDITO</strong></span></h2>

						<div class="row row-cols-2">
								<div class="col-md-4">
									<p style="font-weight: bold">Selecione um cartão de crédito</p>
									<input name="form_pag" type="radio" value="Visa" /><img src="imagens/c_visa.gif" width="25" height="16" hspace="7" align="absmiddle" />(Visa)<br />
									<input name="form_pag" type="radio" value="Mastercard" /><img src="imagens/c_mastercard.gif" width="25" height="16" hspace="7" align="absmiddle" />(Mastercard)<br />
									<input name="form_pag" type="radio" value="Amex" /><img src="imagens/c_amex.gif" width="25" height="16" hspace="7" align="absmiddle" />(Amex)<br />
									<input name="form_pag" type="radio" value="Diners" /><img src="imagens/c_diners.gif" width="25" height="16" hspace="7" align="absmiddle" />(Diners)<br />
								</div>
								<div class="col-md-8">
									<p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" align="left" />é necessário um cartão de crédito válido (Visa, Mastercard, Amex ou Diners). Para sua segurança, usamos a tecnologia SSL (Secure Socket Layer) para proteger as informações de seu cartão. </p>
									<p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" align="left" />Para sua segurança desabilitamos o campo [N° do cartão] para a demonstração deste site.</p>
									<p style="font-weight: bold">Informações sobre o seu cartão de crédito</p>
									<div class="border p-3">
										<form>
											<div class="form-group">
												<p><label>N° do cartão:</label><input name="txtnumero" type="text" class="caixa_texto" value="5432154321123" size="20" maxlength="20" readonly="true" /> (Desabilitado no modo de teste)</p>
												<p><label>Nome imp no cartão:</label><input name="txtnome" type="text" class="caixa_texto" size="40" maxlength="40" /> * (Seu nome impresso no cartão)</p>
												<p><label>Data de validade:</label><input name="txtmes" type="text" class="caixa_texto" size="3" maxlength="2" />&nbsp;/&nbsp;<input name="txtano" type="text" class="caixa_texto" size="3" maxlength="2" /> * (mm/aa)</p>
												<p><label>Código de segurança:</label><input name="txtcodigo" type="text" class="caixa_texto" size="5" maxlength="4" /></p>
												<p class="text-muted"><small>O Código de Segurança do Cartão é um código de 3 ou 4 dígitos gravado ou impresso no verso dos cartões Visa, MasterCard, Diners. No cartão Amex este código se encontra na frente do cartão.</small></p>

												<table class="table table-borderless table-sm table-striped">
													<thead>
														<th colspan="2" class="text-center">Selecione o número de parcelas:</th>
													</thead>
													<tbody>
														<!-- Exibe o número de parcelas permitidas para pagamento com cartão de crédito -->
														<?PHP for ($contador = 1; $contador <= $_SESSION['max_parcelas']; $contador++) { ?>
															<?PHP if ($contador == 1) {
															$chk = "checked='checked'";
															} else {
																$chk = "";
															} ?>
															<?PHP if ($contador % 2 == 1) { ?>

															<tr>
																<td><input name="txtparcelas" type="radio" value="<?PHP print $contador; ?>" <?PHP print $chk; ?> />
																<?PHP print $contador; ?> x de<span class="c_preto"><strong> R$ <?PHP print number_format($total_pag / $contador, 2, ',', '.'); ?></strong></span> sem juros <br /></td>

																<?PHP } else { ?>

																	<td><input name="txtparcelas" type="radio" value="<?PHP print $contador; ?>" <?PHP print $chk; ?> />
																	<?PHP print $contador; ?> x de<span class="c_preto"><strong> R$ <?PHP print number_format($total_pag / $contador, 2, ',', '.'); ?></strong></span> sem juros <br /></td>
															</tr>
															<?PHP
															}  // Encerra o Else
														}  // Encerra o for
														?>
													</tbody>
												</table>
											</div>
										</form>
								    </div>
								<div class="row text-end mt-3"><a href="cesta.php"><button class="btn btn-success">Confirmar forma de pagamento</button></a></div>
						</div>
					</div><!-- credito--->

				</div> <!-- pagamento -->	
			</div> <!-- fecha div do form-->
		</form>

		<?PHP include "inc_rodape.php" ?>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</div> <!--fecha container principal-->
</body>
</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rs2);
mysqli_close($conexao);
?>