<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
 
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
<?php  

$sql=$conn->query("Select b_name,b_title,b_image_path,b_short_desc,b_id from banner_publish where approve_status='3' and b_language='1' ORDER BY  page_postion ASC LIMIT 0,25");
$m=1;
while($banner=$sql->fetch_array()){ 
   ?>
    <div class="item <?php if($m==1) {   echo "active";  } ?>">
	
      <img src="<?php echo $HomeURL;?>/upload/banner/<?php echo $banner['b_image_path'];?>"<?php if($banner['b_id']==190){?>onclick="javascript:window.open('https://www.mygov.in/task/logo-design-ken-betwa-link-project-authority/')" style="cursor:pointer;"<?php } ?> alt="banner" title="banner"   class="height100per"> 
	<?php if($banner['b_id']!=90 && $banner['b_id']!=73){?>
      		<div class="carousel-caption caption">
			<p><?php echo str_replace($healthy, $yummy,html_entity_decode($banner['b_name'])); ?></p>
		</div>
	<?php } ?>
    </div>
<?php $m++; }  ?>
  </div>
 
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"  title="Previous">
    <span class="glyphicon glyphicon-chevron-left" style="margin-left: -25px;"><span style="display:none;">Previous</span></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next" title="Next">
    <span class="glyphicon glyphicon-chevron-right" style="margin-right: -25px;"><span style="display:none;">Next</span></span>
  </a>
</div> 
