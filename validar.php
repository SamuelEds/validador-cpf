<?php  

if(!isset($_SESSION)){
	session_start();
}

$cpf = $_POST['cpf'];

if(isset($cpf)){
	
	/*-------S-E-Q-U-Ê-N-C-I-A--DE--F-U-Ç-Õ-E-S--P-A-R-A--C-P-F-------*/

	//CRIA UM ARRAY PARA PEGAR A STRING DO INPUT DO CPF

	$numeros = array();

	//'recorta' A STRING PELOS '.'
	$numeros = explode('.', $cpf);

	//RECORTA DO ARRAY '$numeros' PARA CADA GRUPO DE 3 NÚMEROS
	$primeiros3Numeros = array_slice($numeros, 0, -2);
	$segundo3Numeros = array_slice($numeros, 1, -1);

	//RECORTA A ÚLTIMA POSIÇÃO '000-21'
	$numerosFinais = array_slice($numeros, 2);
	$numerosFinaisRecortados = explode('-', $numerosFinais[0]);

	//JUNTA TODOS OS ARRAY EM UM SÓ ARRAY
	$tudoJunto = array_merge_recursive($primeiros3Numeros, $segundo3Numeros, $numerosFinaisRecortados);	

	//CONVERTER AS POSIÇÕES EM UMA STRING
	$converterTudoEmString = implode('', $tudoJunto);

	//SEPARA TODOS OS NÚMEROS QUE FICARAM JUNTOS EM ARRAY
	$tudoSeparado = str_split($converterTudoEmString);

	//RECORTAR OS 9 PRIMEIROS DÍGITOS PARA FAZER A MULTIPLICAÇÃO ORDENADA
	$numerosParamultiplicacaoOrdenada = array_slice($tudoSeparado, 0, 9);

	//****LÓGICA QUE FAZ O CÁLCULO PARA VER SE O CPF É VÁLIDO****//

	//MULTIPLICAÇÃO ORDENADA
	$posicaoOrdenadaParamultiplicar = 11;

	for ($i = 0; $i < 9; $i++) { 
		$posicaoOrdenadaParamultiplicar--; 
		$numerosParamultiplicacaoOrdenada[$i] *= $posicaoOrdenadaParamultiplicar;
	}

	//SOMA DE TODAS AS POSIÇÕES
	$somaTotal = 0;
	for ($i = 0; $i < 9; $i++) { 
		$somaTotal += $numerosParamultiplicacaoOrdenada[$i]; 
	}

	//VERIFICAR SE O RESTO DA DIVISÃO POR É MAIOR OU IGUAL A 2, OU MENOR QUE 2
	$resultadoSomaTotalPorDez = $somaTotal * 10; //MULTIPLICAR A SOMA TOTAL POR 10

	$digito01 = false; //VERIFICAR SE O PRIMEIRO DÍGITO DEPOIS DO '-' ESTÁ CERTO

	if($resultadoSomaTotalPorDez % 11 == $tudoSeparado[9]){

		$digito01 = true;

	}else if($resultadoSomaTotalPorDez % 11 == 10){ //SE FOR IGUAL A 10...

		if($tudoSeparado[9] == 0){ //VAI VERIFICAR SE O DÉCIMO DÍGITO É IGUAL A 0
			$digito01 = true;
		}else{
			$digito01 = false;
		}

	}else{
		$digito01 = false;
	}

	$numerosParamultiplicacaoOrdenada = array_slice($tudoSeparado, 0, 10);

	//MESMA REGRA APLICADA PARA O DÉCIMO PRIMEIRO DÍGITO
	$posicaoOrdenadaParamultiplicar = 11;

	for ($i = 0; $i < 10; $i++) { 
		$numerosParamultiplicacaoOrdenada[$i] *= $posicaoOrdenadaParamultiplicar;
		$posicaoOrdenadaParamultiplicar--;
	}

	//SOMA DE TODAS AS POSIÇÕES
	$somaTotal = 0;
	for ($i = 0; $i < 10; $i++) { 
		$somaTotal += $numerosParamultiplicacaoOrdenada[$i];
	}

	//VERIFICAR SE O RESTO DA DIVISÃO POR É MAIOR OU IGUAL A 2, OU MENOR QUE 2
	$resultadoSomaTotalPorDez = $somaTotal * 10;

	$digito02 = false; 

	if($resultadoSomaTotalPorDez % 11 == $tudoSeparado[10]){ //VERIFICAR SE O SEGUNDO DÍGITO DEPOIS DO '-' ESTÁ CERTO
		
		$digito02 = true; 

	}elseif($resultadoSomaTotalPorDez % 11 == 10){ 

		if($tudoSeparado[10] == 0){ 
			$digito02 = true;
		}else{
			$digito02 = false;
		}

	}else{
		$digito02 = false;
	}

	//VARIÁVEL QUE IRÁ VERIFICAR SE O CPF É VÁLIDO OU NÃO
	$cpfValido = false;

	if($digito01 && $digito02){
		$cpfValido = true;
	}else{
		$cpfValido = false;
	}


	//VERIFICAR SE OS NÚMEROS DOS CPFs SÃO REPETIDOS
	$repetidos = 0;

	for ($i = 0; $i < 12; $i++) { 
		if(($i + 1) < count($tudoSeparado)){
			if($tudoSeparado[$i] == $tudoSeparado[$i + 1]){
				$repetidos++;
			}
		}
	}

	if($repetidos >= 10){
		$cpfValido = false;
	}

	//ARMAZENAR O RESULTADO DE TODA A VERIFICAÇÃO EM UMA VARIÁVEL GLOBAL
	$_SESSION['cpfValido'] = $cpfValido;

}

//REDIRECIONAR PARA O INDEX
header("Location: index.php");

?>