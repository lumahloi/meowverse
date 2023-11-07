<?PHP
// Função cálculo da média entre 4 números
function media($n1,$n2,$n3,$n4) {
  $x = ($n1 + $n2 + $n3 + $n4)/4;
  Return $x;
}

// Função formatar CNPJ
function formatar_cnpj($n) {
  $cnpj_formatado = substr($n,0,2).".".substr($n,2,3).".".substr($n,5,3)."/".substr($n,8,4)."-".substr($n,12,2);
  return $cnpj_formatado;
}
?>

