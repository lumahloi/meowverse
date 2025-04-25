<?PHP
SESSION_START();
include "../inc_dbConexao.php";

// Recupera parâmetros passados pela página inc_menu.php
$acao = $_GET['acao'];

if (isset($id)) {
    $id = $_GET['id'];
}

$titulo_pagina = $_GET['titulo'];

if ($acao == "ver") {
    // modo de edição das caixas de texto do formulário
    $editar = "readonly";
    $editar_combo = "disabled='disabled'";
    $estilo_caixa = "caixa_texto_des";
} else {
    $editar = "";
    $editar_combo = "";
    $estilo_caixa = "caixa_texto";
}

if (isset($id)) {
    // Recupera registro 
    $sql = "SELECT * FROM miniaturas ";
    $sql = $sql . " WHERE id = '" . $id . "' ";
    $rs = mysqli_query($conexao, $sql);
    $reg = mysqli_fetch_array($rs);
    $id = $reg['id'];
    $codigo = $reg['codigo'];
    $destaque = $reg['destaque'];
    $nome = $reg['nome'];
    $id_categoria = $reg['id_categoria'];
    $subcateg = $reg['subcateg'];
    $destaque = $reg['destaque'];
    $altura = $reg['altura'];
    $preco = $reg['preco'];
    $desconto = $reg['desconto'];
    $desconto_boleto = $reg['desconto_boleto'];
    $max_parcelas = $reg['max_parcelas'];
    $estoque = $reg['estoque'];
    $min_estoque = $reg['min_estoque'];
    $fabrica = $reg['fabrica'];
    $descricao = $reg['descricao'];
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="./assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Meowverse</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="./assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="./assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="./assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="./assets/js/config.js"></script>

    <script language="javascript">
        //Valida campos do formulário de entrega (usuários já cadastrados) -->
        function valida_form() {
            if (document.form_cad.codigo.value == "") {
                alert("Por favor, preencha o campo [Código].");
                form_cad.codigo.focus();
                return false;
            }

            if (document.form_cad.nome.value == "") {
                alert("Por favor, preencha o campo [Descrição].");
                form_cad.nome.focus();
                return false;
            }

            if (document.form_cad.id_categoria.value == "0") {
                alert("Por favor, selecione uma categoria.");
                form_cad.id_categoria.focus();
                return false;
            }

            if (document.form_cad.subcateg.value == "") {
                alert("Por favor, preencha o campo [Subcategoria].");
                form_cad.subcateg.focus();
                return false;
            }

            if (document.form_cad.destaque.value == "") {
                alert("Por favor, preencha o campo [Destaque Home Page].");
                form_cad.destaque.focus();
                return false;
            }

            if (document.form_cad.altura.value == "") {
                alert("Por favor, preencha o campo [Altura].");
                form_cad.altura.focus();
                return false;
            }

            if (document.form_cad.preco.value == "") {
                alert("Por favor, preencha o campo [Preço].");
                form_cad.preco.focus();
                return false;
            }

            if (document.form_cad.desconto.value == "") {
                alert("Por favor, preencha o campo [Desconto].");
                form_cad.desconto.focus();
                return false;
            }

            if (document.form_cad.desconto_boleto.value == "") {
                alert("Por favor, preencha o campo [Desconto para boleto].");
                form_cad.desconto_boleto.focus();
                return false;
            }

            if (document.form_cad.max_parcelas.value == "") {
                alert("Por favor, preencha o campo [Parcelamento máximo].");
                form_cad.max_parcelas.focus();
                return false;
            }

            if (document.form_cad.estoque.value == "") {
                alert("Por favor, preencha o campo [Em estoque].");
                form_cad.estoque.focus();
                return false;
            }

            if (document.form_cad.min_estoque.value == "") {
                alert("Por favor, preencha o campo [Estoque mínimo].");
                form_cad.min_estoque.focus();
                return false;
            }

            if (document.form_cad.fabrica.value == "") {
                alert("Por favor, preencha o campo [Fábrica].");
                form_cad.fabrica.focus();
                return false;
            }

            if (document.form_cad.descricao.value == "") {
                alert("Por favor, preencha o campo [Descrição].");
                form_cad.descricao.focus();
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">

                    <span class="app-brand-text demo menu-text fw-bolder ms-2">Meowverse</span>


                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <a href="entrada.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Página inicial</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Manutenção cadastral</span>
                    </li>

                    <li class="menu-item active">
                        <a href="cad_miniaturas_grid.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                            <div data-i18n="Boxicons">Produtos</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="cad_frete_grid.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-package"></i>
                            <div data-i18n="Boxicons">Frete</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="cad_usuario_grid.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Boxicons">Usuários</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Contas a receber</span>
                    </li>

                    <li class="menu-item">
                        <a href="baixar_boletos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Basic">Baixar boletos</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="baixar_cartao.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-credit-card"></i>
                            <div data-i18n="Boxicons">Confirmar liberação do cartão</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Relatórios</span></li>

                    <li class="menu-item">
                        <a href="r01.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-line-chart-down"></i>
                            <div data-i18n="Tables">Itens abaixo do estoque</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="r02.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-square-x"></i>
                            <div data-i18n="Tables">Pedidos cancelados</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="r03.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-square-check"></i>
                            <div data-i18n="Tables">Pedidos confirmados</div>
                        </a>
                    </li>

                    <!-- Misc -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Outros</span></li>
                    <li class="menu-item">
                        <a href="../index.php" target="_blank" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-store"></i>
                            <div data-i18n="Support">Navegar no site</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="index.php" target="_blank" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-log-out"></i>
                            <div data-i18n="Documentation">Sair</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search.."
                                    aria-label="Search.." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <li class="nav-item lh-1 me-3">
                                <a class="github-button"
                                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                                    data-icon="octicon-star" data-size="large" data-show-count="true"
                                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star</a>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="./assets/img/avatars/1.png" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="./assets/img/avatars/1.png" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">John Doe</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="d-flex align-items-center align-middle">
                                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                <span class="flex-grow-1 align-middle">Billing</span>
                                                <span
                                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="auth-login-basic.html">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manutenção Cadastral / Produtos
                                /</span>
                            <?php print $titulo_pagina ?>
                        </h4>

                        <form name="form_cad" method="post" action="./cad_miniaturas1.php"
                            onsubmit="return valida_form();">
                            <?PHP
                            if ($acao != "ins") {
                                $imagem_existe = "../imagens/" . $codigo . ".jpg";
                                if (file_exists($imagem_existe)) {
                                    $imagem = "<p><label>Imagem:</label><img src='../imagens/" . $codigo . ".jpg' border='0' /></p>";
                                } else {
                                    $imagem = "<p><label>Imagem:</label><img src='../imagens/fundo_imagem_naodisp.jpg' border='0' /></p>";
                                }
                            }
                            ?>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <!--<h5 class="mb-0">Basic Layout</h5>
                          <small class="text-muted float-end">Default label</small>-->
                                            <?PHP if (isset($imagem)) {
                                                print $imagem;
                                            } ?>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-3">
                                                    <label class="form-label" for="codigo">Código *</label>
                                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                                        maxlength="5"
                                                        value="<?PHP if (isset($codigo)) {
                                                            print $codigo;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="destaque">Destaque Home Page</label>
                                                    <input type="text" class="form-control" id="destaque"
                                                        name="destaque" maxlength="1"
                                                        value="<?PHP if (isset($destaque)) {
                                                            print $destaque;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="nome">Nome *</label>
                                                    <input type="text" class="form-control" id="nome" name="nome"
                                                        maxlength="60"
                                                        value="<?PHP if (isset($nome)) {
                                                            print $nome;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="categoria">Categoria *</label>
                                                    <select name="id_categoria" <?PHP print $editar_combo; ?>
                                                        class="form-select" id="id_categoria"
                                                        aria-label="Default select example">>
                                                        <?PHP
                                                        // Carrega combo de unidades federativas
                                                        $itens_cat = "<option value='0'>-- Selecione uma categoria</option><br /> ";
                                                        $sql_cat = "SELECT * FROM categorias ";
                                                        $rs_cat = mysqli_query($conexao, $sql_cat);
                                                        while ($reg_cat = mysqli_fetch_array($rs_cat)) {
                                                            if ($id_categoria == $reg_cat['id']) {
                                                                $itens_cat = $itens_cat . "<option value='" . $reg_cat['id'] . "' selected='selected'>" . $reg_cat['cat_nome'] . "</option><br /> ";
                                                            } else {
                                                                $itens_cat = $itens_cat . "<option value='" . $reg_cat['id'] . "'>" . $reg_cat['cat_nome'] . "</option><br /> ";
                                                            }

                                                        }
                                                        print $itens_cat;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="subcateg">Subcategoria *</label>
                                                    <input type="text" class="form-control" id="subcateg"
                                                        name="subcateg" maxlength="30"
                                                        value="<?PHP if (isset($subcateg)) {
                                                            print $subcateg;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="altura">Altura *</label>
                                                    <input type="number" step="0.1" min=0 class="form-control"
                                                        id="altura" name="altura" maxlength="10"
                                                        value="<?PHP if (isset($altura)) {
                                                            print $altura;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="preco">Preço *</label>
                                                    <input type="number" step="0.01" min=0 class="form-control"
                                                        id="preco" name="preco" maxlength="20"
                                                        value="<?PHP if (isset($preco)) {
                                                            print $preco;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="desconto">Desconto (em
                                                        porcentagem)</label>
                                                    <input type="number" min=0 class="form-control" id="desconto"
                                                        name="desconto" maxlength="2"
                                                        value="<?PHP if (isset($desconto)) {
                                                            print $desconto;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="desconto_boleto">Desconto para boleto
                                                        (em porcentagem)</label>
                                                    <input type="number" min=0 class="form-control" id="desconto_boleto"
                                                        name="desconto_boleto" maxlength="2"
                                                        value="<?PHP if (isset($desconto_boleto)) {
                                                            print $desconto_boleto;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="max_parcelas">Parcelamento máximo
                                                        *</label>
                                                    <input type="number" min=1 class="form-control" id="max_parcelas"
                                                        name="max_parcelas" maxlength="2"
                                                        value="<?PHP if (isset($max_parcelas)) {
                                                            print $max_parcelas;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="estoque">Estoque *</label>
                                                    <input type="number" min=0 class="form-control" id="estoque"
                                                        name="estoque" maxlength="10"
                                                        value="<?PHP if (isset($estoque)) {
                                                            print $estoque;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="min_estoque">Estoque mínimo *</label>
                                                    <input type="number" min=1 class="form-control" id="min_estoque"
                                                        name="min_estoque" maxlength="2"
                                                        value="<?PHP if (isset($min_estoque)) {
                                                            print $min_estoque;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fabrica">Fábrica *</label>
                                                    <input type="text" class="form-control" id="fabrica"
                                                        name="fabrica" maxlength="50"
                                                        value="<?PHP if (isset($fabrica)) {
                                                            print $fabrica;
                                                        } ?>" <?PHP print $editar; ?> />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="descricao">Descrição *</label>
                                                    <input type="text" class="form-control" id="descricao"
                                                        name="descricao" maxlength="1000"
                                                        value="<?PHP if (isset($descricao)) {
                                                            print $descricao;
                                                        } ?>"
                                                        <?PHP print $editar; ?> />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <?PHP if ($acao == "ins" or $acao == "alt") { ?>

                                    <div class="col-md-12">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                            <li class="nav-item">
                                                <a class="btn btn-secondary"
                                                    href="cad_miniaturas_grid.php?<?php if (isset($id)) { ?>id=<?PHP print $id;
                                                    } ?>">
                                                    Cancelar</a>
                                            </li>
                                            <li class="nav-item">
                                                <input type="submit" value="Cadastrar" class="btn btn-primary">
                                                <!--<a class="btn btn-primary" href="cad_miniaturas.php?acao=ins&amp;titulo=Inclusão de registro"> Cadastrar</a>-->
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="acao" value="<?PHP print $acao; ?>" />
                                    <input type="hidden" name="id" value="<?PHP if (isset($id)) {
                                        print $id;
                                    } ?>" />
                                <?PHP } ?>
                                <?PHP if ($acao == "exc") { ?>
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                            <li class="nav-item">
                                                <input type="image" name="imageField" src="../imagens/btn_excluir.gif" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                    href="cad_miniaturas_grid.php?id=<?PHP print $id; ?>"><i
                                                        class="bx bx-shopping-bag me-1"></i> Não excluir</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="acao" value="<?PHP print $acao; ?>" />
                                    <input type="hidden" name="id" value="<?PHP print $id; ?>" />
                                <?PHP } ?>
                                <?PHP if ($acao == "ver") { ?>
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                    href="cad_miniaturas_grid.php?id=<?PHP print $id; ?>"><i
                                                        class="bx bx-shopping-bag me-1"></i> Fechar</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?PHP } ?>
                            </div>
                        </form>

                        <hr class="my-5" />

                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="./assets/vendor/libs/jquery/jquery.js"></script>
    <script src="./assets/vendor/libs/popper/popper.js"></script>
    <script src="./assets/vendor/js/bootstrap.js"></script>
    <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="./assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>

<?PHP
// Libera os recursos usados pela conexão atual
if (isset($rs)) {
    mysqli_free_result($rs);
    mysqli_close($conexao);
}
?>