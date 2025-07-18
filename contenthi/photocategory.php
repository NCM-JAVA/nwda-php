
							<ul id="flexiselDemo3">
							<?php
						$photo_query = "select category.c_name,category.c_id,photogallery.sortdesc,photogallery.id,photogallery.img_uplode,photogallery.gallery_type from photogallery inner join category on category.c_id = photogallery.category_id where photogallery.approve_status='3'  and photogallery.gallery_type='1' and category.c_name!='Home Page Banner'  group by photogallery.category_id  order by category.c_id  desc limit 0,6  ";
						$photo_result = $conn->query($photo_query);
						$res_rows = $photo_result->num_rows;
						while($fetch_result = $photo_result->fetch_array())
						{
                                        $newimg_uplode = $fetch_result['img_uplode'];
										$image_path = $HomeURL.'/upload/photogallery/media/'.$newimg_uplode;
						?>
								<li><a href="view_all_photogallery.php?catid=<?php echo  $fetch_result['c_id'];  ?>"><img style="width:180px; height:110px;" title="img" alt="video_img" src="<?php echo $image_path;?>">	</a></li>
                  <?php }  ?>
							</ul>
							