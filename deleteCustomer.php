<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    $deleteSuccess = deleteCustomer($pdo, $customer_id);

    if ($deleteSuccess) {
        header("Location: viewCustomers.php?seller_id=" . $_GET['seller_id']);
        exit();
    } else {
        echo "Error deleting the customer.";
    }
} else {
    echo "Customer ID is missing.";
    exit();
}
?>
