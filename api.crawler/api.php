<!DOCTYPE html>
<html>
<head>

	<title>Resultados</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="_css/estilo.css">

</head>

<body>

	<div>

	<?php

		if(!isset($_POST)||empty($_POST)){ //esta verificação atua na validação dos dados, caso o usuário/cliente entre direto pelo url da api, que ele não veja erros do compilador, apenas receba a mensagem de que não há valores válidos e tenha a opção de voltar

			echo "Valores n&atildeo definidos.";
		}
		else{

			$url = $_POST["link"]; //recebe a url via "post"

			$palavra_chave = $_POST["palavra"]; //recebe a palavra à ser procurada via "post"

			$ch = curl_init(); //neste momento, iniciei o processo da biblioteca CURL, a variável $ch usa-se como auxiliar, na captura dos dados da url desejada

			curl_setopt($ch, CURLOPT_URL, "$url"); //aqui, passei o parâmetro URL

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //setei a função CURLOPT_RETURNTRANSFER em "TRUE" para que os valores retornados viessem como string

			$conteudo = curl_exec($ch); //aqui é onde ele capta os dados na URL, e os armazena em $conteudo

			curl_close($ch); //finalizo o processo iniciado anteriormente

			$conteudo = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $conteudo)); //aqui, retirei os acentos de $conteudo obtido da URL

			$palavra_chave = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra_chave));//aqui, retirei os acentos da palavra chave, com o intuito de prevenir contra erros de digitação do usuário

			$conteudo = strtolower($conteudo);//aqui, passei o conteudo da URL para caracteres de caixa baixa, para ampliar a precisão da busca, pois a função escolhida é case sensitive
			$palavra_chave = strtolower($palavra_chave);//aqui, passei o conteúdo da palavra_chave informada para caracteres de caixa baixa para evitar erros de digitação do usuário e aumentar a precisão da busca

			$total_ocorrencias = substr_count($conteudo, $palavra_chave);//aqui fiz a varredura dos dados obtidos da URl, contando a quantidade de ocorrências da palavra chave informada

			$result = array('Palavra' => $palavra_chave,
				'Ocorr&ecircncias' => $total_ocorrencias, //nestas linhas, passei as informações para uma array, afim de facilitar a transferência para o formato json
				'URL' => $url
			);

			$result= json_encode($result); //Aqui fiz a passagem da array em que armazenei os dados obtidos, para o formato json

			echo "$result"; //e por fim, printei os valores no formato json

			//não fiz uma verificação de caso a palavra-chave não exista no link informado, pois foi solicitado que os valores fossem armazenados em json

		}
	?>

	<a href="arquivo.html"> Voltar</a>

	</div>

</body>
</html>