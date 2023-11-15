<?PHP

SESSION_START();
include "inc_dbConexao.php";
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// Captura os itens da cesta 
$sql = "SELECT * FROM itens ";
$sql .= "WHERE num_ped = '" . $_SESSION['num_ped'] . "' ";
$sql .= "ORDER BY id ";
$rs = mysqli_query($conexao, $sql);


// Atualiza a tabela de pedidos
$sqlp = "UPDATE pedidos set ";
$sqlp .= "id_cliente = '" . $_SESSION['id_cli'] . "', ";
$sqlp .= "status_ped = 'Aguardando pagamento do boleto', ";
$sqlp .= "data = '" . $_SESSION['dataped'] . "', ";
$sqlp .= "hora = '" . $_SESSION['horaped'] . "', ";
$sqlp .= "valor = '" . $_SESSION['valor'] . "', ";
$sqlp .= "vencimento = '" . $_SESSION['datavenc'] . "', ";
$sqlp .= "frete = '" . $_SESSION['valor_frete'] . "', ";
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
    $sqli .= " (num_ped, status_ped) ";
    $sqli .= " VALUES('$num_ped','Em andamento') ";
    $rs = mysqli_query($conexao, $sqli);

    $_SESSION['status_ped'] = 'Em andamento';
}

$num_ped = $_SESSION['num_ped'];
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
            if (document.boleto.rdboleto.checked == false) {
                alert("Por favor, selecione a opção [Boleto bancário].");
                return false;
            }
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
                        <a href="pagamento.php">Pagamento</a>
                        <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Boleto</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <h2 class="h3 mb-3 text-black">Instruções para pagamento</h2>
                <p>Obrigado por comprar em nossa loja. Seu pedido foi aceito e está aguardando pagamento. Por favor,
                    clique no botão abaixo, imprima o boleto bancário e pague em qualquer banco. Se preferir, pague por
                    intermédio do Internet Banking. Para isso, utilize o <strong>código de barras </strong>localizado na
                    parte superior direita da ficha de compensação do boleto.</p>
                <p><img src="imagens/marcador_atencao.gif" width="20" height="15" />Após recebermos a confirmação de
                    pagamento, nós lhe enviaremos um e-mail de notificação confirmando a entrega do pedido.</p>
                <p><img src="imagens/marcador_atencao.gif" width="20" height="15" />A data de vencimento do boleto é de
                    <strong>5 (cinco)</strong> dias após o fechamento do pedido. ATENÇÃO: <strong>Não pague após o
                        vencimento</strong>. Após esta data o pedido será cancelado e o boleto perderá a validade.
                </p>

                <h2 class="h3 mb-3 text-black mt-5">Informações gerais sobre sua compra</h2>
                <div class="p-3 p-lg-5 border">
                    <h5>Resumo do pedido</h5>

                    <div class="row row-cols-2 p-3">

                        <div class="col-md-4 col-12">
                            <p class="text-end"><strong>Número do seu pedido</strong>:
                                <?PHP print $_SESSION['num_ped']; ?>
                            </p>

                            <p><span style="font-weight:bold;">Data do pedido</span>:
                                <?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?>
                            </p>
                            <p><span style="font-weight:bold;">Vencimento</span>:
                                <?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?>
                            </p>

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
                                        <?PHP
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="3"><span style="font-weight:bold;">Subtotal</span></td>
                                        <td><strong>R$
                                                <?PHP print number_format($subtotal, 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"><span style="font-weight:bold;">Desconto para pagamento com
                                                boleto bancário</span> </td>
                                        <td><strong class="c_preto">R$ -
                                                <?PHP print number_format(($_SESSION['desconto_boleto']), 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"><strong>Frete</strong></td>
                                        <td><strong>R$
                                                <?PHP print number_format($_SESSION['valor_frete'], 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <h3>Total da fatura </h3>
                                        </td>
                                        <td>
                                            <h3>R$
                                                <?PHP print number_format($_SESSION['valor_boleto'], 2, ',', '.'); ?>
                                            </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-md-end mt-5">

                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-block py-3"
                                onclick="window.location='emitir_boleto.php'">Imprimir boleto</button>
                        </div>
                    </div>
                </div>


                <h2 class="h3 mb-3 text-black mt-5">Informações para envio de sua compra</h2>
                <div class="p-3 p-lg-5 border">
                    <p>Nome do comprador: <strong class="c_laranja">
                            <?PHP print $_SESSION['nome_cli']; ?>
                        </strong></p>

                    <p>E-mail: <strong class="c_laranja">
                            <?PHP print $_SESSION['email_cli']; ?>
                        </strong></p>

                    <p>
                        <?PHP print ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']); ?><br />
                        <?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . " " . ltrim($_SESSION['bairro']) . " - " . ltrim($_SESSION['cidade']) . " - " . ltrim($_SESSION['uf']); ?>
                    </p>

                    <p><strong>* E-mail de confirmação:</strong> se você não receber um e-mail de confirmação do pedido
                        em breve, verifique sua pasta/diretório de spam ou e-mails indesejados (junk folder) na sua
                        caixa de correio eletrônico. Se encontrar o e-mail em uma dessas pastas, seu provedor da
                        Internet, bloqueador de spam ou software de filtragem está redirecionando as nossas mensagens.
                    </p>

                    <p><strong>* Status do pedido:</strong> você pode acompanhar o status do seu pedido, bem como
                        visualizar todas as suas informações, clicando no botão "Meus pedidos" que se encontra na parte
                        superior desse site.</p>
                </div>

                <div class="row mt-5 mb-5">
                    <div class="col-md-12 text-center">
                        <span class="icon-check_circle display-3 text-success"></span>
                        <h2 class="display-3 text-black">Obrigada!</h2>
                        <p class="lead mb-5">Seu pedido foi feito com sucesso.</p>
                        <p><a href="index.php" class="btn btn-sm btn-primary">Voltar à loja</a></p>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
    </div>


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
// Envio de e-mail com a confirmação do pedido
$nome = $_SESSION['nome_cli'];
$num_ped = $_SESSION['num_ped'];
$valor = number_format($_SESSION['valor_boleto'], 2, ',', '.');
$email_cli = $_SESSION['email_cli'];
$link = "https://meowverse.000webhostapp.com/detalhe_ped.php?det_ped=" . $_SESSION['num_ped'];

$assunto = "Confirmação do seu pedido";

$msg = "";
$msg = $msg . "Olá\t$nome\n";
$msg = $msg . "Agradecemos sua preferência pela Meowverse\n\n";
$msg = $msg . "A confirmação de seu pedido N° \t$num_ped, no valor total de R$ \t$valor foi realizada com sucesso.\n\n";
$msg = $msg . "Você optou em pagar sua compra por intermédio de boleto bancário.\n";
$msg = $msg . "Caso ainda não tenha impresso o referido boleto, clique no link abaixo para efetuar sua impressão.\n\n";
$msg = $msg . "\t$link\n\n";
$msg = $msg . "Para acompanhar este pedido visite nosso site e selecione a opção 'Meus pedidos'\n\n";
$msg = $msg . "Atenciosamente.\n";
$msg = $msg . "Meowverse\n\n";

$cabecalho = "From: Meowverse\n";

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