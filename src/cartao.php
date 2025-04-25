<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// Captura os itens da cesta
$sql = "SELECT * FROM itens ";
$sql .= "WHERE num_ped = '" . $_SESSION['num_ped'] . "' ";
$sql .= "ORDER BY id ";

//echo $sql;
//exit;
$rs = mysqli_query($conexao, $sql);

// Atualiza a tabela de pedidos
$sqlp = "UPDATE pedidos SET ";
$sqlp .= "id_cliente = '" . $_SESSION['id_cli'] . "', ";
$sqlp .= "status_ped = 'Aguardando aprovação do cartão', ";
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
                        <strong class="text-black">Cartão</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <h2 class="h3 mb-3 text-black">Instruções para pagamento</h2>
                <p>Obrigado por comprar em nossa loja. Seu pedido foi aceito e está aguardando aprovação da operadora do
                    Cartão de Crédito. Após recebermos a confirmação de pagamento, nós lhe enviaremos um e-mail de
                    notificação confirmando a entrega do pedido.</p>

                <h2 class="h3 mb-3 text-black mt-5">Informações gerais sobre sua compra</h2>
                <div class="p-3 p-lg-5 border">
                    <h5>Resumo do pedido</h5>
                    <div class="row row-cols-2 p-3">
                        <div class="col-md-4 col-12">
                            <p><strong>Número do seu pedido</strong>:
                                <?PHP print $_SESSION['num_ped']; ?>
                            </p>
                            <p><strong>Pagamento efetuado por intermédio do cartão de crédito:</strong>
                                <?PHP print $_SESSION['nome_cartao']; ?>
                            </p>
                            <p><strong>N° de parcelas</strong>:
                                <?PHP print $_SESSION['c_parcelas']; ?>
                            </p>
                            <p><strong>Valor da(s) parcela(s)</strong>: R$
                                <?PHP print number_format((($_SESSION['valor'] + $_SESSION['valor_frete']) / $_SESSION['c_parcelas']), 2, ',', '.'); ?>
                            </p>
                            <p><span style="font-weight:bold;">Data do pedido</span>:
                                <?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?>
                            </p>
                            <p><span style="font-weight:bold;">Vencimento</span>:
                                <?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?>
                            </p>
                            <p><span style="font-weight:bold;">Forma de pagamento: Cartão de crédito</p>
                            <p><span style="font-weight:bold;">Status</span>: Aguardando aprovação do cartão</p>
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
                                        $peso = 0.6;

                                        // valores para pagamento com cartão de crédito
                                        $preco_total = $preco * $qt;
                                        $subtotal = $subtotal + $preco_total;
                                        $total_total = $_SESSION['valor_frete'] + $subtotal;
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
                                    <?php } ?>

                                    <tr>
                                        <td colspan="3"><span style="font-weight:bold;">Subtotal</span></td>
                                        <td><strong>R$
                                                <?PHP print number_format($subtotal, 2, ',', '.'); ?>
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
                                                <?PHP print number_format($total_total, 2, ',', '.'); ?>
                                            </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
$valor = number_format($_SESSION['valor'],2,',','.');
$email_cli = $_SESSION['email_cli'];

$assunto = "Confirmação do seu pedido";

$msg = "";
$msg = $msg . "Olá\t$nome\n";
$msg = $msg . "Agradecemos sua preferência pela Meowverse.\n\n";
$msg = $msg . "A confirmação de seu pedido N° \t$num_ped, no valor total de R$ \t$valor foi realizada com sucesso.\n\n";
$msg = $msg . "Para acompanhar este pedido visite nosso site e selecione a opção 'Meus pedidos'\n\n";
$msg = $msg . "Atenciosamente.\n";
$msg = $msg . "Meowverse.\n\n";

$cabecalho = "From: Meowverse\n";

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