<?PHP

include "inc_dbConexao.php";

SESSION_START();

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Recupera valores passados pela página detalhes.php
// onde produto = código do produto selecionado
// inserir = S - adicionado ao botão comprar da página detalhes.php
$produto = $_GET['produto'];
$inserir = $_GET['inserir'];
// qt = 1, default para quantidade  por produto passado pelo campo  desta página
$qt = "1";

// Captura o último id de tabela de pedidos
$sql = "SELECT id, status_ped ";
$sql .= " FROM pedidos ";
$sql .= " ORDER by id DESC ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$id_ped = $reg["id"];

$num_ped = $_SESSION['num_ped'];

// Insere um registro na tabela de pedidos
if ( /*$_SESSION['num_ped'] == '' and */$inserir == "S") {
    // Incrementa 1 ao último id 
    $id_ped = $id_ped + 1;

    if (is_null($num_ped) or $num_ped == '') {
        // prepara o número do pedido (id do pedido, hora e primeiro digito do minuto)
        $num_ped = $id_ped . "." . date("H") . substr(date("i"), 0, 1);
        $_SESSION['num_ped'] = $num_ped;
    }

    $_SESSION['id_ped'] = $id_ped;

    // Número do boleto = número do pedido sem separador de milhar
    $SESSION['num_boleto'] = $id_ped . date("H") . substr(date("i"), 0, 1);

    $id_cliente = $_SESSION['id_cli'];

    //ver se o num_ped já existe
    $sqlz = "select num_ped from pedidos where num_ped = '" . $num_ped . "';";
    $rsz = mysqli_query($conexao, $sqlz);
    $regz = mysqli_fetch_row($rsz);

    if ($regz == 0 || is_null($regz)) {
        $sqli = "INSERT INTO pedidos (id_cliente, num_ped, status_ped) VALUES (?, ?, 'Em andamento')";
        $stmt = mysqli_prepare($conexao, $sqli);
        
        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt) {
            // Atribui os valores às variáveis e as vincula aos parâmetros da consulta
            mysqli_stmt_bind_param($stmt, "is", $id_cliente, $num_ped);
        
            // Executa a consulta preparada
            $result = mysqli_stmt_execute($stmt);
        
            // Verifica se a execução foi bem-sucedida
            if ($result) {
                $_SESSION['status_ped'] = 'Em andamento';
            } else {
                echo "Erro ao executar a consulta preparada: " . mysqli_error($conexao);
            }
        
            // Fecha a consulta preparada
            mysqli_stmt_close($stmt);
        } else {
            echo "Erro ao preparar a consulta: " . mysqli_error($conexao);
        }

        $_SESSION['status_ped'] = 'Em andamento';
    }
}

// Excluir itens do carrinho
$excluir = $_GET['excluir'];
$rem = $_GET['rem'];
$id = $_GET['id'];

if ($excluir == "S") {
    if ($rem == "A") {
        $sql4 = "SELECT qt FROM itens WHERE num_ped = '$num_ped' AND id = $id";
        $rs4 = mysqli_query($conexao, $sql4);
        $reg4 = mysqli_fetch_array($rs4);
        $qt4 = $reg4['qt'];

        if ($qt4 >= 2) {
            $sqlz = "UPDATE itens SET qt = qt - $qt WHERE id = $id";
            $rsz = mysqli_query($conexao, $sqlz);
        } else {
            $sqld = "DELETE FROM itens WHERE id = '$id'";
            mysqli_query($conexao, $sqld);

            $sql = "SELECT * FROM itens WHERE num_ped = " . $num_ped . ";";
            $rs = mysqli_query($conexao, $sql);
            $reg = mysqli_fetch_array($rs);

            if (is_null($reg)) {
                $sql = "DELETE FROM pedidos WHERE num_ped = " . $num_ped . ";";
                $rs2 = mysqli_query($conexao, $sql);
            }
        }
    } else {
        $sqld = "DELETE FROM itens WHERE id = '$id'";

        mysqli_query($conexao, $sqld);

        $sql = "SELECT * FROM itens WHERE num_ped = " . $num_ped . ";";
        $rs = mysqli_query($conexao, $sql);
        $reg = mysqli_fetch_array($rs);

        if (is_null($reg)) {
            $sql = "DELETE FROM pedidos WHERE num_ped = " . $num_ped . ";";
            $rs2 = mysqli_query($conexao, $sql);
        }
    }
}


// Captura dados do produto selecionado
$sql = "SELECT id, codigo, nome, preco, desconto, desconto_boleto ";
$sql .= " FROM miniaturas ";
$sql .= " WHERE codigo = '" . $produto . "' ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);

