<?php
require_once '../app/models/Baza.php';

class OrdersRepository {
    private $db;

    public function __construct() {
        $this->db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
    }

    public function getCartItems($userId) {
        $mysqli = $this->db->getMysqli();
        $sql = "SELECT 
                c.quantity, 
                p.name AS product_name, 
                p.price 
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?";
    
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllProducts() {
        $mysqli = $this->db->getMysqli();
        $sql = "SELECT * FROM products";
        $result = $mysqli->query($sql);
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
};
?>