
<?php

echo '<link rel="stylesheet" href="../inventario/CSS/estilo_menu.css" type="text/css">';
//echo '<script src="../inventario/JS/jquery-latest.js"></script>';
//echo '<script  src="../inventario/JS/main.js"></script>';
echo ' <nav class="menu-fixed">

<ul>
		<li><a title="Inicio" href="../inventario/index.html">Buscar Sitio</a></li>
		<!--<li><a title="Cargar Excel" href="../inventario/excel/index.html">Cargar Excel</a></li>-->
		<li><a title="Opcion 4" href="../inventario/eliminar.html">Eliminar Sitio</a></li>
		<li><a title="Opcion 3" href="../inventario/backup/backup.php">Backup</a></li>
</ul>
</nav> ';

//***Pagina de la libreria  https://github.com/picqer/php-barcode-generator

require 'conex.php';
require_once 'src/BarcodeGenerator.php';
require_once 'src/BarcodeGeneratorPNG.php';

$subs_id = utf8_decode($_POST['id']);
$query1 = "Select location from sitios where location = '$subs_id '";
$total = mysqli_num_rows($mysqli->query($query1));

if ($total == 0) {
    //echo   "No hay nada";

    echo
        '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../inventario/excel/index.html">
				   <script>
					   alert("No se encuentra el Sitio Por favor cargar Excel!!!!!!");
				   </script>';

} else {

    $sql = "SELECT mic_code, inventario FROM sitios  WHERE (inventario= 'OK' OR inventario='DIFFERENCE') and location = '" . $subs_id . "'  ";
    $resultado = $mysqli->query($sql);

    $sql2 = "SELECT serial FROM sitios WHERE (inventario= 'OK' OR inventario='DIFFERENCE') and location = '" . $subs_id . "' ";
    $resultado2 = $mysqli->query($sql2);

    $sql3 = "SELECT  location FROM sitios WHERE location = '" . $subs_id . "' LIMIT 1 ";
    $resultado3 = $mysqli->query($sql3);

    ?>
	<br><br><br><br>

				<h1>Seriales del sitio  <?php while ($row3 = $resultado3->fetch_assoc()) {
        echo $row3['location'] . "<br>";}?> </h1>

				<?php

    $i = 0;

    while (($row = $resultado->fetch_assoc()) && ($row2 = $resultado2->fetch_assoc()) && ($i += 1)) {
        ?>
				<link rel="stylesheet" href="CSS/tabla.css">
		<table  style=’table-layout:fixed’; >


			<tr>

				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>


			</tr>


			<tr>

				<td style="text-align:left;">
					<?php
echo '#' . $i . '--' . '<font color= "red">' . $row['inventario'] . '</font>';
        ?>
				</td>

				<td style="text-align:center;" >
					<?php
echo '&nbsp;&nbsp;&nbsp;&nbsp; ';
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row['mic_code'], $generator::TYPE_CODE_128, 1, 50)) . '">';

        ?>

				</td>

				<td style="text-align:center;" >
					<?php

        echo '&nbsp;&nbsp;&nbsp;&nbsp; ';
        $generator2 = new \Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator2->getBarcode($row2['serial'], $generator2::TYPE_CODE_128, 1, 50)) . '">';

        ?>
				</td>
			<tr>

				</br></br></br>
			<tr>
							<td style="text-align:center;" >
								<?php
echo '&nbsp;&nbsp;&nbsp;';
        ?>
							</td>

							<td style="text-align:center;" >
								<?php
//echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo $row['mic_code'];

        ?>
							</td>
							<td style="text-align:center;" >
								<?php

        //    echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo $row2['serial'];

        ?>
							</td>
				<tr>
		</table>

<?php
}}

?>
