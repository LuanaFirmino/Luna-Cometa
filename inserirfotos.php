<?php 
require_once './lib/bancoDeDados.php';
if (! conectar ()) {
	echo "Falha ao atualizar o banco de dados!";
	return;
}

session_start ();

if (! isset ( $_SESSION ["cod"] )) {
	header ( "location: index.php" );
	return;
}

$codDono = $_SESSION ["cod"];

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Inserir imagens</title>
	<link rel="stylesheet" href="estilo.css" />
</head>
<body>
<div id="caixaGrande">
<div id="insere">
	<form action="inserirfotos.php" method="post" enctype="multipart/form-data">

		<label for="descricao">Descrição da foto</label>
		<input type="text" name="descricao"/><br/><br/>
		
		<label for="arquivo">Escolha um arquivo</label>
		<input type="file" name="arquivo"/><br/><br/>

		<label for="visibilidade">Imagem publica?</label>
		<input type="checkbox" name="visibilidade"/><br/><br/>
		
		<select name="canal">
		<?php
		executarSQL ( "select cod, nome from Canal where dono='$codDono'" );
		$arrResultados = recuperarResultados ();

		foreach ( $arrResultados as $linha ) {
			?>
			<option value="<?php echo $linha["cod"]; ?>" > <?php echo $linha["nome"]; ?> </option>
			<?php 
		}
		?>
		</select>
		<br/><br/>
		<input type="submit" id="Botoes" value="Enviar">
		<a href="exibeImage.php"><input type="button" id="Botoes" value="Imagens"></a>
	</form>
	</div>
	</div>
</body>
</html>
<?php
function formularioEnviado() {
	return isset ( $_POST ["descricao"] ) && isset ( $_FILES ["arquivo"] ) && isset ( $_POST ["visibilidade"] );
}
if (formularioEnviado ()) {

	$nomeDoArquivo = rand () . microtime ( true ) . "." . end ( explode ( ".", $_FILES ["arquivo"] ["name"] ) );
	$caminhoDoArquivo = $_FILES ["arquivo"] ["tmp_name"];

	$descricao = $_POST ["descricao"];
	$visibilidade = $_POST ["visibilidade"] == "on" ? 1 : 0;

	$destino = "./image/$nomeDoArquivo";
    $resultado= move_uploaded_file ( $caminhoDoArquivo, $destino );

    if ($resultado) {

		$sql = "insert into Foto (nome, descricao, visibilidade, cod_canal) values	('$nomeDoArquivo','$descricao',$visibilidade,'$codDono')";
		executarSQL ( $sql );
	} else {
		echo "Falha ao enviar a imagem!";
	}
}
desconectar ();
?>












