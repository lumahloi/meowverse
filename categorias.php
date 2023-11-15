<?php
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

$quantidade = 9;
$pagina = (isset($_GET['pg']) && is_numeric($_GET['pg'])) ? (int) $_GET['pg'] : 1;
$inicio = ($quantidade * $pagina) - $quantidade;

$cat_id = (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) ? (int) $_GET['cat_id'] : 0;
$cat_nome = $_GET['cat_nome'];
$ordenar = $_GET['ordenar'];
if(!isset($_GET['ordenar'])||($_GET['ordenar']=='')){
    $ordenar = 'preco ASC';
}
$nome_sub = $_GET['nome_sub'];

if(!isset($_GET['nome_sub'])){
    $nome_sub = '';
}

if (isset($nome_sub)&&($nome_sub != '')) {
    $sql = "SELECT * FROM miniaturas WHERE id_categoria = $cat_id and subcateg = '$nome_sub' ORDER BY $ordenar LIMIT $inicio, $quantidade;";
    $rs = mysqli_query($conexao, $sql);
    $total_registros = mysqli_num_rows($rs);
    
    $sql_total = "SELECT * FROM miniaturas WHERE id_categoria = $cat_id and subcateg = '$nome_sub' ORDER BY $ordenar;";
    $rs_total = mysqli_query($conexao, $sql_total);
    $total_registros_total = mysqli_num_rows($rs_total);
} else {
    $sql = "SELECT * FROM miniaturas WHERE id_categoria = $cat_id ORDER BY $ordenar LIMIT $inicio, $quantidade;";
    $rs = mysqli_query($conexao, $sql);
    $total_registros = mysqli_num_rows($rs);

    $sql_total = "SELECT * FROM miniaturas WHERE id_categoria = $cat_id ORDER BY $ordenar;";
    $rs_total = mysqli_query($conexao, $sql_total);
    $total_registros_total = mysqli_num_rows($rs_total);
}

$sql2 = "SELECT subcateg, COUNT(codigo) FROM miniaturas WHERE id_categoria = $cat_id group by subcateg; ";
$rs2 = mysqli_query($conexao, $sql2);
$total_registros2 = mysqli_num_rows($rs2);

$sql3 = "select count(codigo) from miniaturas where id_categoria = $cat_id";
$rs3 = mysqli_query($conexao, $sql3);
$total = mysqli_fetch_array($rs3);
$total2 = $total["count(codigo)"];

$qt_itens = $total_registros_total;
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
                            <?php echo $cat_nome ?>
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
                                    <h2 class="text-black h5">Todos os produtos (<?php if (is_null($nome_sub) || ($nome_sub == '')) { echo $total2; } else { echo $total_registros; } ?>)
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
                                            <a class="dropdown-item" href="categorias.php?cat_id=<?php echo $cat_id?>&cat_nome=<?php echo $cat_nome?>&nome_sub=<?php echo $nome_sub ?>&ordenar=preco ASC">Menor ao maior</a>
                                            <a class="dropdown-item" href="categorias.php?cat_id=<?php echo $cat_id?>&cat_nome=<?php echo $cat_nome?>&nome_sub=<?php echo $nome_sub ?>&ordenar=preco DESC">Maior ao menor</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <?php
                            for ($contador = 0; $contador < $total_registros; $contador++) {
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
                                                    alt="Imagem de <?php echo $nome ?>" class="img-fluid"></a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <div style="height: 70px;">
                                                <h3><a href="detalhes.php?produto=<?php echo $codigo ?>"><?php echo $nome ?></a></h3>
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
                                        <a href="categorias.php?cat_id=<?php echo $cat_id?>&cat_nome=<?php echo $cat_nome?>&pg=1">
                                            <li class="<?php if ($pagina == 1) {
                                                echo 'active';
                                            } ?>"><span>1</span></li>
                                        </a> <?php } ?>

                                        <?php for ($i = 2; $i <= $qt_paginas; $i++) { ?>
                                            <a
                                                href="categorias.php?cat_id=<?php echo $cat_id?>&cat_nome=<?php echo $cat_nome?>&pg=<?php echo $i ?>">
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
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categoria</h3>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <span class="d-flex"><a href="categorias.php?cat_id=<?php echo $cat_id ?>&cat_nome=<?php echo $cat_nome ?>&ordenar=preco ASC"><?php echo $cat_nome ?></a> <span class="text-black ml-auto">(<?php echo $total2 ?>)
                                </li>
                            </ul>
                        </div>


                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Subcategorias</h3>
                            <ul class="list-unstyled mb-0">
                                <?php
                                for ($contador = 0; $contador < $total_registros2; $contador++) {
                                    $reg2 = mysqli_fetch_assoc($rs2);
                                    $nome_sub = $reg2["subcateg"];
                                    $qntd_sub = $reg2["COUNT(codigo)"];
                                ?>
                                        <li class="mb-1">
                                            <span class="d-flex"><a href="categorias.php?cat_id=<?php echo $cat_id ?>&cat_nome=<?php echo $cat_nome ?>&ordenar=preco ASC&nome_sub=<?php echo $nome_sub ?>"><?php print $nome_sub ?></a> <span class="text-black ml-auto">(<?php print $qntd_sub ?>)
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