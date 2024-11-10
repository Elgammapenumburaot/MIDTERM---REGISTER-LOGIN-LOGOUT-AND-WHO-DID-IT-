<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<link rel="stylesheet" href="style1.css">

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>The Art Vault</title>
</head>
<body>
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	<?php } unset($_SESSION['message']); ?>

	<div class="greeting">
		<h1>Hello there! Welcome, <?php echo $_SESSION['username']; ?></h1>
		<h1><a href="core/handleForms.php?logoutUserBtn=1">Logout</a></h1>	
	</div>

	<h3>Welcome to The Art Vault</h3>
	<form action="core/handleForms.php" method="POST">
		<p><label for="firstName">First Name</label> <input type="text" name="firstName" required></p>
		<p><label for="lastName">Last Name</label> <input type="text" name="lastName" required></p>
		<p><label for="companyName">Company Name</label> <input type="text" name="companyName" required></p>
		<p><label for="email">Email</label> <input type="email" name="email" required></p>
		<p><label for="productCategory">Product Category</label> <input type="text" name="productCategory" required></p>
		<p><label for="dateAdded">Registration Date</label> <input type="datetime-local" name="dateAdded" required>
			<input type="submit" name="insertNewSellerBtn" value="Register">
		</p>
	</form>
	
	<h3>Registered Sellers</h3> 
	<table>
		<tr>
			<th>Seller ID</th> 
			<th>First Name</th>
			<th>Last Name</th>
			<th>Company Name</th>
			<th>Email</th>
			<th>Product Category</th>
			<th>Date Registered</th>
			<th>Added By</th>
			<th>Updated By</th>
			<th>Last Updated</th>
			<th>Action</th>
		</tr>

		<?php $seeAllSellers = seeAllSellers($pdo); ?> 
		<?php foreach ($seeAllSellers as $row) { ?>
		<tr>
			<td><?php echo $row['seller_id']; ?></td> 
			<td><?php echo $row['first_name']; ?></td>
			<td><?php echo $row['last_name']; ?></td>
			<td><?php echo $row['company_name']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['product_category']; ?></td> 
			<td><?php echo $row['date_added']; ?></td>
			<td><?php echo $row['added_by']; ?></td>
			<td><?php echo $row['updated_by']; ?></td>
			<td><?php echo $row['last_updated']; ?></td>
			<td>
				<a href="editseller.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">Edit</a> 
				<a href="deleteseller.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">Delete</a> 
				<a href="viewCustomers.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">View Customers</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>
