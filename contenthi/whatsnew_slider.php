<h2 class="block__title block-title">What's New <span class="view_all"><a href="<?php echo $HomeURL;?>/content/whatsnew.php" title="View All about What's News">View all</a></span></h2>
 <div class="view-header">
      <div class="buttons">
	    <a id="start" href="#" title="Play" class="play_b"> <img width="30" height="30" src="../theme/images/playicon.png" alt="Play"></a> 
        <a id="stop" href="#" title="Stop" class="stop_b"><img width="30" height="30" src="../theme/images/pauseicon.png" alt="Stop" title="Pause"> </a>
     </div>      
<div class="newsrotator">      
      <div id="newsrow" class="marquee" >
        <ul>
              <?php 
		$date=date('Y-m-d');
		$querysql=mysql_query("select * from combine_publish where cat_id=1 and language_id=1 and approve_status=3 and date(end_date ) > '$date' order by m_id desc");
		while($row_what_news=mysql_fetch_array($querysql))
		{
                    $diff = (strtotime($edate)- strtotime($sdate))/24/3600; 
                    //echo $diff;
                    $sdate=changeformate(date('Y-m-d'));
                    $edate=changeformate($row_what_news['end_date'])
                ?>
            <li >
              <?php 
		if($row_what_news['c_new_status'] =='2'){ ?>
		<?php }else {?> <img src="<?php echo $HomeURL;?>/assets/images/new_icon.png" alt="News icons" title="News icons" width="30px" height="25px">  <?php }
		?>     
		<h1><?php  echo $row_what_news['m_name'];?></h1>
		
		<?php if($diff <='5') { ?>
		<?php echo stripslashes(html_entity_decode($row_what_news['m_content']));?>
		<?php } else { ?>
		<?php echo stripslashes(html_entity_decode($row_what_news['m_content']));?>
		<?php }?>
		<span>Posted on <?php echo changeformate($row_what_news['create_date']);?></span>
           <li>
           <?php }?>
          </ul>
 </div>
</div> 
</div> 