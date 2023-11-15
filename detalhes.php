<?php
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


$produto = $_GET['produto'];

$sql = " SELECT categorias.cat_nome, miniaturas.* FROM categorias ";
$sql .= "INNER JOIN miniaturas ";
$sql .= "ON categorias.id = miniaturas.id_categoria ";
$sql .= "WHERE miniaturas.codigo = '" . $produto . "' ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);

$codigo = $reg["codigo"];
$nome = $reg["nome"];
$nome_cat = $reg["nome_cat"];
$cat_sub = $reg["cat_sub"];
$preco = $reg["preco"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$max_parcelas = $reg["max_parcelas"];
$altura = $reg["altura"];
$estoque = $reg["estoque"];
$min_estoque = $reg["min_estoque"];
$subcategoria = $reg["subcateg"];
$altura = $reg["altura"];
$fabrica = $reg["fabrica"];
$descricao = $reg["descricao"];
$id_categoria = $reg["id_categoria"];

// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio do cartão de credito
$valor_desconto = $preco - ($preco * $desconto / 100);
// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio de boleto bancário
$valor_boleto = $valor_desconto - ($valor_desconto * $desconto_boleto / 100);

$sql2 = "select * from miniaturas where subcateg = '$subcategoria' or id_categoria = $id_categoria order by case when subcateg = '$subcategoria' then 1 ELSE 2 END, subcateg limit 6;";
$sql2 = "SELECT * FROM miniaturas WHERE (subcateg = '$subcategoria' OR id_categoria = $id_categoria) AND codigo <> '$codigo' AND estoque >= min_estoque ORDER BY CASE WHEN subcateg = '$subcategoria' THEN 1 ELSE 2 END, subcateg LIMIT 6;";
$rs2 = mysqli_query($conexao, $sql2);
$total_registros2 = mysqli_num_rows($rs2);
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

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong
                            class="text-black">
                            <?php echo $nome ?>
                        </strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="imagens/<?php echo $codigo ?>.jpg" alt="Image" class="img-fluid">

                        <table class="table">
                            <thead>
                                <tr>
                                    <h3 class="mt-3">Dados técnicos</h3>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>
                                        <p>Subcategoria:</p>
                                    </th>
                                    <td>
                                        <p>
                                            <?php echo $subcategoria ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Altura:</p>
                                    </th>
                                    <td>
                                        <p>
                                            <?php echo $altura ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Fábrica:</p>
                                    </th>
                                    <td>
                                        <p>
                                            <?php echo $fabrica ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8">
                        <h2 class="text-black">
                            <?php echo $nome ?>
                        </h2>
                        <p>
                            <?php echo $descricao ?>
                        </p>

                        <?PHP if ($max_parcelas >= $_SESSION['max_parcelas']) {
                            $_SESSION['max_parcelas'] = $max_parcelas;
                        } ?>

                        <div class="row justify-content-between">
                            <div class="col-md-3 col-4">
                                <p class="mb-0"><strong class="h4"><s>R$
                                            <?PHP print number_format($preco, 2, ',', '.'); ?>
                                        </s></strong></p>
                                <p><strong class="text-primary h2">R$
                                        <?PHP print number_format($valor_desconto, 2, ',', '.'); ?>
                                    </strong></p>
                            </div>
                            <div class="col-md-3 col-4">
                                <?php
                                if ($estoque < $min_estoque) {
                                    ?>
                                    <button class="btn btn-danger">Indisponível</button>
                                <?php } else { ?>
                                    <button class="btn btn-primary"
                                        onclick="window.location='cesta.php?produto=<?PHP print $codigo; ?>&inserir=S'">Comprar</button>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p>Pague com Boleto Bancário e ganhe +
                                    <?PHP print number_format(($desconto_boleto), 0, ',', '.'); ?>% de desconto:
                                    <span style="font-weight: bold; color: green;">R$
                                        <?PHP print number_format(($valor_boleto), 2, ',', '.'); ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col">
                                <p>* Este produto pode ser pago com cartão de crédito em até
                                    <?PHP print $max_parcelas; ?> parcelas.
                                </p>

                            </div>
                        </div>

                        <div class="border p-3 mb-3 mt-3">
                            <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank"
                                    role="button" aria-expanded="false" aria-controls="collapsebank">Parcelamento no
                                    cartão de crédito</a></h3>

                            <div class="collapse" id="collapsebank">
                                <div class="py-2">
                                    <table class="table table-borderless table-striped table-sm">

                                        <?PHP for ($contador = 1; $contador <= $max_parcelas; $contador++) { ?>
                                            <?PHP if ($contador % 2 == 1) { ?>
                                                <tr class="w-50">
                                                    <td>
                                                        <p class="small">
                                                            <?PHP print $contador; ?> x de R$
                                                            <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?>
                                                            sem
                                                            juros
                                                        </p>
                                                    </td>
                                                <?PHP } else { ?>
                                                    <td>
                                                        <p class="small">
                                                            <?PHP print $contador; ?> x de R$
                                                            <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?>
                                                            sem
                                                            juros
                                                        </p>
                                                    </td>
                                                </tr>
                                                <?PHP
                                            } // Encerra o Else
                                        } // Encerra o for
                                        ?>

                                    </table>
                                </div>
                            </div>
                        </div>


                        <h4 class="mt-4 mb-3">Formas de pagamento</h4>
                        <img src="imagens/banner_formapag.gif" alt="formas de pagamento" width="297" height="23"
                            vspace="5" />

                        <h4 class="mt-4 mb-3">Prazos de entrega</h4>
                        <p>2 dias úteis para o estado de São Paulo. <br>5 dias úteis para os demais estados.</p>

                        <h4 class="mt-4 mb-3">Observações</h4>
                        <p>As mercadorias adquiridas serão despachadas, via Sedex(Sedex ou e_Sedex), no primeiro dia
                            útil após a comprovação de pagamento, estando a entrega condicionada à disponibilidade de
                            estoque. Prazo médio de entrega dos Correios: 24 a 72 horas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Produtos relacionados</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        <?php
                        for ($contador = 0; $contador < $total_registros2; $contador++) {
                            $reg2 = mysqli_fetch_assoc($rs2);
                            $codigo = $reg2["codigo"];
                            $nome = $reg2["nome"];
                            $estoque = $reg2["estoque"];
                            $min_estoque = $reg2["min_estoque"];
                            $preco = $reg2["preco"];
                            $desconto = $reg2["desconto"];
                            $valor_desconto = $preco - ($preco * $desconto / 100);

                            if ($estoque >= $min_estoque && $produto != $codigo) {
                                ?>
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="imagens/<?php print $codigo ?>.jpg" alt="Imagem de <?php print $nome ?>"
                                                class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <div style="height: 60px;">
                                                <h3><a href="detalhes.php?produto=<?php print $codigo ?>">
                                                        <?php print $nome ?>
                                                    </a></h3>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <p class="h5 text-secondary font-weight-bold"><s>R$
                                                            <?PHP print number_format($preco, 2, ',', '.'); ?>
                                                        </s></p>
                                                </div>
                                                <div class="col">
                                                    <p class="h5 text-primary font-weight-bold">R$
                                                        <?PHP print number_format($valor_desconto, 2, ',', '.'); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary"
                                                onclick="window.location='detalhes.php?produto=<?php echo $codigo ?>'">Comprar</button>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
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