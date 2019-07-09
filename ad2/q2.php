<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Questão2</title>
</head>
<body>

<?php

$erroNome = $erroEmail = $erroCPF = $nome = $email = $CPF = $endereco = $email = $totalLinha = '';

//testa se os dados foram recebidos por POST
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["CPF"]) && isset($_POST["endereço"])) {
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$CPF = $_POST["CPF"];
	$endereco = $_POST["endereço"];

	//verificações de campos do formulário

    //verificar o campo NOME
    if (preg_match('([A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ])', $nome) == 0) {
    	$erroNome = "Favor inserir somente caracteres alfabéticos neste campo.";
    }

    //verificar o campo EMAIL
    if (preg_match('([a-zA-Z0-9]+@[a-zA-Z0-9]+.)', $email) == 0) {
    	$erroEmail = "Favor inserir um email válido.";
    }

    //verificar o CPF
    $resultValidacao = validaCpf($CPF);
    if($resultValidacao == 0) {
    	$erroCPF = "Favor inserir um CPF válido.";
    } else {
    	$cpfLimpo = $resultValidacao[0];
    }

    //se as  variáveis foram validadas, conectará ao mysql
    if( ($erroNome == '') && ($erroEmail == '') && ($erroCPF == '') && ($erroEmail == '')) {

    	$conecta = mysqli_connect('localhost', 'root', '', '');
    	if(!$conecta) {
	         //echo "Nao conectou ao MySQL.";
    		exit();
    	} else {
    	    //echo "Conectou ao MySQL.";
    		mysqli_select_db($conecta, 'questaodois');

		    //verifica aqui se o CPF inserido no campo já existe cadastrado
		    $verificaCPF = "SELECT cpf FROM usuario WHERE cpf = '$cpfLimpo'";
		    $resultadoVerificaCPF = mysqli_query($conecta, $verificaCPF); 
		    $totalLinha = mysqli_num_rows($resultadoVerificaCPF);

		    if ($totalLinha == 1) {
		    	echo "CPF já existente!";

		//se a consulta não retornar cpf já existente, fará a inserção do novo
		    } else {
		    	$insercaoSQL = "INSERT INTO usuario (nome, cpf, endereco, email) VALUES ('$nome', '$cpfLimpo', '$endereco', '$email')";
		    	$resultadoInsercaoSQL = mysqli_query($conecta, $insercaoSQL);
		    }	
		}
	}  
}


//funções de verificação do CPf
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
			return array($cpfLimpo);
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}


?>
	
	<form name="form" method="post" action="q2.php">

		Nome: <br>
		<input type="text" id="nome" name="nome"><label><?php echo $erroNome; ?></label><br><br>
		
		CPF: <br>
		<input type = "text" id="CPF" name="CPF"><label><?php echo $erroCPF; ?></label><br><br>
		
		Endereço: <br>
		<input type ="text" id="endereço" name="endereço"><br><br>
		
		Email: <br>
		<input type="text" id="email" name="email"><label><?php echo $erroEmail; ?></label><br><br>
		
		
		<input type="submit" value="Enviar" onclick="return validarForm()">
	
	</form>
	
	<script type="text/javascript">

	//validação em javascript
	function vazio(str) {
		var v = document.getElementById(str).value;
		if (v.length == 0){
			return true;
		}
	}

    function validarForm() {
    	if(vazio("nome") || vazio("CPF") || vazio("endereço") || vazio("email")) {
    		alert("Favor preencher todos os campos.");
    		return false;
    	}
    	return true;
    }
	
	</script>

</body>
</html>