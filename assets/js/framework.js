
jQuery(document).ready(function(){
						   
 //$("body").append("<a target='_blank' class='ico-responsive' href='devise/responsive.html'>Check Responsive</a>");
						   

	//contrast
	if(getCookie('contrast') == 0 || getCookie('contrast') == null){
	jQuery(".light").hide();
	jQuery(".dark").show();
    }else{
	jQuery(".light").show();
	jQuery(".dark").hide();
}


// Fix Header

	var num = 36; //number of pixels before modifying styles
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > num) {
        $('.fixed-wrapper').addClass('sticky');
		
    
        } else {
        $('.fixed-wrapper').removeClass('sticky');
    
        }
    });

	
/*	var num = 146; //number of pixels before modifying styles
            $(window).bind('scroll', function () {
                if ($(window).scrollTop() > num) {
                $('.nav-wrapper').addClass('sticky');
				
            
                } else {
                $('.nav-wrapper').removeClass('sticky');
            
                }
            });*/
			
			
			
			
	/*var num = 146; //number of pixels before modifying styles
            $(window).bind('scroll', function () {
                if ($(window).scrollTop() > num) {
                $('.search-el').addClass('sticky');
				
            
                } else {
                $('.search-el').removeClass('sticky');
            
                }
            });*/
			
			
			
			
			
		
	
// Mobile Nav	
$('.sub-menu').append('<i class="fa fa-caret-right"></i>');
	$('.toggle-nav-bar').click(function(){	
	$('#nav').slideToggle();
	$('#nav li').removeClass('open');
    $("#nav li").click(function(){
		$("#nav li").removeClass('open');
		$(this).addClass('open');
	}); 
		
	});

	
//Skip Content
$('a[href^="#skipCont"]').click(function() {
$('html,body').animate({ scrollTop: $(this.hash).offset().top}, 500);
return false;
e.preventDefault();

});

// Toggle Search



    $("#toggleSearch").click(function(e) {
        $(".search-drop").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if (!$(e.target).is('.search-drop, .search-drop *')) {
            $(".search-drop").hide();
        }
    });





// Toggle social
/*$('#toggleSocial').click(function(){
$('.social-drop').slideToggle();
})*/

// Toggle social
/*$('#toggleAccessibility').click(function(){
$('.access-drop').slideToggle();
})*/


})









//Drop down menu for Keyboard accessing

function dropdown1(dropdownId, hoverClass, mouseOffDelay) { 
	if(dropdown = document.getElementById(dropdownId)) {
		var listItems = dropdown.getElementsByTagName('li');
		for(var i = 0; i < listItems.length; i++) {
			listItems[i].onmouseover = function() { this.className = addClass(this); }
			listItems[i].onmouseout = function() {
				var that = this;
				setTimeout(function() { that.className = removeClass(that); }, mouseOffDelay);
				this.className = that.className;
			}
			var anchor = listItems[i].getElementsByTagName('a');
			anchor = anchor[0];
			anchor.onfocus = function() { tabOn(this.parentNode); }
			anchor.onblur = function() { tabOff(this.parentNode); }
		}
	}
	
	function tabOn(li) {
		if(li.nodeName == 'LI') {
			li.className = addClass(li);
			tabOn(li.parentNode.parentNode);
		}
	}
	
	function tabOff(li) {
		if(li.nodeName == 'LI') {
			li.className = removeClass(li);
			tabOff(li.parentNode.parentNode);
		}
	}
	
	function addClass(li) { return li.className + ' ' + hoverClass; }
	function removeClass(li) { return li.className.replace(hoverClass, ""); }
}

jQuery(document).ready(function(){
	
	dropdown1('header-nav','hover',10);


});




















