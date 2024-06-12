<?php
$servername = "localhost";
$username = "root";
$password = "-pI-@fPqCSwY-*2t";
$dbname = "pizza_orders";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $pizza = $data['pizza'];
        $quantity = $data['quantity'];
        $sql = "INSERT INTO orders (pizza, quantity, completed) VALUES ('$pizza', $quantity, 0)";
        if ($conn->query($sql) === TRUE) {
            $orderId = $conn->insert_id;
            echo json_encode(["message" => "Order created successfully", "orderId" => $orderId]);
        } else {
            echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents('php://input'), $_PUT);
        $orderId = $_PUT['orderId'];
        $sql = "UPDATE orders SET completed = 1 WHERE id = $orderId";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Order completed successfully"]);
        } else {
            echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
        }
        break;

    case 'GET':
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);
        $orders = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        echo json_encode($orders);
        break;
}

$conn->close();
?>
