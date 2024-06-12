<?php
// Configuración de conexión a la base de datos (reemplaza con tus credenciales)
$servername = "localhost";
$username = "root";
$password = "-pI-@fPqCSwY-*2t";
$dbname = "pizza_orders";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Query para obtener las órdenes
$sql = "SELECT 
            id,
            pizza,
            quantity,
            drink,
            side,
            dessert,
            table_number,
            takeaway,
            completed
        FROM
            orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar resultados en forma de tabla HTML
    echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pizza</th>
                    <th>Cantidad</th>
                    <th>Bebida</th>
                    <th>Complemento</th>
                    <th>Postre</th>
                    <th>Número de Mesa / Para Llevar</th>
                    <th>Estado de la Orden</th>
                </tr>
            </thead>
            <tbody>";

    while($row = $result->fetch_assoc()) {
        $orderType = $row['takeaway'] ? "Para Llevar" : ("En Mesa " . $row['table_number']);
        $orderStatus = $row['completed'] ? "Completada" : "En Curso";

        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['pizza'] . "</td>
                <td>" . $row['quantity'] . "</td>
                <td>" . $row['drink'] . "</td>
                <td>" . $row['side'] . "</td>
                <td>" . $row['dessert'] . "</td>
                <td>" . $orderType . "</td>
                <td>" . $orderStatus . "</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No se encontraron órdenes.";
}
$conn->close();
?>
