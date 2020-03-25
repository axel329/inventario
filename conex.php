<?php
$mysqli=new mysqli ("localhost","root","Admin123-","inventario_tigoune");

if(mysqli_connect_errno()){

		echo 'Conexión Fallida: ', mysqli_connect_error();
		exit();
}


?>