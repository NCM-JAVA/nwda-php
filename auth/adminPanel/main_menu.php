<?php ob_start();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
session_start();

  $url=$_SERVER['REQUEST_URI']; 
		 $val=explode('/', $url);
	 	 $urls=$val['4'];
		$open=$val['3'];
		
			  ?>


    <!-- Grid Area start-->
 <div id="menu_holder">
        <div id="menu">
          <div class="navigation_a" id="MainContent">
            <div class="topLinks">
<a href="welcome.php" title="Manage DashBoard" class="menuitem" <?php if($urls=='welcome.php'){ echo 'style="background: #A3CA57;"'; } ?>>DashBoard</a>
<a href="profile.php" title="Manage Profile" class="menuitem"<?php if($urls=='profile.php'){ echo 'style="background: #A3CA57;"'; } ?>>View Profile</a>
<?php


	$user_id=$_SESSION['admin_auto_id_sess'];
	$user_role_id=$_SESSION['dbrole_id'];
		$qry = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
		$result = $conn->query($qry);
		$role_module = $result->fetch_array();
		$module_id =$role_module['module_id'];


	    if($module_id=='ALL')
		  {

		   ?>
		<a href="manage_user.php" title="User Management" class="menuitem submenuheader"  <?php if($urls=='manage_user.php'||$urls=='manage_front_user.php'||$urls=='manage_role.php'){ echo 'style="background: #A3CA57;"'; } ?>>User Management</a>
				<div class="submenu " >
				<ul>
				<li class="menuitem <?php if($urls=='manage_user.php'){ echo 'active'; } ?>"><a href="manage_user.php" title="Manage User" >Manage User</a></li> 
				<li class="menuitem <?php if($urls=='manage_front_user.php'){ echo 'active'; } ?>"><a href="manage_front_user.php" title="Manage User" >Manage Employee</a></li> 
				
				<li class="menuitem <?php if($urls=='manage_role.php'){ echo 'active'; } ?>"><a href="manage_role.php" title="Manage Role" >Manage Role</a></li> 
                                                              
				</ul>
			</div>

			<a href="manage_menu.php" title="User Management" class="menuitem submenuheader" <?php if($urls=='manage_menu.php'||$urls=='manage_homepage.php'||$urls=='manage_whatnews.php'||$urls=='manage_tenders.php'||$urls=='manage_circular_events.php'||$urls=='manage_banner.php'||$urls=='manage_important_link.php'||$urls=='manage_faq.php'){ echo 'style="background: #A3CA57;"'; } ?>>CMS Page</a>
			<div class="submenu">
			<ul>
			<?php  
				$qry = "Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in(1,2,3,5,6,7,11,17,2224) and page_type='cms_page' order by `module_id` asc";
				$result = $conn->query($qry);
					
			while($data = $result->fetch_array()) {
			@extract($data);
			?>
				<li <?php if($urls==$data['module_url']){ ?>class="active"<?php } ?>><a href="<?php 
				if($data['module_id']==1){
					echo "manage_menu.php";
				}elseif($data['module_id']==2){ 
					echo "manage_homepage.php";
				}elseif($data['module_id']==3){
					echo "manage_whatnews.php";
				}elseif($data['module_id']==5){
					echo "manage_tenders.php";
				}elseif($data['module_id']==6){
					echo "manage_circular_events.php";
				}elseif($data['module_id']==11){
					echo "manage_banner.php";
				}elseif($data['module_id']==9){ 
					echo "manage_important_link.php";
				}elseif($data['module_id']==14){ 
					echo "manage_faq.php";
				}elseif($data['module_id']==17){
					echo "manage_vacancy.php";
				}
					?>" title="<?php echo $module_name; ?>"><?php echo $data['module_name']; ?></a>
					
					</li>
		<?php } ?>
	</ul>
	</div>
 <a <?php if($urls=='manage_feedback.php'){ echo 'style="background: #A3CA57;"'; } ?> href="add_file.php" title="Manage documents" class="menuitem">Manage Files</a>
	<a <?php if($urls=='manage_feedback.php'){ echo 'style="background: #A3CA57;"'; } ?> href="manage_feedback.php" title="Manage Feedback" class="menuitem">Manage Feedback</a>
	<a <?php if($urls=='manage_onlinequery.php'){ echo 'style="background: #A3CA57;"'; } ?>href="manage_onlinequery.php" title="Manage Online Query" class="menuitem">Manage Online Query</a>
	<a <?php if($urls=='manage_viewsonilr.php'){ echo 'style="background: #A3CA57;"'; } ?>href="manage_viewsonilr.php" title="Manage Online Query" class="menuitem">Manage Views On ILR</a>
	<!--<a href="manage_employee.php" title="Manage Employee" class="menuitem">Manage Employee</a>
	 <a href="manage_top_headerlogo.php" title="Manage Top Header Logo" class="menuitem">Manage Top Header Logo</a> -->
	<a href="#" title="Manage Organization Setup" class="menuitem submenuheader"  <?php if($urls=='organization-chart.php'||$urls=='designation.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Organization Setup</a>
	
		<div class="submenu">
		<ul>
		<!--organization_setup.php-->
		<li class="menuitem <?php if($urls=="organization-chart.php"){ ?>active<?php } ?>" ><a title="Organization Setup" href="organization-chart.php">Organization Setup</a></li>
		<li class="menuitem <?php if($urls=="designation.php"){ ?>active<?php } ?>" ><a title="Organization Designation" href="designation.php">Organization Designation</a></li>
		</ul>
		</div>
	<?php /*<a href="#" title="Manage Discussion Forum" class="menuitem submenuheader">Manage Discussion Forum</a>
		<div class="submenu">
		<ul>
		<li class="menuitem"><a title="Discussion Forum" href="manage_discussion.php"> Discussion Forum</a></li>
		<li class="menuitem"><a title="Discussion New Topic" href="discussion_topic.php">Discussion New Topic</a></li>
		</ul>
		</div>
	<a href="#" title="Manage Discussion Forum" class="menuitem submenuheader">Manage Glossary Forum</a>
		<div class="submenu">
		<ul>
		<li class="menuitem"><a title="Discussion Forum" href="manage_encyclopedia.php"> Glossary Forum</a></li>
		<li class="menuitem"><a title="Discussion New Topic" href="encyclopedia_topic.php">Glossary New Topic</a></li>
		</ul>
		</div> */?>
	<a href="logo.php" title="Manage Importent Link Logo" class="menuitem" <?php if($urls=='logo.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Important Link Logo</a>
			
	<a href="#" title="Manage Media" class="menuitem submenuheader" <?php if($urls=='manage_photo_gallery.php'||$urls=='manage_video_gallery.php'||$urls=='gallery-category.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Media Center</a>
		<div class="submenu">
				<ul>
					<li class="<?php if($urls=="manage_photo_gallery.php"){ ?>active<?php } ?>"><a title="Photo Gallery"  href="manage_photo_gallery.php">Photo Gallery</a></li>
					<li class="<?php if($urls=="manage_video_gallery.php"){ ?>active<?php } ?>"><a title="Video Gallery"  href="manage_video_gallery.php">Video Gallery</a></li>
					<li class="<?php if($urls=="gallery-category.php"){ ?>active<?php } ?>"><a title="Manage Advertisements"  href="#">Photogallery</a>
						<ul>
							<li class="menuitem <?php if($urls=="gallery-category.php"){ ?>active<?php } ?>"><a title="Add Gallery Categories" href="gallery-category.php">Add Category</a></li>
						</ul>
					</li>
				</ul>
		</div>
<a href="manage_audit.php" title="Manage Audit" class="menuitem"  <?php if($urls=='manage_audit.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Audit</a>
 <a href="manage_post.php" title="Manage Post Details" class="menuitem" <?php if($urls=='manage_post.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Post Details</a>
 <a href="manage_applicants.php" title="Manage Advertisement Details" class="menuitem" <?php if($urls=='manage_applicants.php'){ echo 'style="background: #A3CA57;"'; } ?>>Manage Applicants List</a>
 <?php /*<a href="manage_advertisement.php" title="Manage Advertisement Details" class="menuitem">Manage Advertisement</a>*/ ?>

<!-- <a href="manage_new_category.php" title="Manage Audit" class="menuitem">Manage Circular/What's New Category</a>
 -->		  <?php 
		  }
	  else
	  {	
		$cms=array('1','2','3','5','6','7','11');
		$exploded=explode(',',$module_id);
		$module_id_cms=array_intersect($exploded, $cms);
		$comma_separated = implode(",", $module_id_cms);
	// $query=mysql_query("Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc"); 
	// $num=mysql_num_rows($query);
		$qry1 = "Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc";
				$result1 = $conn->query($qry1);
		if ($result1->num_rows > 0) {
				?>
						<a href="#" title="User Management" class="menuitem submenuheader">CMS Page</a>
			<div class="submenu">
			<ul>
			<?php  
				while($data = $result1->fetch_array()) {
//echo "<pre>";print_R($data);exit;
			?>
				<li><a href="<?php if($data['module_id']==1) echo "manage_menu.php";
				elseif($data['module_id']==2) echo "manage_homepage.php";
				elseif($data['module_id']==3) echo "manage_whatnews.php";
//				elseif($data['module_id']==5) echo "manage_annual_reports.php";
				elseif($data['module_id']==6) echo "manage_circular_events.php";
				elseif($data['module_id']==5) echo "manage_tenders.php";
				elseif($data['module_id']==11) echo "manage_important_link.php";
					?>" title="<?php echo  $data['module_name']; ?>"><?php echo $data['module_name']; ?></a>
					</li>
		<?php } ?>
	</ul>
	</div>
	<?php } 
	 $cms=array('4','9','10','12','13','14','15','16');
	 $exploded=explode(',',$module_id);
		$module_id_cms=array_intersect($exploded, $cms);
		$comma_separated = implode(",", $module_id_cms);
		$query=mysql_query("Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc"); $num=mysql_num_rows($query);
	while($data=mysql_fetch_array($query))
			{
			@extract($data);
		?>
		
		<?php if($data['module_id']==4){?>
	<a href="manage_feedback.php" title="Manage Feedback" class="menuitem">Manage Feedback</a>
	
	<?php  }elseif($data['module_id']==9) { ?>
		<a href="#" title="Manage Organization Setup" class="menuitem submenuheader">Manage Organization Setup</a>
			<div class="submenu">
			<ul>
			<li class="menuitem"><a title="Organization Setup" href="organization-chart.php">Organization Setup</a></li>
			<li class="menuitem"><a title="Organization Designation" href="designation.php">Organization Designation</a></li>
			</ul>
			</div>
		<?php } elseif($data['module_id']==12) { ?>
		<a href="#" title="Manage Discussion Forum" class="menuitem submenuheader">Manage Discussion Forum</a>
			<div class="submenu">
			<ul>
			<li class="menuitem"><a title="Discussion Forum" href="manage_discussion.php"> Discussion Forum</a></li>
			<li class="menuitem"><a title="Discussion New Topic" href="discussion_topic.php">Discussion New Topic</a></li>
			</ul>
			</div>
			
			<?php } elseif($data['module_id']==19) { ?>
				<a href="manage_banner.php" title="Home Banner" class="menuitem">Home Banner</a>
				<?php }elseif($data['module_id']==18){?>
		<a href="#" title="Manage Media" class="menuitem submenuheader">Manage Media Center</a>
		<div class="submenu">
			<ul><li class="<?php echo $uclass5; ?>"><a title="Photo Gallery"  href="manage_photo_gallery.php">Photo Gallery</a></li>
				<li class="<?php echo $uclass5; ?>"><a title="Video Gallery"  href="manage_video_gallery.php">Video Gallery</a></li>
			<li class="<?php echo $uclass5; ?>"><a title="Manage Advertisements"  href="#">Photogallery</a>
				<ul>
					<li class="menuitem"><a title="Add Gallery Categories" href="gallery-category.php">Add Category</a></li>
				</ul>
			</li>
		</ul>
		</div>
<?php } elseif($data['module_id']==14) { ?>
				<a href="manage_onlinequery.php" title="" class="menuitem">Manage Online Query</a>
         <?php  
		 }elseif($data['module_id']==16){ ?>
			<a href="manage_viewsonilr.php" title="Manage Views On ILR" class="menuitem">Manage Views On ILR</a>
<?php			}elseif($data['module_id']==15){ ?>
	<a href="#" title="Manage Discussion Forum" class="menuitem submenuheader">Manage Glossary Forum</a>
		<div class="submenu">
			<ul>
				<li class="menuitem"><a title="Discussion Forum" href="manage_encyclopedia.php"> Glossary Forum</a></li>
				<li class="menuitem"><a title="Discussion New Topic" href="encyclopedia_topic.php">Glossary New Topic</a></li>
			</ul>
</div>
<?php			}
		 }}
   ?>
         </div>
          </div>
        </div>
      </div>
<!-- <script src="js/jquery-1.11.2.js"></script> -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-1.2.0.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>
