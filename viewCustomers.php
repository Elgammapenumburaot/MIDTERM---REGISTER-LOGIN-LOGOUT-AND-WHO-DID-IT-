<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];

    $customers = getCustomersBySeller($pdo, $seller_id);
} else {
    echo "Seller ID is missing.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insertNewCustomerBtn'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    $insertSuccess = insertNewCustomer($pdo, $firstName, $lastName, $email, $seller_id);
    
    if ($insertSuccess) {
        header("Location: viewCustomers.php?seller_id=$seller_id");
        exit();
    } else {
        $errorMessage = "Error adding customer. Please try again.";
    }
}
?>
<link rel="stylesheet" href="viewCustomers.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers for Seller</title>
</head>
<body>
    <div class="container">
        <h3>Customers for Seller ID: <?php echo htmlspecialchars($seller_id); ?></h3>

        <a href="index.php" class="back-to-home">Back to Home</a>

        <div class="form-container">
            <h4>Add New Customer</h4>
            <?php if (isset($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <form action="viewCustomers.php?seller_id=<?php echo $seller_id; ?>" method="POST">
                <p>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" required>
                </p>
                <p>
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" required>
                </p>
                <p>
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </p>
                <p>
                    <input type="submit" name="insertNewCustomerBtn" value="Add Customer">
                </p>
            </form>
        </div>

        <h4>Customers List</h4>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr>
                        <td colspan="5">No customers found for this seller.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['customer_id']); ?></td>
                            <td><?php echo htmlspecialchars($customer['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td>
                                <a href="editCustomer.php?customer_id=<?php echo htmlspecialchars($customer['customer_id']); ?>">Edit</a>
                                <a href="deleteCustomer.php?customer_id=<?php echo htmlspecialchars($customer['customer_id']); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
