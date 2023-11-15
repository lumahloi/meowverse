<?PHP
SESSION_START();

include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


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

//recupera o id_cliente
$id_cliente = $_SESSION['id_cli'];
$sql = "update pedidos set id_cliente = " . $id_cliente . " where num_ped = '" . $num_ped . "';";
$rs3 = mysqli_query($conexao, $sql);

$num_ped = $_SESSION['num_ped'];

// Número do boleto = número do pedido sem separador de milhar
/*$SESSION['num_boleto'] = $id_ped . date("H") . substr(date("i"), 0, 1);
$sqli = "INSERT INTO pedidos";
$sqli .= " (num_ped, status) ";
$sqli .= " VALUES('$num_ped','Em andamento') ";
$rs = mysqli_query($conexao, $sqli);
$_SESSION['status'] = 'Em andamento';*/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meowverse</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>

    <script language="javascript">
        function valida_form() {
            if (document.pag.form_pag[0].checked == false && document.pag.form_pag[1].checked == false && document.pag.form_pag[2].checked == false && document.pag.form_pag[3].checked == false && document.pag.form_pag[4].checked == false && document.pag.form_pag[5].checked == false) {
                alert('Por favor, selecione uma opção de pagamento.');
                return false;
            }
            /*if (document.pag.form_pag[0].checked == false || (document.pag.form_pag[1].checked == true && document.pag.form_pag[2].checked == true && document.pag.form_pag[3].checked == true && document.pag.form_pag[4].checked == true)) {
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
            }*/
            return true;
        }
    </script>
</head>

