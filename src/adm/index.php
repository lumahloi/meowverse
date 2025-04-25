<?PHP
include "../inc_dbConexao.php";
SESSION_START();
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
?>

<!DOCTYPE html>

<html
  lang="pt-br"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="./assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Admin Meowverse</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="./assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./assets/css/demo.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="./assets/vendor/css/pages/page-auth.css" />
    <script src="./assets/vendor/js/helpers.js"></script>
    <script src="./assets/js/config.js"></script>

	<script language="javascript">
		//<!-- Valida campos do formulário de entrega (usuários já cadastrados) -->
		function valida_form() {
			if (document.form_login.login.value == "") {
				alert("Por favor, preencha o campo [Login].");
				form_login.login.focus();
				return false;
			}
			if (document.form_login.senha.value == "") {
				alert("Por favor, preencha o campo [Senha].");
				form_login.senha.focus();
				return false;
			}
			return true;
		}
	</script>
  </head>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <span class="app-brand-text demo text-body fw-bolder">Administração do Site</span>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Acesso restrito à administração</h4>
              <p class="mb-4">Insira suas credenciais de login</p>
			  <p class="mb-4 text-danger"><strong><?PHP print $_SESSION['mensagem_erro']; ?></strong></p>

              <form id="formAuthentication" class="mb-3" action="login_usuario.php" method="POST" name="form_login">
                <div class="mb-3" onsubmit="return valida_form(this);">
                  <label for="email" class="form-label">Login</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="login"
                    placeholder="Login"
					maxlength="30"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Senha</label>
                    <a href="auth-forgot-password-basic.html">
                      <small>Esqueceu a senha?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="senha"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
					  maxlength="8"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Continuar</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="./assets/vendor/libs/jquery/jquery.js"></script>
    <script src="./assets/vendor/libs/popper/popper.js"></script>
    <script src="./assets/vendor/js/bootstrap.js"></script>
    <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="./assets/vendor/js/menu.js"></script>
    <script src="./assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

