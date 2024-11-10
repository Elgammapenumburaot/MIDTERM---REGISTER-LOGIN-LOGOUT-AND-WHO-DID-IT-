<?php 

require_once 'dbConfig.php';

date_default_timezone_set('Asia/Manila'); 

function seeAllSellers($pdo) {
   
    $sql = "SELECT * FROM sellers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

   
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertNewSeller($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $added_by) {
   
    $sql = "INSERT INTO sellers (first_name, last_name, company_name, email, product_category, date_added, added_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $added_by]);

    if ($executeQuery) {
        return true; 
    } else {
        return false; 
    }
}

function getSellerById($pdo, $seller_id) {
   
    $sql = "SELECT * FROM sellers WHERE seller_id = ?";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([$seller_id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// models.php

// Function to update seller information
function updateSeller($pdo, $seller_id, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $updatedBy, $lastUpdated) {
    $sql = "UPDATE sellers 
            SET first_name = ?, last_name = ?, company_name = ?, email = ?, product_category = ?, date_added = ?, updated_by = ?, last_updated = ?
            WHERE seller_id = ?";
    
    // Prepare and execute the update query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $updatedBy, $lastUpdated, $seller_id]);
    
    // Return true if the update was successful, false otherwise
    return $stmt->rowCount() > 0;
}


function getCustomersBySeller($pdo, $seller_id) {
    // SQL query to get customers for a given seller_id
    $sql = "SELECT * FROM customers WHERE seller_id = ?";
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$seller_id]);
    
    // Fetch all customers for this seller
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $customers;
}

function insertNewCustomer($pdo, $firstName, $lastName, $email, $sellerId) {
    // Check if email already exists in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $emailCount = $stmt->fetchColumn();

    // If email already exists, return an error message
    if ($emailCount > 0) {
        return "Email already exists.";  // Return error message if email is duplicate
    }

    // If email does not exist, proceed to insert the new customer
    try {
        $query = "INSERT INTO customers (first_name, last_name, email, seller_id) VALUES (:first_name, :last_name, :email, :seller_id)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':seller_id' => $sellerId
        ]);

        // Fetch all customers after the insertion to update the customer list
        $customerQuery = "SELECT * FROM customers WHERE seller_id = :seller_id";
        $stmt = $pdo->prepare($customerQuery);
        $stmt->execute([':seller_id' => $sellerId]);
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $customers; // Return the updated list of customers

    } catch (PDOException $e) {
        // Handle error if any exception occurs during the insert process
        return "Error: " . $e->getMessage();
    }
}


function getCustomerById($pdo, $customer_id) {
    $sql = "SELECT * FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);  // Return the customer's data or false if not found
}

function updateCustomer($pdo, $customer_id, $firstName, $lastName, $email) {
    $sql = "UPDATE customers SET first_name = ?, last_name = ?, email = ? WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided customer data
    $stmt->execute([$firstName, $lastName, $email, $customer_id]);

    // Return true if the update was successful, otherwise false
    return $stmt->rowCount() > 0;
}

function deleteCustomer($pdo, $customer_id) {
    // SQL query to delete the customer from the database
    $sql = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute the query
    $stmt->execute([$customer_id]);

    // Return true if the deletion was successful, otherwise false
    return $stmt->rowCount() > 0;
}

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}





