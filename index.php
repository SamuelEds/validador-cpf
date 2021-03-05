<?php 

if(!isset($_SESSION)){
	session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Validador de CPF</title>

	<!--TODAS AS IMPORTAÇÕES PARA CONFIGURAÇÕES DE ESTILOS E FONTES-->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Recursive:wght@400;800&display=swap" rel="stylesheet">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;700&display=swap" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
	
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;800&family=Roboto+Mono:wght@300;700&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="container">
		<div class="conteudo">
			
			<div class="titulo">
				<h2>VALIDADOR DE CPF</h2>
			</div>

			<div class="formulario">
				<form action="validar.php" method="post">
					<input type="text" class="cpf form-control" name="cpf" id="cpf" placeholder="000.000.000-00" required="true" pattern="/d{3}).d{3}).d{3})-d{2})/" autocomplete="off">
					<br />
					<button type="submit">Validar</button>
				</form>
			</div>
		</div>
	</div>

	<script src="js.js"></script>

	<script type="text/javascript">
		<?php if($_SESSION['cpfValido']){ ?>

			Swal.fire('CPF Válido', 'O CPF inserido é válido', 'success');
			<?php unset($_SESSION['cpfValido']); ?>

		<?php }elseif(!$_SESSION['cpfValido']){ ?>

			Swal.fire('CPF Inválido', 'O CPF inserido é inválido', 'error');
			<?php unset($_SESSION['cpfValido']); ?>

		<?php } ?>
	</script>
	
</body>
</html>