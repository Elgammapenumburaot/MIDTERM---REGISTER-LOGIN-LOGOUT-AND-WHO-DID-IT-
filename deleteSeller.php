<?php
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    
    $seller = getSellerById($pdo, $seller_id);
    
    if ($seller) {
        $sql = "DELETE FROM sellers WHERE seller_id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$seller_id])) {
            header("Location: index.php"); 
            exit;
        } else {
            echo "Error deleting seller.";
        }
    } else {
        echo "Seller not found.";
    }
} else {
    echo "Seller ID not provided.";
}
?>
