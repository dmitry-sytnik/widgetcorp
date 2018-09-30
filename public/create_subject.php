<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
if (isset($_POST['submit'])){
	// Если отправлено, то обработка формы
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	
	// валидации
	$required_fields = array("menu_name", "position", "visible");	
	validate_presences($required_fields);	
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (!empty($errors)){
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	}
		
	// 2. Perform database query
	$query  = "INSERT INTO subjects (";
	$query .= "  menu_name, position, visible";
	$query .= ") VALUES (";
	$query .= "  '{$menu_name}', {$position}, {$visible}";
	$query .= ")";

	$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		$_SESSION["message"] = "Subject created.";
		redirect_to("manage_content.php");		
	} else {
		// Failure
		$_SESSION["message"] = "Subject creation failed.";
		redirect_to("new_subject.php");		
	}
	
} 	else {
		// Иначе, в случае GET запроса, 
		// введённого напрямую в адресную строку url create_subject.php
	 redirect_to("new_subject.php");
	}

?>
<?php  
if (isset($connection)){mysqli_close($connection);}  
?>