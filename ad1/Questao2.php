<?php
function verificaFormato($cpf) {
	if (preg_match('([0-9]{3}[\.][0-9]{3}[\.][0-9]{3}[\-][0-9]{2}|[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2})', $cpf) == 1) {
        return 1;
	} else {
		return 0;
	}
}

function removPontoTraco($cpf) {

	$cpfLimpo = str_replace(".", "", $cpf);
	$cpfLimpo = str_replace("-", "", $cpfLimpo);
	return $cpfLimpo;
}

function calculaDv($cpfParte) {

    $array_lenght = strlen($cpfParte);
    $mult = ($array_lenght + 1);
    //echo $mult;
    $valor = 0;

	for($i = 0; $i < $array_lenght; $i ++){
		$valor += $mult * intval($cpfParte[$i]);
        $mult = $mult - 1;
	}

	$resto = $valor % 11;
	if($resto < 2) {
		return 0;
	} else {
		return (11 - $resto);
	}

}

function validaCpf($cpf) {

    //para validar o formato do cpf
	if(verificaFormato($cpf) == 1) {
		
		//se o formato for válido, executará este bloco de código
		$cpfLimpo = removPontoTraco($cpf);
		//separar o cpf para fazer a verificação
		$cpfParte1 = substr($cpfLimpo, 0, 9);
		$cpfParte2 = substr($cpfLimpo, 0, 10);
		$cpfDv = substr($cpfLimpo, 9, 2);
        //para encontrar o resto e comparar com o dv do cpf
		$dig1 = calculaDv($cpfParte1);
		$dig2 = calculaDv($cpfParte2);
		
		if ($cpfDv[0] == $dig1 && $cpfDv[1] == $dig2){
			return 'cpf valido!';
		} else {
			return 'cpf invalido!';
		}
	} else {
		return 'cpf invalido!';
	}
}

//testes
$cpfValido1 = validaCpf("146.279.369-07");
echo "$cpfValido1<br>";
$cpfValido2 = validaCpf("14627936907");
echo "$cpfValido2<br>";
$cpfInvalido1 = validaCpf("146.279.369-30");
echo "$cpfInvalido1<br>";
$cpfInvalido2 = validaCpf("14627936930");
echo "$cpfInvalido2<br>";
$cpfInvalido3 = validaCpf("146.279369-07");
echo "$cpfInvalido3<br>";
?>
