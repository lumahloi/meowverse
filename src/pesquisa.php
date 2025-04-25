<?PHP
session_start();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

$quantidade = 9;
$pagina = (isset($_GET['pg'])) ? (int) $_GET['pg'] : 1;
$inicio = ($quantidade * $pagina) - $quantidade;


// Ordena o modo de ordenação usando o método GET (link menor preço e maior preço)
$ordenar = $_GET['ordenar'];
if ($ordenar == "" or is_null($ordenar)) {
    $ordenar = "preco ASC";
}

$nome_cat = $_GET['nome_cat'];
$nome_sub = $_GET['nome_sub'];

if (isset($_GET['txtpes'])) {

    $pesquisa = $_GET['txtpes'];

    $sql = "SELECT codigo, nome, preco, desconto, estoque, min_estoque, COUNT(id) OVER() as qt_total FROM miniaturas WHERE nome LIKE '%$pesquisa%' ";
    $sql_total = "SELECT COUNT(id) as qt_total FROM miniaturas WHERE nome LIKE '%$pesquisa%' ";

    if (isset($nome_cat) && $nome_cat != "") {
        $sql2 = "select id from categorias where cat_nome = '$nome_cat';";
        $rs2 = mysqli_query($conexao, $sql2);
        $res2 = mysqli_fetch_array($rs2);
        $id = $res2["id"];

        $sql .= "and id_categoria = $id ORDER BY $ordenar limit $inicio, $quantidade;";
        $sql_total .= "and id_categoria = $id ORDER BY $ordenar;";

    } else if (isset($nome_sub) && $nome_sub != "") {
        $sql .= "and subcateg = '$nome_sub' ORDER BY $ordenar limit $inicio, $quantidade;";
        $sql_total .= "and subcateg = '$nome_sub' ORDER BY $ordenar;";
    } else {
        $sql .= "order by $ordenar limit $inicio, $quantidade;";
        $sql_total .= "order by $ordenar;";
    }

    $rs_total = mysqli_query($conexao, $sql_total);
    $reg_total = mysqli_fetch_array($rs_total);
    $qt_itens = $reg_total["qt_total"];

    $rs = mysqli_query($conexao, $sql);
    $t_linhas = mysqli_num_rows($rs);

    //salvando qt total de itens da pesquisa
    $sql5 = "SELECT COUNT(id) as qt_total FROM miniaturas WHERE nome LIKE '%$pesquisa%';";
    $rs5 = mysqli_query($conexao, $sql5);
    $reg5 = mysqli_fetch_array($rs5);
    $qt_total = $reg5["qt_total"];

    //procurar subcategorias e sua qntd
    $sql3 = "select subcateg, count(codigo) as qt_sub from miniaturas where nome like '%$pesquisa%' group by subcateg;";
    $rs3 = mysqli_query($conexao, $sql3);
    $t_linhas_sub = mysqli_num_rows($rs3);

    //procurar categorias e sua qntd
    $sql4 = "SELECT c.cat_nome, COUNT(m.id) AS qt_cat FROM categorias AS c INNER JOIN miniaturas AS m ON c.id = m.id_categoria WHERE m.nome LIKE '%$pesquisa%' GROUP BY c.cat_nome;";
    $rs4 = mysqli_query($conexao, $sql4);
    $t_linhas_cat = mysqli_num_rows($rs4);

}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);

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
                            class="text-black"> Pesquisa por
                            <?php if ($pesquisa == '') {
                                print 'todos os produtos';
                            } else {
                                print $pesquisa;
                            } ?>
                        </strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <div class="row mb-5">
                    <div class="col-md-9 order-2">

                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <div class="float-md-left mb-4">
                                    <h2 class="text-black h5">Todos os produtos (<?php echo $qt_total ?>)
                                    </h2>
                                </div>
                                <div class="d-flex">
                                    <div class="dropdown mr-1 ml-md-auto">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                            id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Ordenar preço
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                            <a class="dropdown-item"
                                                href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_cat=<?php echo $nome_cat ?>&nome_sub=<?php echo $nome_sub ?>&ordenar=preco ASC">Menor
                                                ao maior</a>
                                            <a class="dropdown-item"
                                                href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_cat=<?php echo $nome_cat ?>&nome_sub=<?php echo $nome_sub ?>&ordenar=preco DESC">Maior
                                                ao menor</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <?php
                            for ($contador = 0; $contador < $t_linhas; $contador++) {
                                $reg = mysqli_fetch_assoc($rs);
                                $codigo = $reg["codigo"];
                                $nome = $reg["nome"];
                                $estoque = $reg["estoque"];
                                $min_estoque = $reg["min_estoque"];
                                $preco = $reg["preco"];
                                $desconto = $reg["desconto"];
                                $valor_desconto = $preco - ($preco * $desconto / 100);
                                ?>

                                <div class="col-sm-6 col-lg-4 mb-4 mh-100" data-aos="fade-up">
                                    <div class="block-4 text-center border">
                                        <figure class="block-4-image">
                                            <a href="detalhes.php?produto=<?php echo $codigo ?>"><img
                                                    src="imagens/<?php echo $codigo ?>.jpg"
                                                    alt="Imagem de <?php echo $nome ?>" class="img-fluid"  width="600" height="600"></a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <div style="height: 70px;">
                                                <h3><a href="detalhes.php?produto=<?php echo $codigo ?>">
                                                        <?php echo $nome ?>
                                                    </a></h3>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <p class="text-secondary font-weight-bold"><s>R$
                                                            <?PHP print number_format($preco, 2, ',', '.'); ?>
                                                        </s></p>
                                                </div>
                                                <div class="col">
                                                    <p class="text-primary font-weight-bold">R$
                                                        <?PHP print number_format($valor_desconto, 2, ',', '.'); ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <?php
                                            if ($estoque < $min_estoque) {
                                                ?>
                                                <button class="btn btn-danger">Indisponível</button>
                                            <?php } else { ?>
                                                <button class="btn btn-primary"
                                                    onclick="window.location='detalhes.php?produto=<?php echo $codigo ?>'">Comprar</button>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>

                        <?php
                        $qt_paginas = (ceil($qt_itens / $quantidade) <= 0) ? 1 : ceil($qt_itens / $quantidade);
                        ?>

                        <div class="row" data-aos="fade-up">
                            <div class="col-md-12 text-center">
                                <div class="site-block-27">
                                    <ul>
                                        <?php if ($qt_paginas != 1) { ?>
                                        <a href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_cat=<?php echo $nome_cat ?>&nome_sub=<?php echo $nome_sub ?>&pg=1&ordenar=<?php echo $ordenar ?>">
                                            <li class="<?php if ($pagina == 1) {
                                                echo 'active';
                                            } ?>"><span>1</span></li>
                                        </a> <?php } ?>

                                        <?php for ($i = 2; $i <= $qt_paginas; $i++) { ?>
                                            <a
                                                href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_cat=<?php echo $nome_cat ?>&nome_sub=<?php echo $nome_sub ?>&pg=<?php echo $i ?>&ordenar=<?php echo $ordenar ?>">
                                                <li class="<?php if ($pagina == $i) {
                                                    echo 'active';
                                                } ?>"><span>
                                                        <?php echo $i ?>
                                                    </span></li>
                                            </a>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-3 order-1 mb-5 mb-md-0">
                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Pesquisa</h3>
                            <ul class="list-unstyled mb-0">

                                <li class="mb-1">
                                    <span class="d-flex"><a href="pesquisa.php?txtpes=<?php echo $pesquisa ?>">
                                            <?php if ($pesquisa == '') {
                                                print 'Todos os produtos';
                                            } else {
                                                print $pesquisa;
                                            } ?>
                                        </a> <span class="text-black ml-auto">(<?php print $qt_total ?>)
                                </li>
                            </ul>
                        </div>

                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categorias</h3>
                            <ul class="list-unstyled mb-0">
                                <?php
                                for ($contador = 0; $contador < $t_linhas_cat; $contador++) {
                                    $reg4 = mysqli_fetch_assoc($rs4);
                                    $nome_cat = $reg4["cat_nome"];
                                    $qt_cat = $reg4["qt_cat"];
                                    ?>
                                    <li class="mb-1">
                                        <span class="d-flex"><a
                                                href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_cat=<?php echo $nome_cat ?>">
                                                <?php print $nome_cat ?>
                                            </a> <span class="text-black ml-auto">(<?php print $qt_cat ?>)
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>


                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Subcategorias</h3>
                            <ul class="list-unstyled mb-0">
                                <?php
                                for ($contador = 0; $contador < $t_linhas_sub; $contador++) {
                                    $reg3 = mysqli_fetch_assoc($rs3);
                                    $nome_sub = $reg3["subcateg"];
                                    $qt_sub = $reg3["qt_sub"];
                                    ?>
                                    <li class="mb-1">
                                        <span class="d-flex"><a
                                                href="pesquisa.php?txtpes=<?php echo $pesquisa ?>&nome_sub=<?php echo $nome_sub ?>">
                                                <?php print $nome_sub ?>
                                            </a> <span class="text-black ml-auto">(<?php print $qt_sub ?>)
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
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