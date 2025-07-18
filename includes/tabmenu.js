/* 
 * Date : 25-04-2013
 * Project : NSB
 * Author : Abhishek 
 * 
 */

$(document).ready(function(){
    
    $('#menu .menu_parent ').live('focusin' , function(){

        $(this).addClass('over');
        $(this).find('.dropdown').css('left', 0); 
    });

    $('#menu .menu_parent').live('focusout' , function(){
        $(this).removeClass('over');
        $(this).find('.dropdown').css('left', -9999); 

    });

    $('#menu .menu_parent ').live('mouseenter' , function(){

        $(this).addClass('over');
        $(this).find('.dropdown').css('left', 0); 
    });

    $('#menu .menu_parent').live('mouseleave' , function(){
        $(this).removeClass('over');
        $(this).find('.dropdown').css('left', -9999); 

    });
});
