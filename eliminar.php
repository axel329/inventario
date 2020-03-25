<html> 

<head> 
<title>Registro eliminado.</title> 
<META name='robot' content='noindex, nofollow'> 
</head> 

<body> 

            <?php 
            // Actualizamos en funcion del id que recibimos 

            $id = $_POST['id']; 

            //include('abre_conexion.php'); 
            require 'conex.php';  
            $query1 = "Select location from sitios where location = '$id'"; 
            $total = mysqli_num_rows($mysqli->query($query1));  
            $resultado1 = $mysqli->query($query1);

             if ($total == 0) {
                 //echo   "No hay nada";

                 echo        
                                '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=eliminar.html">
                                <script>
                                    alert("No se encuentra el Sitio!!!!!!");
                                </script>';
                
             } else{

                    //     //echo   "Sitio=".$resultado1;
                    $row3 = $resultado1->fetch_assoc();
                    echo "Sitio = ".$row3['location']."<br>";
             

                    $query = "delete from sitios where location = '$id'";  

                            $resultado = $mysqli->query($query);

                            if (!$resultado) {

                                echo       
                                '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.html">
                                <script>
                                    alert("Error al Eliminar");
                                </script>';

                            }else{

                                echo        
                                '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.html">
                                <script>
                                    alert("El Sitio fue eliminado EXITOSAMENTE");
                                </script>';

                            }
                        }

            //include('cierra_conexion.php');   

            /*echo " 
            <p>El registro ha sido eliminado con exito.</p> 

            <p><a href='javascript:history.go(-1)'>VOLVER ATRÁS</a></p> 
            "; */
            ?> 

</body> 

</html> 