$codigo = $reg["codigo"];
$nome = $reg["nome"];
$preco = $reg["preco"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$preco_desconto = $preco - ($preco * $desconto / 100);
$preco_boleto = $preco_desconto - ($preco_desconto * $desconto_boleto / 100);

// Verifica se o item já se encontra no carrinho
$sqld = "SELECT codigo ";
$sqld .= "FROM itens ";
$sqld .= "WHERE codigo = '" . $produto . "' ";
$sqld .= "AND num_ped = '" . $num_ped . "' ";
$rsd = mysqli_query($conexao, $sqld);
$item_duplicado = mysqli_num_rows($rsd);

if ($inserir == "S") {
    if ($item_duplicado == 0) {
        // Adiciona o produto à tabela de itens
        $sqli = "INSERT INTO itens (num_ped, codigo, nome, qt, preco, preco_boleto, desconto, desconto_boleto) ";
        $sqli .= "VALUES('$num_ped', '$codigo', '$nome', '$qt', '$preco', '$preco_boleto', '$desconto', '$desconto_boleto') ";

        mysqli_query($conexao, $sqli);
    } else {
        // Atualiza a quantidade do item se já existir no carrinho
        $sqlk = "UPDATE itens SET qt = qt + $qt WHERE num_ped = $num_ped AND codigo = '$codigo'";

        mysqli_query($conexao, $sqlk);
    }
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
                    <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong
                            class="text-black">Carrinho</strong></div>
                </div>
            </div>
        </div>

        <?PHP if ($qt == 0) { ?>
            <div class="container mx-auto text-center mt-5 mb-5">
                <div class="row">
                    <div class="col">
                        <h4 class="mb-3">Seu carrinho está vazio</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="index.php" class="btn btn-success" role="button" aria-pressed="true"
                            style="background-color: purple; border-color: purple;">Voltar à loja</a>
                    </div>
                </div>
            </div>
        <?PHP } else { ?>

            <div class="site-section">
                <div class="container">
                    <div class="row mb-5">
                        <form class="col-md-12" method="post">
                            <div class="site-blocks-table">
                                <table class="table table-borderless table-striped">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Imagem</th>
                                            <th class="product-name">Produto</th>
                                            <th class="product-price">Preço</th>
                                            <th class="product-quantity">Quantidade</th>
                                            <th class="product-total">Total</th>
                                            <th class="product-remove">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $n = 0;
                                        while ($reg = mysqli_fetch_array($rs)) {
                                            $n = $n + 1;
                                            $id = $reg["id"];
                                            $codigo = $reg["codigo"];
                                            $nome = $reg["nome"];
                                            $qt = $reg["qt"];
                                            $preco_unitario = $reg["preco"];
                                            $preco_total = $preco_unitario * $qt;
                                            $subtotal = $subtotal + $preco_total;
                                            ?>
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <img src="imagens/<?php echo $codigo ?>.jpg" alt="Image" class="img-fluid">
                                                </td>
                                                <td class="product-name">
                                                    <a href="detalhes.php?produto=<?php echo $codigo ?>">
                                                        <h2 class="h5 text-black">
                                                            <?php echo $nome ?>
                                                        </h2>
                                                    </a>
                                                </td>
                                                <td>R$
                                                    <?PHP print number_format($preco_unitario, 2, ',', '.'); ?>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3" style="max-width: 120px;">
                                                        <div class="input-group-prepend">
                                                            <!--<button class="btn btn-outline-primary"
                                                                type="button">&minus;</button>-->
                                                            <a href="cesta.php?id=<?PHP print $id ?>&excluir=S&rem=A"
                                                                class="btn btn-outline-primary" type="button">&minus;</a>
                                                        </div>
                                                        <input type="number" class="form-control text-center"
                                                            value="<?php echo $qt ?>" placeholder=""
                                                            aria-label="Example text with button addon"
                                                            aria-describedby="button-addon1">
                                                        <div class="input-group-append">
                                                            <a href="cesta.php?produto=<?PHP print $codigo; ?>&inserir=S"
                                                                class="btn btn-outline-primary" type="button">&plus;</a>
                                                            <!---<button class="btn btn-outline-primary js-btn-plus"
                                                                type="button">&plus;</button>-->
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>R$
                                                    <?PHP print number_format($preco_total, 2, ',', '.'); ?>
                                                </td>
                                                <td><a href="cesta.php?id=<?PHP print $id ?>&excluir=S&rem=B"
                                                        class="btn btn-primary btn-sm">X</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-sm btn-block"
                                        onclick="window.location='index.php'">Continuar comprando</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 pl-5">
                            <div class="row justify-content-end">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12 text-right border-bottom mb-5">
                                            <h3 class="text-black h4 text-uppercase">Total</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-black">Subtotal</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong class="text-black">R$
                                                <?PHP print number_format($subtotal, 2, ',', '.'); ?>
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-lg py-3 btn-block"
                                                onclick="window.location='login.php'">Finalizar compra</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

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
mysqli_free_result($rsd);
mysqli_close($conexao);
?>