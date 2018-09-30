<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
  $admin = find_admin_by_id($_GET["id"]); // $admin == $admin_array
  ?>
<?php // Т.к. эта страница ВСЕГДА загружается с каким-то id, то
	if (!$admin){
		//Если id отсутствует или ошибочен, то переадресация
		redirect_to("manage_admins.php");
	}
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
	  if (empty($errors)) {
		// Perform Create
		
		$id = $admin["id"];
		$username = mysql_prep($_POST["username"]);
		$hashed_password = password_encrypt($_POST["password"]);    
	  
		$query  = "UPDATE admins SET";
		$query .= " username = '{$username}', ";
		$query .= " hashed_password = '{$hashed_password}' ";
		$query .= " WHERE id = {$id} ";
		$query .= " LIMIT 1"; // не равно = , а просто число
		
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) == 1) {
		  // Success
		  $_SESSION["message"] = "Admin updated.";
		  redirect_to("manage_admins.php");
		} else {
		  // Failure
		  $_SESSION["message"] = "Admin updated failed.";
		}
	  }
	} else {
			// Иначе, в случае GET запроса, 
			// введённого напрямую в адресную строку url 
			// ничего не делать и выводить всё последующее	 
	  
	} // end: if (isset($_POST['submit']))  
		
	?>
<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php") ?>

    <div id="main">
      <div id="navigation">
        &nbsp;
      </div>
      <div id="page">
	  
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>
		
        <h2>Edit Admin: <?php echo htmlentities($admin["username"]);?></h2>
		<form action="edit_admin.php?id=<?php echo urlencode($admin["id"]);?>" method="post">
		   <p>Username: <input type="text" name="username" value="<?php echo htmlentities($admin["username"]);?>" /></p>
		   <p>Password: <input type="password" name="password" value="" /></p>
			<input type="submit" name="submit" value="Edite Admin" />
		</form>
		<br/>
		<a href="manage_admins.php">Cancel</a>
		
	  </div>
    </div>

<?php include("../includes/layouts/footer.php") ?>