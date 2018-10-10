<?php
require_once 'lib/bancoDeDados.php';

session_start ();

if (formularioEnviado ()) {
	if (conectar ()) {
		executarSQL ( "select cod from Usuario where login='{$_POST["login"]}' and senha='{$_POST["senha"]}'" );

		$arrResultado = recuperarResultados ();

		if (count ( $arrResultado ) > 0) {
			// sucesso!!!!!
			$_SESSION ["cod"] = $arrResultado [0] ["cod"];
		}
	}
}

desconectar ();

if (isset ( $_SESSION ["cod"] )) {
	header ( "location: inserirfotos.php" );
	return;
}
function formularioEnviado() {
	return isset ( $_POST ["login"] ) && isset ( $_POST ["senha"] );
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Login</title>
<link rel="stylesheet" href="estilo.css" />
</head>
<body>
<div id="caixaGrande">
<div id="caixaPequena">

<header>LOGIN</header>

	<form action="index.php" method="post">
	<br>
	<br>
		<input type="text" name="login" placeholder="Nome"/> <br><br>
		<input type="password" name="senha" placeholder="Senha" />
		<br><br><br><br><br><input type="submit" value="Entrar" id="Botoes"/>
	</form>
	
</div>
</div>
</body>
</html>






























