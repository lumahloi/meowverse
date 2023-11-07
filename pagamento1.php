<?PHP
SESSION_START();

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

$txtnumero = $_POST['txtnumero'];
$txtnome = $_POST['txtnome'];
$txtmes = $_POST['txtmes'];
$txtano = $_POST['txtano'];
$txtcodigo = $_POST['txtcodigo'];
$txtparcelas = $_POST['txtparcelas'];
$form_pag = $_POST['form_pag'];

if ($form_pag == "boleto") {
// Executa a página boleto.php se $form_pag = boleto
print "<meta HTTP-EQUIV='Refresh' CONTENT='0; URL=boleto.php'>";
} else {

// Executa a página boleto.php se $form_pag = cartao
$_SESSION['nome_cartao'] = $form_pag;
$_SESSION['c_nome'] = strtoupper ($txtnome);
$_SESSION['c_numero'] = $txtnumero;
$_SESSION['c_mes'] = $txtmes;
$_SESSION['c_ano'] = $txtano;
$_SESSION['c_codigo'] = $txtcodigo;
$_SESSION['c_parcelas'] = $txtparcelas;

print "<meta HTTP-EQUIV='Refresh' CONTENT='0; URL=cartao.php'>";
}
