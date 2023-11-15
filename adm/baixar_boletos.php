<?PHP
include "../inc_dbConexao.php";
SESSION_START();

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
$titulo_pagina = "Baixa de boletos";

// Seleciona registros
$sql = "SELECT * FROM pedidos ";
$sql .= " WHERE status = 'Aguardando pagamento do boleto' ";
$sql .= " ORDER BY id ASC ";

$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);

// INSERE ZEROS À ESQUERDA DE UM NÚMERO
// Parmetros: $numero = número considerado, $zeros = tamanho do número (com zeros)
function zero_esquerda($numero,$zeros) {	
// Retira o ponto decimal do número	
$numero = str_replace(".","",$numero);
// Define o número de zeros a serem inseridos à esquerda do número
$loop = $zeros - strlen($numero);				
for($i=0; $i < $loop; $i++) {
$numero = "0" . $numero;
}
return $numero;
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
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">

          <span class="app-brand-text demo menu-text fw-bolder ms-2">Meowverse</span>


          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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

          <li class="menu-item">
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

          <li class="menu-header small text-uppercase"><span class="menu-header-text">Contas a receber</span></li>

          <li class="menu-item active">
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

        <nav
          class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
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
                <a class="github-button" href="https://github.com/themeselection/sneat-html-admin-template-free"
                  data-icon="octicon-star" data-size="large" data-show-count="true"
                  aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star</a>
              </li>

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="./assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="./assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
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
                        <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Contas a Receber /</span> Baixar boletos</h4>

            <!-- Basic Bootstrap Table -->
            <div class="card">
              <h5 class="card-header">Total de registros encontrados:
                <?PHP print $total_registros; ?>
              </h5>

              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr>
                      <th>N° do pedido</th>
                      <th>Nosso Número</th>
                      <th>Status</th>
                      <th>Vencimento</th>
                      <th>Valor</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?PHP
                        while ($reg = mysqli_fetch_array($rs)) {
                        $id = $reg["id"];
                        $num_ped = $reg["num_ped"];
                        $status = $reg["status"];
                        $vencimento = $reg["vencimento"];
                        $valor = $reg["valor"];
                        $total = $total + $valor;
                    ?>
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                            <?PHP print $num_ped; ?>
                          </strong></td>

                        <td>
                            <?PHP print zero_esquerda($id,11); ?>
                        </td>

                        <td>
                          <?PHP print $status; ?>
                        </td>

                        <td>R$
                            <?PHP print substr($vencimento,8,2) . "/" . substr($vencimento,5,2) . "/" . substr($vencimento,0,4); ?>
                        </td>

                        <td>
                            <?PHP print number_format($valor,2,',','.'); ?>
                        </td>

                    <!-- Verifica se o vencimento do boleto está dentro do prazo de pagamento -->
                    <?PHP if($vencimento < date("Y-m-d")) { ?>
                    <!-- Exibe botão cancelar para boletos vencidos -->
                        <td>
                            <a href="cancelar_boletos1.php?acao=alt&id=<?PHP print $id; ?>&titulo=Baixa de boletos"><img src="../imagens/btn_cancbol.gif" alt="Baixar pagamento" width="55" height="16" border="0" /></a>
                        </td>
                    <?PHP } else { ?>
                    <!-- Exibe botão baixar para baixar o boleto -->
                        <td>
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" href="baixar_boletos1.php?acao=alt&id=<?PHP print $id; ?>&titulo=Baixa de boletos"></i>Baixar pagamento</a>
                                </li>
                                </ul>
                            </div>
                        </td>
                    <?PHP } ?>
                      </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="4">
                            <strong>Total a receber</strong>
                        </td>
                        <td>
                            <strong><?PHP print number_format($total,2,',','.'); ?></strong>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Basic Bootstrap Table -->

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
mysqli_free_result($rs);
mysqli_close($conexao);
?>