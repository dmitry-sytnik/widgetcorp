<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page();?>
<?php
	if (!$current_page){
		//Если id отсутствует или ошибочен, то переадресация
		redirect_to("manage_content.php");
	} 
?>
<?php
if (isset($_POST['submit'])){
	// Если отправлен POST, то обработка формы
	
	// валидации
	$required_fields = array("menu_name", "position", "visible", "content");	
	validate_presences($required_fields);	
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)){
		
		//Если errors пуста, выполнить обновление из пост-запроса
		
		$id = $current_page["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];	
		$content = mysql_prep($_POST["content"]);
		
		// 2. Perform database query
		$query  = "UPDATE pages SET";
		$query .= " menu_name = '{$menu_name}',";
		$query .= " position = {$position},";
		$query .= " visible = {$visible},";
		$query .= " content = '{$content}'";
		$query .= " WHERE id = {$id}"; 
		$query .= " LIMIT 1";		

		$result = mysqli_query($connection, $query);
		
		if ($result && mysqli_affected_rows($connection) == 1) {
			// Success
			$_SESSION["message"] = "Page updated.";
			redirect_to("manage_content.php?page=".urlencode($id));		
		} else {
			// Failure
			$message = "Page not update.";				
		}
	}
	
	
	} 	else {
		// Иначе, в случае GET запроса, 
		// введённого напрямую в адресную строку url 
		// ничего не делать, а также выводить всё последующее
	 
}   // конец: if (isset($_POST['submit']))

?>
<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
 <div id="navigation"> 
	
  <?php echo navigation($current_subject, $current_page); ?>
 </div>
	<div id="page">	
	
	<?php //если message не пустая, то вывести сообщение, использовать Сессию необязательно 
	if (!empty($message)) {
		echo "<div class=\"message\">".htmlentities($message)."</div>";
	}?>
	
	<?php echo form_errors($errors); ?>
	
	<h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
	
	<?php 
	//$pagearray = find_page_by_id($current_page["id"]);	
	//$current_subject["id"] = $pagearray["subject_id"];	
	$current_subject["id"] = $current_page["subject_id"];	
	?>
	<?php 
	//if (!$current_subject){
	//	echo "<p>current_subject is not here</p>";}		
	// if ($current_subject){
	//	echo "<p>current_subject is here</p>";} 	
	// if ($current_subject = null){
	//	echo "<p>current_subject is null</p>";} 
	// if (!$current_subject = null){
	//	echo "<p>current_subject is not null</p>";} 	 
	// if (empty($current_subject)){
	//	echo "<p>current_subject is empty</p>";} 
	// if (!empty($current_subject)){
	//	echo "<p>current_subject is not empty</p>";} 
	 	
	//echo	"current_page_id = {$current_page['id']}";
	?>
	
	
	
	<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
	 <p>Menu name:
	    <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
	 </p>
	 <p>Position:
	    <select name="position">
		<?php 
			$page_set = find_pages_for_subject($current_subject["id"], false);
			$page_count = mysqli_num_rows($page_set);
			for($count=1; $count <= $page_count; $count++){
				echo "<option value=\"{$count}\"";
				if ($current_page["position"] == $count) {
				echo " selected";
				}
				echo ">{$count}</option>";
			}
		?>
		</select>
	 </p>
	   <p>Visible:
	    <input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0){echo "checked";}?>/> No
		&nbsp;
		<input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1){echo "checked";}?> /> Yes 
	   <p>
	    
	    <p>Content:<br/>
		<textarea name="content" cols="75" rows="15"><?php echo htmlentities($current_page["content"]);?></textarea>		
		</p>
	   <input type="submit" name="submit" value="Edit Page" />
	  </form>
	  <br />
	  <a href="manage_content.php?page=<?php echo urlencode($current_page["id"]);?>">Cancel</a>
	  &nbsp;
	  &nbsp;
	  <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" 
	  onclick="return confirm('Are you sure?');">Delete Page</a>
    </div>
</div>
	
<?php include("../includes/layouts/footer.php"); ?>
 