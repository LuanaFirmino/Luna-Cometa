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
<html>
<head>
<link rel="stylesheet" href="estilo.css" />
</head>
<body>
<?php executarSQL ( "select nome,descricao from Foto where cod_canal='$codDono'" );
$arrResultados = recuperarResultados ();
?>
  <table border="2px" align="center" >

		 <?php 
            foreach ( $arrResultados as $linha ) {
          ?> 
         <tr>
		  <td><img src="./image/<?php echo $linha["nome"];?>" id="tabelinea"></td>
		 </tr>
		  <td colspan="1"><?php echo $linha["descricao"];?></td>
			<?php 
		}?>
		
		 </table> 
		 <a href="inserirfotos.php"><input type="button" id="Btn" value="Voltar"></a>
</body>
</html>