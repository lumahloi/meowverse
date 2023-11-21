<?PHP

SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


if ($_POST['txtemail2'] <> "") {
  $txtemail2 = $_POST['txtemail2'];
  $_SESSION['acao'] = $_POST['acao'];
} else {
  $_SESSION['acao'] = "alt";
}

if ($_GET['txtemail2'] <> "") {
  $txtemail2 = $_POST['txtemail2'];
  $_SESSION['acao'] = "alt";
}

// INCLUSÃO DE NOVOS REGISTROS
// Verifica se o e-mail já está cadastro.
// Se o cliente estiver cadastrado $total_registros = 1; caso contrário será igual a 0.

if ($_SESSION['acao'] == "inc") {
  $sql = "select email from cadcli where email = '".$txtemail2."';";
  $rs = mysqli_query($conexao, $sql);
  $total_registros = mysqli_num_rows($rs);

  // Inicializa valores
  $txtnome = "";
  $txtcpf = "";
  $txtrg = "";
  $txtsexo = "0";
  $txtsenha_1 = "";
  $txtsenha_2 = "";
  $txtend_nome = "";
  $txtend_num = "";
  $txtend_comp = "";
  $txtcep = "";
  $txtbairro = "";
  $txtcidade = "";
  $txtuf = "";

  // Titulo da página
  $titulo_2 = "Inclusão";
}

