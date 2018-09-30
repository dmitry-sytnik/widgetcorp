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
	$content = mysql_prep($_POST["content"]);
	$subject_id = $_POST["subjectid"];
	
	
	// валидации
	$required_fields = array("menu_name", "position", "visible", "content");	
	validate_presences($required_fields);	
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (!empty($errors)){
		$_SESSION["errors"] = $errors;
	redirect_to("new_page.php?subject={$subject_id}");
	}
	
	// 2. Perform database query
	$query  = "INSERT INTO pages (";
	$query .= "  subject_id, menu_name, position, visible, content";
	$query .= ") VALUES (";
	$query .= "{$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
	$query .= ")";

	$result = mysqli_query($connection, $query);
	
	if ($result) {
		// Success
		$_SESSION["message"] = "Page created.";
		redirect_to("manage_content.php?subject={$subject_id}");		
	} else {
		// Failure
		$_SESSION["message"] = "Page creation failed.";
		redirect_to("new_page.php?subject={$subject_id}");		
	}
	
} 	else {
		// Иначе, в случае GET запроса, 
		// введённого напрямую в адресную строку url create_page.php
	 redirect_to("manage_content.php");
	}

?>
<?php  
if (isset($connection)){mysqli_close($connection);}  
?>