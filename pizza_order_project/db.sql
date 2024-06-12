CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pizza VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    drink VARCHAR(50) NOT NULL,
    side VARCHAR(50) NOT NULL,
    dessert VARCHAR(50) NOT NULL,
    table_number VARCHAR(10),
    takeaway TINYINT NOT NULL DEFAULT 0,
    completed TINYINT NOT NULL DEFAULT 0
);
