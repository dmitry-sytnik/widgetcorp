<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page();?>
	
<div id="main">
 <div id="navigation">
  <br />
  <a href="admin.php">&laquo; Main menu</a><br />
  <?php echo navigation($current_subject, $current_page); ?>
  <br/>
  <a href="new_subject.php">+ Add new subject</a>
 </div>
      <div id="page">
        <?php echo message(); ?>
		<?php if ($current_subject) { ?>
			<h2>Manage Subject</h2>
			Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?><br/>
			Position: <?php echo $current_subject["position"]; ?><br/>
			Visible: <?php echo $current_subject["visible"] == 1 ? 'yes': 'no'; ?><br/>
			<br />
			
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a>
			<p></p>
			<hr />
			<h3>Pages in this subject:</h3>
			
			<?php $page_set = find_pages_for_subject($current_subject["id"], false);?>
				<ul>					
				<?php while($page = mysqli_fetch_assoc($page_set)) {  ?>
					<li>						
				    <a href="manage_content.php?page=<?php echo urlencode($page["id"]);?>">
				    <?php echo htmlentities($page["menu_name"]);?></a></li>	<?php } ?>				
				<?php mysqli_free_result($page_set);?>
				</ul>
			
			+ <a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">
			Add a new page to this subject</a>
			
		<?php } elseif ($current_page) { ?>
			<h2>Manage Page</h2>
			Menu name: <?php echo htmlentities($current_page["menu_name"]); ?><br />
			Position: <?php echo $current_page["position"]; ?><br/>
			Visible: <?php echo $current_page["visible"] == 1 ? 'yes': 'no'; ?><br/>
			Content:<br/>
			<div class="view-content">
			 <?php echo htmlentities($current_page["content"]); ?>
			</div>
			<br />
			<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit Page</a>
		
		<?php } else { ?>
			Please, choose a object or a page.
		<?php } ?>
			
		
        
      </div>
    </div>
	
<?php include("../includes/layouts/footer.php"); ?>