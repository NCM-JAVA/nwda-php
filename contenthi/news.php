<h3>क्या खबर है <a href="#" class="btnToggle" title="btnToggle">play</a></h3>
<div class="demo5 demof">
	<ul class="list-group">
		<?php  
			$date = date('Y-m-d');
			//$sqlnews="select * from combine_publish where cat_id='1' and approve_status='3' and language_id='2' and end_date >= $date  order by start_date desc limit 0,10 ";
      $sqlnews="select * from combine_publish where cat_id='1' and approve_status='3' and language_id='2' and date(end_date) >= '$date' and start_date  BETWEEN DATE_SUB(NOW(), INTERVAL 60 DAY) AND NOW() order by start_date desc";
			$resnews = $conn->query($sqlnews);
			while($rownews=$resnews->fetch_array())
			{
		?>	
			<li><p><?php  echo date('d-m-Y',strtotime($rownews['start_date']));  ?></p><a href="news-details.php?nid=<?php  echo $rownews['m_id'];  ?>"><?php  echo substr($rownews['m_name'],0,260); ?></a>
				<?php 
        $currentdate = date("Y-d-m");
        if($rownews['c_new_status']==1 && $rownews['start_date']== $currentdate){ ?><img src="<?php echo $HomeURL?>/images/new.gif" style="width:50px;"> <?php }else { ?> <?php } ?>
			</li>
		<?php }  ?>							
	</ul>
</div>
<a class="view-all" href="news-listing.php"  title="और देखें">और देखें</a>
