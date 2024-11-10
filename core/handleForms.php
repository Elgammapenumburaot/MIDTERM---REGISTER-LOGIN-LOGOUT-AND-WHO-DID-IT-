<?php 
require_once 'dbConfig.php'; 
require_once 'models.php';  
date_default_timezone_set('Asia/Manila');

if (isset($_POST['insertNewSellerBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName']);
    $email = trim($_POST['email']);
    $productCategory = trim($_POST['productCategory']);
    $dateAdded = trim($_POST['dateAdded']);
    $added_by = $_SESSION['username'];


    if (!empty($firstName) && !empty($lastName) && !empty($companyName) && !empty($email) && !empty($productCategory)) {
        $query = insertNewSeller($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $added_by);

        if ($query) {
            header("Location: ../index.php?success=Seller added");
            exit();
        } else {
            echo "Failed to insert seller.";
        }
    } else {
        echo "Make sure that no fields are empty.";
    }

    if (!isset($_SESSION['username'])) {
        echo "User is not logged in.";
        exit();
    }
    
    $added_by = $_SESSION['username'];  // Fetch the logged-in username from session
    
}


if (isset($_POST['deleteSellerBtn']) && isset($_POST['seller_id'])) {
    $seller_id = $_POST['seller_id'];

    if (!empty($seller_id)) {
        if (deleteSeller($pdo, $seller_id)) {
            header("Location: ../index.php?success=Seller deleted");
            exit();
        } else {
            echo "Failed to delete seller.";
        }
    } else {
        echo "Seller ID is required to delete a seller.";
    }
}


if (isset($_POST['insertNewCustomerBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $dateAdded = date('Y-m-d H:i:s');
    
    if (!empty($firstName) && !empty($lastName) && !empty($email)) {
        $insertSuccess = insertNewCustomer($pdo, $firstName, $lastName, $email, $dateAdded);
        
        if ($insertSuccess) {
       
            header("Location: viewCustomers.php?success=Customer added successfully");
            exit();
        } else {
            echo "Error adding customer.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}

if (isset($_POST['updateCustomerBtn'])) {
    $customer_id = $_POST['customer_id'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $productCategory = trim($_POST['productCategory'] ?? '');
    $sellerId = $_POST['seller_id'] ?? null;


    if (!empty($customer_id) && !empty($firstName) && !empty($lastName)) {
        $query = updateCustomer($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $sellerId, $customer_id);

        if ($query) {
            header("Location: ../viewCustomers.php?success=Customer updated");
            exit();
        } else {
            echo "Failed to update customer.";
        }
    } else {
        echo "Please fill in all required fields (customer ID, first name, and last name).";
    }
}


if (isset($_POST['deleteCustomerBtn']) && isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];  

 
    $deleteSuccess = deleteCustomer($pdo, $customer_id); 
    
    if ($deleteSuccess) {
       
        header("Location: customersList.php");  
        exit(); 
    } else {
        echo "Error deleting customer. Please try again.";
    }
}
//login
if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = "400";
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);

		if ($loginQuery['status'] == '200') {
			$usernameFromDB = $loginQuery['userInfoArray']['username'];
			$passwordFromDB = $loginQuery['userInfoArray']['password'];

			if (password_verify($password, $passwordFromDB)) {
				$_SESSION['username'] = $usernameFromDB;
				header("Location: ../index.php");
			}
		}

		else {
			$_SESSION['message'] = $loginQuery['message'];
			$_SESSION['status'] = $loginQuery['status'];
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure no input fields are empty";
		$_SESSION['status'] = "400";
		header("Location: ../login.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}








