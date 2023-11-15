<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// Recupera código do pedido (selecionado em pedidos2.php
$det_ped = $_GET['det_ped'];

// Captura dados do pedido
$sql = "SELECT * FROM pedidos ";
$sql .= " WHERE num_ped = '" . $det_ped . "' ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$data = $reg['data'];
$hora = $reg['hora'];
$valor = $reg['valor'];
$vencimento = $reg['vencimento'];
$frete = $reg['frete'];
$desconto = $reg['desconto'];
$formpag = $reg['formpag'];
$peso = $reg['peso'];
$status = $reg['status_ped'];
$cartao = $reg['cartao'];
$parcelas = $reg['parcelas'];
$id_cliente = $reg['id_cliente'];

if ($formpag == "B") {
    $formpag1 = "Boleto bancário";
} else {
    $formpag1 = "Cartão de crédito";
}

// Carrega dados do cliente
$sql = "SELECT * FROM cadcli ";
$sql .= " WHERE id = '" . $id_cliente . "' ";

$rs1 = mysqli_query($conexao, $sql);
$reg1 = mysqli_fetch_array($rs1);

// Armazena dados do cliente para as próximas páginas
$_SESSION['email_cli'] = $reg1['email'];
$_SESSION['nome_cli'] = $reg1['nome'];
$_SESSION['end_nome'] = $reg1['end_nome'];
$_SESSION['end_num'] = $reg1['end_num'];
$_SESSION['end_comp'] = $reg1['end_comp'];
$_SESSION['cep'] = $reg1['cep'];
$_SESSION['bairro'] = $reg1['bairro'];
$_SESSION['cidade'] = $reg1['cidade'];
$_SESSION['uf'] = $reg1['uf'];
$_SESSION['id'] = $reg1['id'];

// Captura os itens da cesta
$sql = "SELECT * ";
$sql = $sql . " FROM itens ";
$sql = $sql . " WHERE num_ped = '" . $det_ped . "' ";
$sql = $sql . " ORDER BY id ";
$rs = mysqli_query($conexao, $sql);

// Dias que faltam para vencer o pedido
$dia1 = date('d');
$mes1 = date('m');
$ano1 = date('Y');
$dia2 = substr($vencimento, 8, 2);
$mes2 = substr($vencimento, 5, 2);
$ano2 = substr($vencimento, 0, 4);
$timestamp_data1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
$timestamp_data2 = mktime(0, 0, 0, $mes2, $dia2, $ano2);
$dif_dias = round(($timestamp_data2 - $timestamp_data1) / 86400);
// Define a mensagem para o número de dias que faltam para o cancelamento do pedido
if ($dif_dias == 0) {
    $mensagem_dias = "Hoje é o </span><span class='c_vermelho'><strong> último dia </strong></span>";
} else {

    $mensagem_dias = "Você ainda tem </span><span class='c_vermelho'><strong> " . $dif_dias . " dia(s) </strong></span>";
}
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
        <?php include "inc_menuSuperiorCat.php" ?>

        <div class="site-section">
            <div class="container">
                <h2>Detalhes do pedido</h2>
                <h4 class="h4 mb-3 text-black mt-2"><?PHP print $status; ?>
                </h4>

                <h3 class=" h3 mb-3 text-black mt-5">Informações sobre o pedido
                </h3>
                <div class="container  border p-3">
                    <?PHP
                    $_SESSION['num_ped1'] = $det_ped;
                    ?>
                    <div class="row row-cols-2">
                        <div class="col-md-4">
                            <?PHP if ($formpag == "C") { ?>
                                <p>Pagamento efetuado por intermédio do cartão de crédito:
                                    <?PHP print $cartao; ?>
                                </p>
                                <p>N° de parcelas:
                                    <?PHP print $parcelas; ?>
                                </p>
                                <p>Valor da(s) parcela(s): R$
                                    <?PHP print number_format(($valor / $parcelas), 2, ',', '.'); ?>
                                </p>
                            <?PHP } ?>
                            <p>Código: <?PHP print $det_ped; ?></p>
                            <p>Data do pedido:
                                <?PHP print substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4); ?>
                            </p>
                            <p>Vencimento:
                                <?PHP print substr($vencimento, 8, 2) . "/" . substr($vencimento, 5, 2) . "/" . substr($vencimento, 0, 4); ?>
                            </p>
                            <p>Forma de pagamento:
                                <?PHP print $formpag1; ?>
                            </p>
                            <p>Status:<span class="c_laranja">
                                    <?PHP print $status; ?>
                            </p>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-striped">
                                <thead>
                                    <th>Descrição do produto </th>
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
                  $preco_total = $preco * $qt
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
                                        <td colspan="3">Subtotal</td>
                                        <td><strong>R$
                                                <?PHP print number_format(($valor), 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Desconto</strong></td>
                                        <td><strong>R$
                                                <?PHP print number_format($desconto, 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Frete</strong></td>
                                        <td><strong>R$
                                                <?PHP print number_format($frete, 2, ',', '.'); ?>
                                            </strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <h3>Total do pedido </h3>
                                        </td>
                                        <td>
                                            <h3>R$
                                                <?PHP print number_format(($valor + $frete - $desconto), 2, ',', '.'); ?>
                                            </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!--fecha row-cols-2-->
                </div> <!--fecha container-->
                <h3 class="h3 mb-3 text-black mt-5">Informações para envio de sua compra</h3>
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

                <div class="row justify-content-md-end mt-5">

                    <div class="col-md-3">
                        <button class="btn btn-outline-primary btn-block py-3"
                            onclick="window.location='javascript:history.go(-1)'">Voltar</button>
                    </div>
                </div>

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
mysqli_close($conexao);
?>