<body>
    <div class="site-wrap">
        <?php include "inc_menuSuperior.php" ?>

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <a href="index.php">Home</a>
                        <span class="mx-2 mb-0">/</span>
                        <a href="cesta.php">Carrinho</a>
                        <span class="mx-2 mb-0">/</span>
                        <a href="login.php">Login</a>
                        <span class="mx-2 mb-0">/</span>
                        <a href="login.php">Cadastro</a>
                        <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Pagamento</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <h2 class="h3 mb-3 text-black">Dados Pessoais</h2>
                <p>Antes de confirmar seu pagamento, confira as informações contidas nessa tela. Se você desejar
                    alterá-lo agora, clique em "Alterar esse pedido".</p>

                <div class="p-3 p-lg-5">
                    <p>Número do pedido:
                        <?PHP print $_SESSION['num_ped']; ?>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Descrição do Produto</th>
                                <th>Quantidade</th>
                                <th>Preço unitário R$</th>
                                <th>Total R$</th>
                            </tr>
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
                                $peso = 0.6;
                                // valores para pagamento com cartão de crédito
                                $preco_total = $preco * $qt;
                                $subtotal = $subtotal + $preco_total;
                                $peso_pac = $peso_pac + ($peso * $qt);
                                // valores para pagamento com boleto bancário
                                $preco_total_boleto = $preco_boleto * $qt;
                                $subtotal_boleto = $subtotal_boleto + $preco_total_boleto;
                                ?>
                                <tr>
                                    <td>
                                        <?PHP print $codigo; ?> -
                                        <?PHP print $nome; ?>
                                    </td>
                                    <td>
                                        <?PHP print $qt; ?>
                                    </td>
                                    <td>R$
                                        <?PHP print number_format($preco, 2, ',', '.'); ?>
                                    </td>
                                    <td>R$
                                        <?PHP print number_format($preco_total, 2, ',', '.'); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <?PHP
                            }
                            // total para cartão de crédito
                            $valor_frete = $peso_pac * $frete;
                            $total_pag = $subtotal + $valor_frete;
                            // total para boleto bancário
                            $total_pag_boleto = $subtotal_boleto + $valor_frete;
                            ?>
                                <th colspan="3">Subtotal</td>
                                <td>R$
                                    <?PHP print number_format($subtotal, 2, ',', '.'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th colspan="3">Frete</th>
                                <td>R$
                                    <?PHP print number_format($valor_frete, 2, ',', '.'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <h4>Total a pagar</h4>
                                </td>
                                <td>
                                    <h4>R$
                                        <?PHP print number_format($total_pag, 2, ',', '.'); ?>
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row justify-content-md-end mt-5">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-block py-3"
                                onclick="window.location='cesta.php'">Alterar esse pedido</button>
                        </div>
                    </div>



                </div>



                <h2 class="h3 mb-3 text-black mt-5">Local de entrega</h2>
                <div class="p-3 p-lg-5 border">
                    <p>
                        <?PHP print ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']); ?>
                    </p>
                    <p>
                        <?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . " " . ltrim($_SESSION['bairro']) . " - " . ltrim($_SESSION['cidade']) . " - " . ltrim($_SESSION['uf']); ?>
                    </p>
                    <div class="row justify-content-md-end mt-5">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-block py-3"
                                onclick="window.location='cadastro.php?txtemail2=<?PHP print $_SESSION['email_cli']; ?>'">Alterar
                                endereço</button>
                        </div>
                    </div>
                </div>

                <!-- Informações gerais do pedido -->
                <?PHP
                $timezone = isset($_SESSION['time']) ? $_SESSION['time'] : 'America/Sao_Paulo';
                $dt = new DateTime("now", new DateTimeZone($timezone));
                
                $_SESSION['dataped'] = $dt->format('Y-m-d');
                $_SESSION['horaped'] = $dt->format('H:i:s');

                $_SESSION['valor_boleto'] = $total_pag_boleto; // Valor da fatura com boleto bancário
                $_SESSION['valor'] = $subtotal; // Valor da fatura com cartão de credito
                $_SESSION['valor_frete'] = $valor_frete; // Valor do frete
                $_SESSION['peso'] = $peso_pac; // Peso do pacote
                //$_SESSION['dataped'] = date("d-m-Y"); // Data do pedido
                //$_SESSION['horaped'] = date("H:i:s"); // Hora do pedido
                $data_futura = strtotime("5 days"); // Número de dias para pag do boleto
                $_SESSION['datavenc'] = date("Y-m-d", $data_futura); // data de vencimento
                $_SESSION['desconto'] = $subtotal - $subtotal_boleto // Valor do desconto
                    ?>


                <form name="pag" method="post" action="pagamento1.php" onsubmit="return valida_form(this);">
                    <h2 class="h3 mb-3 text-black mt-5">Pagar com PIX</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="row row-cols-2">
                            <div class="col-md-4 col-12">
                                <p style="font-weight:bold;">Selecione esta opção para pagar por intermédio de
                                    PIX</p>
                                <input name="form_pag" type="radio" value="pix" /><img
                                    src="imagens/pix.png" alt="codigo de barras" hspace="3" width="40" height="40"/> (PIX)
                            </div>
                            <div class="col-md-8 col-12">
                                <p>Valor da fatura para pagamento com PIX: <span
                                        style="font-weight: bold">R$
                                        <?PHP print number_format($total_pag_boleto, 2, ',', '.'); ?>
                                    </span></p>
                                <p><small>Selecione a opção à esquerda para realizar o pagamento através do PIX.</small></p>
                                <div class="row justify-content-md-end mt-5">
                                    <div class="col-md-6">
                                        <button class="btn btn-outline-primary btn-block py-3">Confirmar pagar com PIX</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="h3 mb-3 text-black mt-5">Pagar com boleto</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="row row-cols-2">
                            <div class="col-md-4 col-12">
                                <p style="font-weight:bold;">Selecione esta opção para pagar por intermédio de
                                    boleto bancário</p>
                                <input name="form_pag" type="radio" value="boleto" /><img
                                    src="imagens/marcador_boleto.gif" alt="codigo de barras" hspace="3" /> (Boleto
                                bancário)
                            </div>
                            <div class="col-md-8 col-12">
                                <p>Valor da fatura para pagamento com boleto bancário: <span
                                        style="font-weight: bold">R$
                                        <?PHP print number_format($total_pag_boleto, 2, ',', '.'); ?>
                                    </span></p>
                                <p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" />O boleto deve
                                    ser
                                    impresso após a confirmação do pedido, pois não o enviamos via correio. </p>
                                <p><small>A data de vencimento do boleto é de 5 dias corridos após o fechamento do
                                        pedido, após esta data, ele perderá a validade. Na impossibilidade de
                                        imprimi-lo, faça o pagamento do boleto pelo Home Banking de seu banco. Para
                                        isso, utilize o código de barras localizado na parte superior esquerda da
                                        ficha de compensação do boleto. Não é possível pagar o seu pedido através de
                                        DOC, transferência ou depósito para conta indicada neste boleto.</small></p>
                                <div class="row justify-content-md-end mt-5">
                                    <div class="col-md-6">
                                
                                    <button class="btn btn-outline-primary btn-block py-3">Confirmar pagar com boleto</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="h3 mb-3 text-black mt-5">Pagar com cartão de crédito</h2>
                    <div class="p-3 p-lg-5 border mb-5">
                        <div class="row row-cols-2">
                            <div class="col-md-4 col-12 mb-4">
                                <p style="font-weight: bold">Selecione um cartão de crédito</p>
                                <input name="form_pag" type="radio" value="Visa" /><img src="imagens/c_visa.gif"
                                    width="25" height="16" hspace="7" />(Visa)<br />
                                <input name="form_pag" type="radio" value="Mastercard" /><img
                                    src="imagens/c_mastercard.gif" width="25" height="16"
                                    hspace="7" />(Mastercard)<br />
                                <input name="form_pag" type="radio" value="Amex" /><img src="imagens/c_amex.gif"
                                    width="25" height="16" hspace="7" />(Amex)<br />
                                <input name="form_pag" type="radio" value="Diners" /><img src="imagens/c_diners.gif"
                                    width="25" height="16" hspace="7" />(Diners)<br />
                            </div>
                            <div class="col-md-8 col-12">
                                <p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" />é necessário um
                                    cartão de crédito válido (Visa, Mastercard,
                                    Amex ou Diners). Para sua segurança, usamos a tecnologia SSL (Secure Socket
                                    Layer) para proteger as informações de seu cartão. </p>
                                <p><img src="imagens/marcador_atencao.gif" alt="aten&ccedil;&atilde;o" />Para sua
                                    segurança
                                    desabilitamos o campo [N° do cartão] para
                                    a demonstração deste site.</p>
                                <p style="font-weight: bold">Informações sobre o seu cartão de crédito</p>
                                <div class="border p-3">
                                    <form>
                                        <div class="form-group">
                                            <p><label>N° do cartão:</label> <input name="txtnumero" type="text"
                                                    class="caixa_texto" value="5432154321123" maxlength="20"
                                                    readonly="true" style="display: inline; width: 100%" /></p>
                                            <p><label>Nome imp no cartão:</label><input name="txtnome" type="text"
                                                    class="caixa_texto" style="display: inline; width: 100%"
                                                    maxlength="40" readonly value="Girimunda da Silva Aborboreda" />
                                            </p>
                                            <p><label>Data de validade:</label> <input name="txtmes" type="text"
                                                    class="caixa_texto" size="3" maxlength="2" readonly
                                                    value="12" />&nbsp;/&nbsp;<input name="txtano" type="text"
                                                    class="caixa_texto" size="3" maxlength="2" readonly value="26" />
                                            </p>
                                            <p><label>Código de segurança:</label> <input name="txtcodigo" type="text"
                                                    class="caixa_texto" size="5" maxlength="4" readonly value="171" />
                                            </p>
                                            <p class="text-muted"><small>O Código de Segurança do Cartão é um código
                                                    de 3 ou 4 dígitos gravado ou impresso no verso dos cartões Visa,
                                                    MasterCard, Diners. No cartão Amex este código se encontra na
                                                    frente do cartão.</small></p>
                                            <table class="table table-borderless table-sm table-striped">
                                                <thead>
                                                    <th colspan="2" class="text-center">Selecione o número de
                                                        parcelas:</th>
                                                </thead>

                                                <tbody>
                                                    <!-- Exibe o número de parcelas permitidas para pagamento com cartão de crédito -->
                                                    <?PHP
                                                    for ($contador = 1; $contador <= $_SESSION['max_parcelas']; $contador++) { ?>
                                                        <?PHP if ($contador == 1) {
                                                            $chk = "checked='checked'";
                                                        } else {
                                                            $chk = "";
                                                        } ?>
                                                        <?PHP if ($contador % 2 == 1) { ?>

                                                            <tr>
                                                                <td><input name="txtparcelas" type="radio"
                                                                        value="<?PHP print $contador; ?>" <?PHP print $chk; ?> />
                                                                    <?PHP print $contador; ?> x de<span class="c_preto"><strong>
                                                                            R$
                                                                            <?PHP print number_format($total_pag / $contador, 2, ',', '.'); ?>
                                                                        </strong></span> sem juros <br />
                                                                </td>

                                                            <?PHP } else { ?>

                                                                <td><input name="txtparcelas" type="radio"
                                                                        value="<?PHP print $contador; ?>" <?PHP print $chk; ?> />
                                                                    <?PHP print $contador; ?> x de<span class="c_preto"><strong>
                                                                            R$
                                                                            <?PHP print number_format($total_pag / $contador, 2, ',', '.'); ?>
                                                                        </strong></span> sem juros <br />
                                                                </td>
                                                            </tr>
                                                            <?PHP
                                                        } // Encerra o Else
                                                    } // Encerra o for
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="row justify-content-md-end mt-5">
                                    <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-block py-3">Confirmar pagar com crédito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>


                <!-- </form> -->
            </div>
        </div>

        <?php include "inc_rodape.php" ?>

    </div>


    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/main.js"></script>
</body>

</html>

<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rs2);
mysqli_close($conexao);
?>