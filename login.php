<?PHP
// +---------------------------------------------------------+
// | Login do cliente                                        |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

// cadastro = S (se entrada for pelo menu Meu cadastro(neste caso exibe o menu de categorias))
// cadastro = "" se entrada for pelo carrinho de compras (neste caso exibe as etapas de uma compra e
// não exibe o menu superior e menu  de categorias)
$_SESSION['cadastro'] = $_GET['cadastro'];

// Armazena na variavel de sessao o modo de visualização cadastral
$_SESSION['acao'] = "ver";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça um Site - PHP 5 com Banco de Dados MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script language="javascript">
		//Valida campos do formulário de entrega (usuários já cadastrados)-->
		function valida_form() {
			if (document.form_cadastro.txtemail1.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail1.focus();
				return false;
			}
			if (document.form_cadastro.txtsenha1.value == "") {
				alert("Por favor, preencha o campo [Senha].");
				form_cadastro.txtsenha1.focus();
				return false;
			}
			return true;
		}

		// Valida campos do formulário de cadastro (novos usuários) -->
		function valida_form1() {
			if (document.form_cadastro.txtemail2.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail2.focus();
				return false;
			}
			return true;
		}
	</script>
</head>
<body>
    <div class="container">
        <?PHP include "inc_menu_superior.php" ?>
		<?PHP include "inc_menu_categorias.php" ?>

        <!-- Se clicado no botão Meu cadastro do menu superior -->
		<?PHP if (['cadastro'] == "S") { ?>
			<?PHP $tit_etapa = "Meu Cadastro"; ?>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
		<?PHP } else { ?>
			<?PHP $tit_etapa = "Etapa 1"; ?>
		<?PHP } ?>

        <div class="row">
            <h2 class="mt-5"><?PHP print $tit_etapa; ?> <img src="imagens/marcador_setaDir.gif" /> Identificação</h2>
        </div>

        <div class="row mt-5 d-grip gap-3">
            <div class="form-group col bg-light border p-3 mx-auto">
                <form name="form_entrega" method="post" action="login1.php" onsubmit="return valida_form(this);">
                    <h3 class="mt-2 mb-4">Já sou cadastrado</h3>
                    <p>Para prosseguir, por favor, identifique-se utilizando os campos abaixo e depois clique no botão "Continuar".</p>
                    <p>(1) Para testar corretamente o projeto deste site é fundamental que você utilize uma conta de e-mail válida.</p>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="email">(1) Seu e-mail: </label>
                        </div>
                        <div class="col-md-7">
                            <input type="email" name="txtemail1" id="txtemail1" class="form-control" placeholder="Insira seu e-mail">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="senha">Sua senha: </label>
                        </div>
                        <div class="col-md-7">
                            <input type="password" name="txtsenha1" id="txtsenha1" class="form-control" placeholder="Insira sua senha">
                        </div>
                    </div>
                    <div class="row mt-4 justify-content-between">
                        <div class="text-center">
                            <a class="btn btn-secondary" href="senha.php">Esqueci minha senha</a>
                            <input type="submit" value="Continuar" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>

            <div class="form-group col bg-light border p-3 mx-auto">
                <form action="cadastro.php" name="form_cadastro" method="post" onsubmit="return valida_form1(this);">
                    <h3 class="mt-2 mb-4">Quero me cadastrar</h3>
                    <p>Caso esta seja sua primeira compra na Faça um Site miniaturas, preencha o campo com seu e-mail e clique no botão "Continuar".</p>
                    <p>(1) Para testar corretamente o projeto deste site é fundamental que você utilize uma conta de e-mail válida.</p>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="email">(1) Seu e-mail: </label>
                        </div>
                        <div class="col-md-7">
                            <input type="email" name="txtemail2" id="txtemail2" class="form-control" placeholder="Insira seu e-mail" maxlength="60">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="senha">Sua senha: </label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="txtsenha2" id="txtsenha2" class="form-control" value="Será solicitada na próxima etapa" readonly>
                        </div>
                    </div>
                    <div class="row mt-4 d-flex">
                        <div class="text-center">
                            <input type="submit" value="Continuar" class="btn btn-success">
                        </div>
                    </div>
                    <input type="hidden" name="acao" value="inc" />
                </form>
            </div>
        </div>

        <?PHP include "inc_rodape.php" ?>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </div>

</body>
</html>