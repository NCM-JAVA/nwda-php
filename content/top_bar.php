<div class="top-bar">
  <ul class="list-inline">
    <li class=""> </li>
    <li><a  href="#skipCont"><img src="<?php echo $HomeURL?>/images/skip.png" alt="skip" title="skip to main content">Skip to Main Content</a></li>
    <li><a  href="<?php echo $HomeURL?>/content/screen_reader.php" title="Screen Reader Acess">Screen Reader Access</a></li>
    <li><a href="<?php echo $HomeURL?>/content/sitemap.php"><img src="<?php echo $HomeURL?>/images/sitemap.png" alt="sitemap" title="sitemap"></a></li>
    <li> <a href="javascript:void(0);" title="Normal"  onclick="setActiveStyleSheet('style'); return false;"><img src="<?php echo $HomeURL?>/images/a.png" alt="Default Theme" title="Default Theme"></a> 
    <a href="javascript:void(0);" title="High Contrast"  onClick="setActiveStyleSheet('change'); return false;"><img src="<?php echo $HomeURL?>/images/hign_contrast.png" alt="high contrast"></a> 
    <a href="javascript:void(0);" title="Reset font size" onClick="set_font_size('')"><img src="<?php echo $HomeURL?>/images/a.png" alt="reset font" title="reset font"></a> 
    <a href="javascript:void(0);" title="Increase font size" onClick="set_font_size('increase')"><img src="<?php echo $HomeURL?>/images/increase.png" alt="increase font" title="increase font"></a> 
    <a href="javascript:void(0);" title="Decrease font size" onClick="set_font_size('decrease')"><img src="<?php echo $HomeURL?>/images/decrease.png"  alt="decrease font" title="decrease font"></a> </li>
    <li> <a href="javascript:void(0);" title="blue" onClick="setActiveStyleSheet('style'); return false;"><img src="<?php echo $HomeURL?>/images/blue.png" alt="blue color" title="blue color"></a> 
    <a href="javascript:void(0);" title="orange" onClick="setActiveStyleSheet('orange'); return false;"><img src="<?php echo $HomeURL?>/images/orange.png"  alt="orange color " title="orange color"></a> 
    <a href="javascript:void(0);" title="green" onClick="setActiveStyleSheet('green'); return false;"><img src="<?php echo $HomeURL?>/images/green.png" alt="green color" title="green color"></a> </li>
	<li><a href="https://twitter.com/NWDA_MOWR/media" target="blank"><img src="<?php echo $HomeURL?>/images/twitter.png" alt="twitter" title="Twitter" style="width:25px;"></a></li>
<li><a href="https://www.facebook.com/NWDA.MOJS/" target="blank"><img src="<?php echo $HomeURL?>/images/facebook1.png" alt="facebook" title="facebook" style="width:25px;"></a></li>
   <?php /* <li class="dropdown"><a href="#"><img src="<?php echo $HomeURL?>/images/social.png" alt="social" title="social"></a>
<ul class="dropdown-content">

</ul> 
</li> */ ?>  
    <li>
	<a href="<?php echo $HomeURL?>/content/search.php"><img src="<?php echo $HomeURL?>/images/search.png" alt="search" title="search"></a>
	</li>
    <li><a href="<?php echo $HomeURL?>/contenthi/index.php"><img src="<?php echo $HomeURL?>/images/hindi.png" alt="Hindi" title="Hindi" onclick="return langvisit();"  onkeypress="return langvisit();"></a></li>
    <li>
            <?php if(isset($_SESSION['login_user'])){ ?>
                <span style="color:white; font-weight:bold;">Welcome <a style="margin-right:8px;" href="<?php echo $HomeURL?>/auth/"><?php echo $_SESSION['login_user'];?></a>
                    <div>
                        <?php include('menu.php'); ?>
                    </div>
                </span>
            <?php }else{ ?>
                <a href="<?php echo $HomeURL?>/auth/">Employee login</a>
            <?php } ?>
        </li>
  </ul>
</div>
	<div class="container-fluid main-header">
				<div class="row">
					<div class="col-xs-3">
						<div class="emblem" style="margin-right: 50px;">
							<a href="<?php echo $HomeURL?>/content/index.php" style="color:#fff;"><img src="<?php echo $HomeURL?>/images/emblem.png" alt="National Water Development Agency" title="National Water Development Agency"></a>
							<a href="https://amritmahotsav.nic.in/index.htm" style="color:#fff;"><img src="<?php echo $HomeURL?>/images/logo1.png" width="140" alt="elixir of freedom festival" title="elixir of freedom festival"></a>
						</div>
						
					</div>
					<div class="col-xs-7">
						<div class="logo">
							<a href="<?php echo $HomeURL?>/content/index.php" style="color:#fff;"><img src="<?php echo $HomeURL?>/images/logo.png" style="height: 114px;" alt="logo" title="logo"></a>
						</div>
					</div> 
					<div class="col-xs-2">
						<div class="national_emblem">
							<a href="javascript:void(0);" style="color:#fff;"><img src="<?php echo $HomeURL?>/images/national_emblem.png" style="height: 114px;" alt="national emblem" title="Satyamev Jayate" ></a>
							<a href="https://www.g20.org/en" style="color:#fff;"><img src="<?php echo $HomeURL?>/images/g20-logo1.png" style="width: 120px;" alt="G20 logo" title="G20"></a>
						</div>
					</div>
				</div>

			</div>
<script>
    function langvisit()
    {

        if (!confirm('Are you sure you want to move to hindi language?'))
            return false;

    }
	
	function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}
</script> 