// ALTERAÇÃO DE REGISTROS
// Recupera registro (campos armazenados nas variáveis de sessão
if ($_SESSION['acao'] == "alt") {
  // Inicializa valores
  $txtnome = $_SESSION['nome_cli'];
  $txtcpf = $_SESSION['cpf'];
  $txtrg = $_SESSION['rg'];
  $txtsexo = $_SESSION['sexo'];
  $txtemail2 = $_SESSION['email_cli'];
  $txtemail_2 = $_SESSION['email_cli'];
  $txtsenha_1 = $_SESSION['senha'];
  //$txtsenha_2 = $_SESSION['senha'];
  $txtend_nome = $_SESSION['end_nome'];
  $txtend_num = $_SESSION['end_num'];
  $txtend_comp = $_SESSION['end_comp'];
  $txtcep = $_SESSION['cep'];
  $txtbairro = $_SESSION['bairro'];
  $txtcidade = $_SESSION['cidade'];
  $txtuf = $_SESSION['uf'];

  //Titulo da página 
  $titulo_2 = "Alteração";
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

  <style>
    .mostrar-senha {
      cursor: pointer;
      user-select: none;
    }
  </style>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>

  <script type="text/javascript">
    function mostrarSenha(senhaId) {
        var campo = document.getElementById(senhaId);
        
        if (campo.type === "password") {
          campo.type = "text";
        } else {
          campo.type = "password";
        }
    }

    function valida_form() {
      if (document.cadastro.txtnome.value == "") {
        alert("Por favor, informe seu nome completo.");
        cadastro.txtnome.focus();
        return false;
      }

      if (document.cadastro.txtcpf.value == "") {
        alert("Por favor, informe seu CPF.");
        cadastro.txtcpf.focus();
        return false;
      }

      if (document.cadastro.txtrg.value == "") {
        alert("Por favor, informe seu RG.");
        cadastro.txtrg.focus();
        return false;
      }

      function validarCPF(Objcpf) {
        var cpfUsuario = Objcpf.value;
        exp = /\.|\-/g;
        cpfUsuario = cpfUsuario.toString().replace(exp, "");
        var digitoDigitado = eval(cpfUsuario.charAt(9) + cpfUsuario.charAt(10));
        var soma1 = 0,
          soma2 = 0;
        var vlr = 11;

        for (i = 1; i <= 9; i++) {
          soma1 += eval(cpfUsuario.charAt(i) * (vlr - 1));
          soma2 += eval(cpfUsuario.charAt(i) * vlr);
          vlr--;
        }
        soma1 = (((soma1 * 10) % 11) === 10 ? 0 : ((soma1 * 10) % 11));
        soma2 = (((soma2 + (2 * soma1)) * 10) % 11);

        var digitoGerado = (soma1 * 10) + soma2;
        if (digitoGerado !== digitoDigitado) {
          alert('CPF Invalido!');
          Objcpf.value = '';
        } else if (digitoGerado === 00000000000) {
          alert('CPF Invalido!');
          Objcpf.value = '';
        }
      }

      if (document.cadastro.txtsexo.value == 0) {
        alert("Por favor, selecione seu gênero.");
        cadastro.txtsexo.focus();
        return false;
      }

      if (document.cadastro.txtemail2.value == "") {
        alert("Por favor, confirme seu e-mail.");
        cadastro.txtemail2.focus();
        return false;
      }

      if (document.cadastro.txtemail_2.value == "") {
        alert("Por favor, confirme seu e-mail.");
        cadastro.txtemail_2.focus();
        return false;
      }

      if (document.cadastro.txtemail2.value != document.cadastro.txtemail_2.value) {
        alert("O campo e-mail não confere com sua confirmação.");
        cadastro.txtemail2.value = "";
        cadastro.txtemail_2.value = "";
        cadastro.txtemail2.focus();
        return false;
      }

      if (document.cadastro.txtsenha_1.value.length < 5) {
        alert("O campo senha deve conter 5 ou mais caracteres.");
        cadastro.txtsenha_1.focus();
        return false;
      }

      if (document.cadastro.txtsenha_2.value.length < 5) {
        alert("O campo de confirmação da senha deve conter 5 ou mais caracteres.");
        cadastro.txtsenha_2.focus();
        return false;
      }

      if (document.cadastro.txtsenha_1.value != document.cadastro.txtsenha_2.value) {
        alert("O campo senha não confere com sua confirmação.");
        cadastro.txtsenha_1.value = "";
        cadastro.txtsenha_2.value = "";
        cadastro.txtsenha_1.focus();
        return false;
      }

      if (document.cadastro.txtend_num.value == "") {
        alert("Por favor, informe o número do seu logradouro.");
        cadastro.txtend_num.focus();
        return false;
      }

      return true;
    }

    $(document).ready(function () {

      function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#txtend_nome").val("");
        $("#txtbairro").val("");
        $("#txtcidade").val("");
        $("#txtuf").val("");
      }

      //Quando o campo cep perde o foco.
      $("#txtcep").blur(function () {
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

          //Expressão regular para validar o CEP.
          var validacep = /^[0-9]{8}$/;

          //Valida o formato do CEP.
          if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#txtend_nome").val("...");
            $("#txtbairro").val("...");
            $("#txtcidade").val("...");
            $("#txtuf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

              if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                $("#txtend_nome").val(dados.logradouro);
                $("#txtbairro").val(dados.bairro);
                $("#txtcidade").val(dados.localidade);
                $("#txtuf").val(dados.uf);
              } //end if.
              else {
                //CEP pesquisado não foi encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
              }
            });
          } //end if.
          else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
          }
        } //end if.
        else {
          //cep sem valor, limpa formulário.
          limpa_formulário_cep();
        }
      });
    });
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
            <strong class="text-black">Cadastro</strong>
          </div>
        </div>
      </div>
    </div>

    <?php
      print $total_registros;
    ?>

    <?PHP if ($total_registros == 0 or $_SESSION['acao'] == "alt") { ?>

      <div class="site-section">
        <div class="container">
          <form name="cadastro" method="post" action="cadastro1.php" onsubmit="return valida_form(this);">
          <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
              <h2 class="h3 mb-3 text-black">Dados Pessoais</h2>
              <div class="p-3 p-lg-5 border">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <label for="txtnome" class="text-black">Nome completo <span
                          class="text-danger">*</span></label></label>
                      <input type="text" class="form-control" id="txtnome" name="txtnome"
                        value="<?PHP print $txtnome; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="txtcpf" class="text-black">CPF <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="txtcpf" name="txtcpf" value="<?PHP print $txtcpf; ?>" onKeyPress="if(this.value.length==11) return false;">
                    </div>
                    <div class="col-md-6">
                      <label for="txtrg" class="text-black">RG <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="txtrg" name="txtrg" value="<?PHP print $txtrg; ?>" onKeyPress="if(this.value.length==9) return false;">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="txtsexo" class="text-black">Gênero <span class="text-danger">*</span></label>
                    <select name="txtsexo" id="txtsexo" class="form-control">
                      <?php
                      $generoSelecionado = isset($txtsexo) ? $txtsexo : "M"; // Define o gênero selecionado (padrão: Masculino)
                      $opcoesGenero = array(
                        "M" => "Masculino",
                        "F" => "Feminino",
                        "A" => "Agênero",
                        "N" => "Não Binário",
                        "O" => "Outro",
                        "P" => "Prefiro não responder"
                      );
                      foreach ($opcoesGenero as $abreviacao => $genero) {
                        $selected = ($generoSelecionado == $abreviacao) ? 'selected' : '';
                        echo "<option value='$abreviacao' $selected>$genero</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <label for="txtemail2" class="text-black">Email <span class="text-danger">*</span></label></label>
                      <input type="email" class="form-control" id="txtemail2" name="txtemail2" maxlength="60"
                        value="<?PHP print $txtemail2; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <label for="txtemail_2" class="text-black">Confirmar Email <span
                          class="text-danger">*</span></label></label>
                      <input type="email" class="form-control" id="txtemail_2" name="txtemail_2" maxlength="60"
                        value="<?PHP print $txtemail_2; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="txtsenha_1" class="text-black">Senha <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input type="password" class="form-control" id="txtsenha_1" name="txtsenha_1" maxlength="10"
                          value="<?PHP print $txtsenha_1; ?>">
                          <span onclick="mostrarSenha('txtsenha_1')" class="mostrar-senha icon icon-eye" aria-hidden="true"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="txtsenha_2" class="text-black">Confirmar senha <span class="text-danger">*</span></label>

                      <div class="input-group">
                        <input type="password" class="form-control" id="txtsenha_2" name="txtsenha_2" maxlength="10" value="<?PHP print $txtsenha_1; ?>">
                        <span onclick="mostrarSenha('txtsenha_2')" class="mostrar-senha icon icon-eye" aria-hidden="true"></span>
                      </div>

                    </div>


                  </div>
              </div>
            </div>

            <div class="col-md-6 mb-5 mb-md-0">
              <h2 class="h3 mb-3 text-black">Endereço de entrega</h2>
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtcep" class="text-black">CEP <span class="text-danger">*</span></label></label>
                    <input type="text" class="form-control" id="txtcep" name="txtcep" value="<?PHP print $txtcep; ?>" autocomplete="on" onKeyPress="if(this.value.length==8) return false;">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtend_nome" class="text-black">Rua</label>
                    <input type="text" class="form-control" id="txtend_nome" name="txtend_nome" readonly maxlength="60"
                      value="<?PHP print $txtend_nome; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtend_num" class="text-black">Número <span class="text-danger">*</span></label></label>
                    <input type="number" class="form-control" id="txtend_num" name="txtend_num" maxlength="10"
                      value="<?PHP print $txtend_num; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtend_comp" class="text-black">Complemento </label>
                    <input type="text" class="form-control" id="txtend_comp" name="txtend_comp" maxlength="50"
                      value="<?PHP print $txtend_comp; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="txtbairro" class="text-black">Bairro</label>
                    <input type="text" class="form-control" id="txtbairro" name="txtbairro" readonly maxlength="40"
                      value="<?PHP print $txtbairro; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="txtcidade" class="text-black">Cidade</label>
                    <input type="text" class="form-control" id="txtcidade" name="txtcidade" readonly maxlength="40"
                      value="<?PHP print $txtcidade; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtuf" class="text-black">Estado </label>
                    <input type="text" class="form-control" id="txtuf" name="txtuf" readonly
                      value="<?php print $txtuf ?>">
                  </div>
                </div>
              </div>
              <div class="row justify-content-md-end mt-5">
                  <div class="col-md-6">
                    <input type="submit" value="Continuar" class="btn btn-primary btn-block py-3">
                  </div>
                </div>
              
            </form>
            </div>
          </div>

          <!-- </form> -->
        </div>

    <?PHP } else { ?>
        <div class="row text-center mt-5">
							<div class="col">
								<h4 class="mb-3">
                  E-mail já cadastrado, utilize outro por favor.
								</h4>
							</div>
						</div>
						<div class="row text-center mb-5">
							<div class="col">
								<a href="javascript:history.go(-1)" class="btn btn-primary" role="button" aria-pressed="true">Voltar</a>
							</div>
						</div>
      <?PHP } ?>
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

mysqli_close($conexao);
?>