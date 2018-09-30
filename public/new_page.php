<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page();?>

<?php
	// В случае, если не задан subject или
	// в случае GET запроса, введённого напрямую в адресную строку url "new_page.php",
	// переадресация
	if (!$current_subject) {
		redirect_to("manage_content.php");
	}		
?>

<div id="main">
 <div id="navigation">
  <?php echo navigation($current_subject, $current_page); ?>
 </div>
	<div id="page">
	<?php echo message(); ?>
	<?php $errors = errors(); ?>
	<?php echo form_errors($errors); ?>
	
		<h2>Create Page</h2>
		<form action="create_page.php" method="post">
		<p>Menu name:<input type="text" name="menu_name" value="" /></p>
		<p>Position:
	    <select name="position">
		<?php 
			$page_set = find_pages_for_subject($current_subject["id"], false);
			$page_count = mysqli_num_rows($page_set);
			for($count=1; $count <= ($page_count + 1); $count++){
				echo "<option value=\"{$count}\">{$count}</option>";
			}
		?>
		</select>
	    </p>
		<p>Visible:
	    <input type="radio" name="visible" value="0" /> No
		&nbsp;
		<input type="radio" name="visible" value="1" /> Yes
	    <p>
		
		<p>Content:<br/>
		<textarea name="content" cols="75" rows="15"></textarea>		
		</p>
		
		<input type="hidden" name="subjectid" value="<?php echo $current_subject["id"];?>" />
		
		<input type="submit" name="submit" value="Create Page" />
	  </form>
	  <br />
	  <a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]);?>">Cancel</a>
		
	</div>
</div>
	
<?php include("../includes/layouts/footer.php"); ?>