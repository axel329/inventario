
<?php
echo '<link rel="stylesheet" href="../CSS/tabla.css" type="text/css">';
echo '<link rel="stylesheet" href="../CSS/estilo_menu.css" type="text/css">';
echo '<nav>

	<ul>
                    <li><a title="Inicio" href="../index.html">Buscar Sitio</a></li>
                    <li><a title="Cargar Excel" href="../excel/index.html">Cargar Excel</a></li>
                    <li><a title="Opcion 4" href="../eliminar.html">Eliminar Sitio</a></li>
                    <li><a title="Opcion 3" href="../backup/backup.php">Backup</a></li>
    </ul>

</nav>';

echo '</br>';
echo '</br>';

require 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php'; //Agregamos la librería
require '../conex.php'; //Agregamos la conexión

if ($_FILES['archivo']["error"] > 0) {
    echo "Error: " . $_FILES['archivo']['error'] . "<br>";
} else {
    echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
    echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
    echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
    echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
}

//Movemos el archivo de la carpeta Temporal al directorio de subidas

move_uploaded_file($_FILES['archivo']['tmp_name'],
    "../excel/" . $_FILES['archivo']['name']);

//Variable con el nombre del archivo
$nombreArchivo = $_FILES['archivo']['name'];
// Cargo la hoja de cálculo
$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);

//Asigno la hoja de calculo activa
$objPHPExcel->setActiveSheetIndex(0);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

echo '<table><tr><td>#</td><td>location</td><td>model</td><td>Mic code</td><td>Serial</td><td>Inventario</td></tr>';

for ($i = 2; $i <= $numRows; $i++) {

    $location = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
    $model = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
    $miccode = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();
    $serial = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue();
    $inventario = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getCalculatedValue();
    $observacion = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getCalculatedValue();

    echo '<tr>';
    echo '<td>' . ($i - 1) . '</td>';
    echo '<td>' . $location . '</td>';
    echo '<td>' . $model . '</td>';
    echo '<td>' . $miccode . '</td>';
    echo '<td>' . $serial . '</td>';
    echo '<td>' . $inventario . '</td>';
    echo '<td>' . $observacion . '</td>';
    echo '</tr>';

    $sql = "INSERT INTO sitios (location, model, mic_code, serial, inventario, observacion) VALUES('$location','$model','$miccode','$serial','$inventario','$observacion')";
    $result = $mysqli->query($sql);
}

unlink($nombreArchivo);
echo '<table>';
?>