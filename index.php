<?php
include 'Vehiculo.class.php';

session_start(); // Inicia la sesión

if (isset($_SESSION["ID"])) {
    $id = $_SESSION["ID"]; // Recupera el ID de la sesión
}
else{
    echo"No se ha recuperado el id de la sesion";
    header("Location: login.php");
    exit; // Asegura que el script se detenga después de la redirección

}

// Conectar con la base de datos
$servername = "localhost";
$username = "pw";
$password = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$bd = mysqli_select_db($conn, 'easyway');
if(!$bd) {
    echo"Error al seleccionar la base de datos.";
    exit;
}


//Crear Inventario

$id_formulario_reserva = isset($_POST['id']) ? $_POST['id'] : null;

if($id_formulario_reserva != null){
    $accion = $_POST['accion'];
    if($accion == "Reservar"){
        $insert_reserva_query = mysqli_query($conn, "INSERT INTO reserva (id_vehiculo, id_usuario) VALUES ('".$id_formulario_reserva."', '".$id."')");
        if($insert_reserva_query){
            echo "Reserva realizada con éxito";
        }
        else{
            echo "Error al realizar la reserva";
        }
    }
    else if($accion == "Liberar"){
        $delete_reserva_query = mysqli_query($conn, "DELETE FROM reserva WHERE id_vehiculo = '".$id_formulario_reserva."' AND id_usuario = '".$id."'");
        if(!$delete_reserva_query){
            echo "Error al liberar la reserva";
        }
    }
}

$vehiculos_query = mysqli_query($conn, "SELECT * FROM vehiculo");
if (mysqli_num_rows($vehiculos_query) > 0) {
    while($row = mysqli_fetch_assoc($vehiculos_query)) {
        switch ($row["tipo"]) {
            case "Cuarto_ruedas":
                $vehiculos[$row["id"]] = new Cuatro_ruedas($row["color"], $row["peso"], $row["numero_puertas"]);
                break;
            case "Dos_ruedas":
                $vehiculos[$row["id"]] = new Dos_ruedas($row["color"], $row["peso"], $row["cilindrada"]);
                break;
            case "Coche":
                $vehiculos[$row["id"]] = new Coche($row["color"], $row["peso"], $row["numero_puertas"], $row["numero_cadenas_nieve"]);
                break;
            case "Camion":
                $vehiculos[$row["id"]] = new Camion($row["color"], $row["peso"], $row["numero_puertas"], $row["longitud"]);
                break;
            default:
                $vehiculos[$row["id"]] = new Vehiculo($row["color"], $row["peso"]);
        }
    }
}


//Array de reserva
$vehiculos_reservados[] = array();

$reservas_query = mysqli_query($conn, "SELECT * FROM reserva");

if (mysqli_num_rows($reservas_query) > 0) {
    while($res = mysqli_fetch_assoc($reservas_query)) {
        $vehiculos_reservados[$res["id_vehiculo"]] = $res["id_usuario"];
    }
}


define("VEHICULOS_POR_TABLA", 12);
?>


        <!--TABLA COCHES-->

        <h2>Reserva de coches</h2>

        <table style='margin: auto; width: 50%; border-collapse: collapse; text-align: center;'>
        <tr style='background-color: #f2f2f2;'><th>ID</th><th style="color: brown;">Tipo</th><th>Color</th><th>Peso</th><th>Puertas</th><th>Cadenas de Nieve</th><th>Longitud</th><th> </th></tr>

        <?php
    
        $n = isset($_POST['n']) ? $_POST['n'] : VEHICULOS_POR_TABLA;
        if (count($vehiculos) > 0) {
            $i = 0;
            foreach($vehiculos as $clave => $vehiculo) {
                if($i>=$n){
                    break;
                }
                if($i >= $n-VEHICULOS_POR_TABLA){
                    if($vehiculo instanceof Coche){
                        echo "<tr><td>" . $clave . "</td><td>Coche</td><td>". $vehiculo->color() ."</td><td>". $vehiculo->peso() . "</td><td>". 
                        $vehiculo->numero_puertas() . "</td><td>". $vehiculo->numero_cadenas_nieve() . "</td><td> </td>";
                    }
                    elseif($vehiculo instanceof Camion){
                        echo "<tr><td>" . $clave . "</td><td>Camión</td><td>". $vehiculo->color() ."</td><td>". $vehiculo->peso() . "</td><td>". 
                        $vehiculo->numero_puertas() . "</td><td> </td><td>". $vehiculo->longitud() . "</td>";
                    }
                    elseif($vehiculo instanceof Dos_ruedas){
                        echo "<tr><td>" . $clave . "</td><td>Dos ruedas</td><td>". $vehiculo->color() ."</td><td>". $vehiculo->peso() . "</td><td>". 
                        $vehiculo->cilindrada() . "</td><td> </td><td> </td>";
                    }
                    elseif($vehiculo instanceof Cuatro_ruedas){
                        echo "<tr><td>" . $clave . "</td><td>Cuatro ruedas</td><td>". $vehiculo->color() ."</td><td>". $vehiculo->peso() . "</td><td>". 
                        $vehiculo->numero_puertas() . "</td><td> </td><td> </td>";
                    }
                    else{
                        echo "<tr><td>" . $clave . "</td><td>Vehiculo</td><td>". $vehiculo->color() ."</td><td>". $vehiculo->peso() . "</td><td> </td><td> </td><td> </td>";
                    }
                    echo "<td>";
                    echo "<form  method='post' action='index.php'>";
                        echo "<input type='hidden' name='id' value='".$clave."'>";
                        if(!isset($vehiculos_reservados[$clave])){
                            echo "<input type='submit' name='accion' value='Reservar'>";
                        }
                        else{
                            if($vehiculos_reservados[$clave] == $id) echo "<input type='submit' name='accion' value='Liberar' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta reserva?');\">";
                        }
                    echo "</form>";
                    echo "</td>";
                }
                $i++;
            }

        } else {
            echo "<tr><td colspan='9'>No hay vehículos para esta selección.</td></tr>";
        }
        ?>

     

        <tr><td colspan='9'></td></tr>
        <tr><td colspan='9'></td></tr>
        <tr><td colspan='9'></td></tr>
        
        <!--Boton siguiente y anterior para mostrar las siquientes-->
        <tr>
        
        <?php if($n > VEHICULOS_POR_TABLA){
            echo "<form method='post' action='index.php'>";
            echo "<input type='hidden' name='n' value='".($n-VEHICULOS_POR_TABLA)."'>";
            echo "<td> <input type='submit' value='Anterior'></td>";
            echo "</form>";
            echo "<td colspan='7'></td>";
        }
        else{
            echo "<td colspan='8'></td>";
        }?>
    

        <td>    
        <?php if($n < mysqli_num_rows($vehiculos_query)){
            echo "<form method='post' action='index.php'>";
            echo "<input type='hidden' name='n' value='".($n+VEHICULOS_POR_TABLA)."'>";
            echo "<input type='submit' value='Siguiente'>";
            echo "</form>";
        }?>
        </td>
        </tr>

        </table>

        <br>
        <br>
