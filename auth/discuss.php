<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include('../design.php');

/*if($_SESSION['admin_auto']=='')
	{		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:".$HomeURL."/auth/index.php");
		exit;	
	}*/
	$qry="SELECT * from user_login where u_id='$admin_auto_id_sess'";
$result=mysql_query($qry);
$row=mysql_fetch_array( $result);
@extract($row);


// you need to set these value to match your configuration
$g_Title = "Discussion Forum";	// The title of this discussion forum
$g_URL = $HomeURL;		// Where this script lives (combined with $g_ThisPage)
$g_ContactEmail = "p.purohit@nic.in";		// Contact email address
$g_DisablePostCountInURLs = "0";		// set to "1" to stop topic URLs changing when new posts are added
$g_TopicsPerPage = 30;				// default number of topics to show per page
$g_ThisPage = "discuss.php";			// the name of this page
$g_Password = "G9#Y8rL^4J";			// to run database script
$g_HostName = "disabilityaffairgovDB";			// for mySQL connection, normally localhost
$g_UserName = "disabilityaffair";			// for mySQL connection
$g_DatabaseName = "disabilityaffair";			// for mySQL connection
$g_MySQLPassword = "G9#Y8rL^4J";		// for mySQL connection
$g_MessageListTableName = "messagelist";	// the message list table name in the database
$g_ThreadListTableName = "threadlist";		// the thread list table name in the database
//echo "===". $_SESSION['admin_auto_id_sess'];

//$_SESSION = array();



if( $_POST['cmd'] == "submitreply" || $_POST['cmd'] == "submitnew" || $_POST['cmd'] == "submitnewmail" )
{
	$expire = time() + 1296000;
	setcookie("cookie_fullname", $_POST['fullname'], $expire);
	setcookie("cookie_email", $_POST['email'], $expire);
}

function redirectTo( $url )
{
	// fire out the header
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");                          // HTTP/1.0
	$head = "Location: $url";
	header($head);
	exit;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Discussion Forum :: State Plan Division</title>
<meta name="description" content="Discussion Forum :: State Plan Division" />
<meta name="keywords" content="Discussion Forum :: State Plan Division"/>
<meta name="title" content="Discussion Forum :: State Plan Division" />
<meta name="language" content="en"/>
<link href="<?php echo $HomeURL;?>/style/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $HomeCss;?>/style/page-background.css" rel="stylesheet" type="text/css">
<link href="<?php echo $HomeURL;?>/style/develop_style.css" rel="stylesheet" type="text/css"><link href="<?php echo $HomeURL;?>/style/intenal-dropdown-menu.css" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo $HomeURL;?>/style/dropdown.css" id="css5" />
<script src="<?php echo $HomeURL;?>/js/jquery-1.11.2.js"></script>
<script src="<?php echo $HomeURL;?>/js/jquery-migrate-1.2.0.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/html5.js"></script>
<script src="<?php echo $HomeURL; ?>/js/dropdown.js" type="text/javascript"></script>
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo $HomeURL;?>/style/ie7.css">
<![endif]-->
        
        
<!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo $HomeURL;?>/style/ie8.css">
<![endif]-->
<style>
#register-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align: left;
}
</style>
<script language="JavaScript" src="<?php echo $HomeURL; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    msg: "required",
					fullname: "required",
					email: {
							required: true,
							email: true
						}
					
					
                },
                messages: {
                    msg: "Please Enter Post Comment Name",
					 fullname: "Please  Enter Valid Name",
                    email: "Please Enter Valid Email Id"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>

</head>

<body>
<!--Accessibility-->
<?php include('../content/header.php');?>
<!--Content-Section--> 
<div id="content-area">  
<div id="content-s-internal">



<section>
<div id="internal-page">
<div class="internal-heading">
<h2> Discussion Forum </h2>
    </div>
 <div class="clear"> </div>

  <div class="breadcrum-section">
<div class="breadcrum"> 
<ul>
<li><a href="<?php echo $HomeURL;?>/content" title="Home Page" class="first"> <img src="<?php echo $HomeURL;?>/images/home-icon.png" width="20" height="21" alt="Home Icon"></a></li>
<li class="last">Discussion Forum </a></li>
</ul>

</div>

<div class="print_button"><a href="javascript: void(0)" title="Print Document" onClick="javascript: window.print()"><img src="<?php echo $HomeURL; ?>/images/print_icon.png" alt="Print" width="14" height="12" border="0"/></a></div>

  <div class="clear">  </div><?php if($_SESSION['admin_auto'] !='')
	{	?>
	
	<span class="log_out">
 <a href="<?php echo $HomeURL;?>/auth/logout.php" title="Logout">Logout </a>
 </span>	
		
	<?php }?>
 </div>


<div class="discuss-form">
<div class="discuss-box"> 
<?php 
function PageHeader()
{
	global $g_ThisPage, $g_Title;

}
 
function PageFooter()
{
?>
          
        </div>



<?php 

	$HomeURL = "http://disabilityaffairs.gov.in";   

?>



</div>

<div class="clear"> </div>



</div>
</section> 


<!-- footer botom-->
<?php include('../content/footer-botom.php');?>
 </div>
<div class="clear">  </div>
</div>




</div>
<?php include('../content/footer.php');?>
  

<?php
}
function PrintStandardFooter($above)
{
	global $g_ThisPage;

	print "<hr />\n";
	if( strlen($above) > 0 )
		print "$above\n";
	print "<a href=\"$g_ThisPage\" title='Recent Topics' >Back to Topics</a>\n";
	//print "<br />Go to <a href=\"http://www.johnsadventures.com/\">John's Adventures</a>\n";
	print "<p></p>\n";
	PageFooter();	
}

function DBError($error_message, $printHeader=true)
{
	global $g_ThisPage;
	if( $printHeader )
		PageHeader();
		
	print "<p><strong>Error!!!!</strong> [$error_message]</p>\n";
	print "<p>Click here to <a href=\"$g_ThisPage?cmd=runscripts\">run database scripts</a>, that might fix it!</p>\n";
	PrintStandardFooter("");
	die("");
}

function OpenSQLConnection()
{
	global $g_HostName, $g_UserName, $g_DatabaseName, $g_MySQLPassword;
	
	// Connecting, selecting database
	$link = mysql_connect($g_HostName, $g_UserName, $g_MySQLPassword)
		or DBError("Could not connect to the database");

	mysql_select_db($g_DatabaseName)
		or DBError("Could not select specified database");
	    
	return $link;
}

function CloseSQLConnection($link)
{
	mysql_close($link);
}

function DoQuery($query)
{
	$result = mysql_query($query)
		or DBError("SQL Query Failed - Oh dear.");
}

function HTMLEncode($text) 
{ 
	$searcharray = array( 
		"'([-_\w\d.]+@[-_\w\d.]+)'", 
		"'((?:(?!://).{3}|^.{0,2}))(www\.[-\d\w\.\/?=]+)'", 
		"'(http[s]?:\/\/[-_~\w\d\.\/?=]+)'"); 

	$replacearray = array( 
		" <a href=\"mailto:\\1\">\\1</a> ", 
		"\\1http://\\2", 
		" <a href=\"\\1\"> \\1</a> "); 

	return nl2br(preg_replace($searcharray, $replacearray, stripslashes($text) )); 
}

function StripHTML($str)
{
	// replace all tags with the appropriate characters
	$str = str_replace("<", "&lt;", $str); 
	$str = str_replace(">", "&gt;", $str); 
	
	// replace all lines with paragraphs
	$str = str_replace("\n", "</p> <p>", $str); 
	$str = str_replace("\r", "", $str); 

	// Add in hyperlinks where we can
	$str = HTMLEncode($str);

	// Break up long words
	list ($words) = array (split (" ", $str)); 
	$str = ''; 
	foreach ($words as $c => $word) 
	{ 
		if (strlen ($word) > 45 and !ereg("^href=", $word) and !ereg ("[\[|\]|\/\/]", $word)) 
			$word = chunk_split ($word, 45, " "); 

		if ($c) 
			$str .= ' '; 

		$str .= $word; 
	}

	return addslashes($str);
}

function StripHTMLSimple($str)
{
	// add spaces to very long strings
	list ($words) = array (split (" ", $str)); 
	$str = ''; 
	foreach ($words as $c => $word) 
	{ 
		if (strlen ($word) > 45 and !ereg ("[\[|\]|\/\/]", $word)) 
			$word = chunk_split ($word, 45, " "); 

		if ($c) 
			$str .= ' '; 

		$str .= $word; 
	}

	// replace all tags with the appropriate characters
	$str = str_replace("<", "&lt;", $str); 
	$str = str_replace(">", "&gt;", $str); 
	
	// replace all lines with spaces
	$str = str_replace("\n", " ", $str); 
	$str = str_replace("\r", "", $str); 
	return $str;
}

function RunScripts()
{
	global $g_MessageListTableName, $g_ThreadListTableName;
	
	DoQuery("Create TABLE IF NOT EXISTS $g_ThreadListTableName
		(ThreadID double NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Title text NULL,
		Author text NULL,
		Email text NULL,
		Posts double NULL,
		CreationDate datetime NOT NULL,
		LastPostedTo datetime NOT NULL )");
		
	DoQuery("Create TABLE IF NOT EXISTS $g_MessageListTableName
		(MessageID double NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Message text NULL,
		Author text NULL,
		Email text NULL,
		CreationDate datetime NOT NULL,
		ThreadID double NOT NULL )");
}

function PrintTitle($title)
{
	print "<h3> Topics </h3>";
}

function PrintError($error)
{
	print "<p class=\"errorText\">$error</p>\n";
}

function ShowLoginPage($error_message,$method,$to_post,$title)
{
	global $g_ThisPage;
	
	PageHeader();
	print "<span class=pageHeadline>$title</span><p></p>";
	if( strlen( $error_message ) > 0 )
		print "<p><strong>Error: $error_message</strong></p>\n";
?>
<P>Please enter the password to proceed:</P>
<form method="<?php print $method ?>" action="<?php print "$g_ThisPage" ?>">
 <div align="left">
  <table border="0" cellpadding="0" cellspacing="0" width="440">
   <tr>
    <td width="100" valign="top" align="left">Password:</td>
    <td width="340" valign="top" align="left"><input class="formBox" style="width: 175px" type="password" name="password" size="51" value="" /></td>
   </tr>
   <tr>
    <td valign="top" align="left"></td>
    <td valign="top" align="left">&nbsp;</td>
   </tr>
   <tr>
    <td valign="top" align="left"></td>
    <td valign="top" align="left"><input type="submit" value="Confirm" /></td>
   </tr>
  </table>
 </div>
 <input type="hidden" name="cmd" value="<?php print $to_post ?>" />
</form>
<?php
	PrintStandardFooter("");
}
function DeleteThisThread( $thread )
{
	global $g_MessageListTableName, $g_ThreadListTableName;
	
	$query1 = "DELETE FROM $g_ThreadListTableName WHERE ThreadID = '$thread'";
	$query2 = "DELETE FROM $g_MessageListTableName WHERE ThreadID = '$thread'";
	DoQuery( $query1 );
	DoQuery( $query2 );
}

function DeleteThisPost( $thread, $message )
{
	global $g_MessageListTableName, $g_ThreadListTableName;
	
	$query = "SELECT Posts FROM $g_ThreadListTableName WHERE ThreadID = $thread";
	$result = mysql_query($query)
	    or DBError("Failed while trying to delete post");
	    
	if( mysql_num_rows($result) == 1 )
	{
		$line = mysql_fetch_row($result);
		if( $line[0] == "1" )
			$query1 = "DELETE FROM $g_ThreadListTableName WHERE ThreadID = '$thread'";
		else
			$query1 = "UPDATE $g_ThreadListTableName set Posts=Posts-1 WHERE ThreadID = '$thread'";

		$query2 = "DELETE FROM $g_MessageListTableName WHERE MessageID = '$message'";
		DoQuery( $query1 );
		DoQuery( $query2 );
	}
}

function ShowThisThread( $thread, $password )
{
	global $g_ThisPage, $g_MessageListTableName;
	
	$title = PrintThreadName($thread);
	PageHeader();
	PrintTitle( "Manage Thread" );
	print "<p>Manage thread '$title'</p>";

	// perform an SqL query
	$query = "SELECT * FROM $g_MessageListTableName WHERE ThreadID = $thread ORDER BY CreationDate";
	$result = mysql_query($query)
	    or DBError("Failed while trying to show thread", false);
	    
	if( mysql_num_rows($result) < 1 )
	{
		// topic not found
		print "<p>Topic $thread either doesn't exist or has been deleted.</p>\n";
		PrintStandardFooter("View <a href=\"$g_ThisPage?cmd=postmanage&amp;password=$password\">Management Page</a>");
		return;
	}

	// Printing results in HTML
	print "<div><table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n";
	print "<tr><th>ID</th><th>Action</th><th>Message</th><th>Author</th></tr>\n";

	while ($line = mysql_fetch_row($result)) 
	{
		print "<tr><td>$line[0]</td><td><a href=\"$g_ThisPage?cmd=manage_deletePost&amp;password=$password&amp;&amp;thread=$line[5]&amp;message=$line[0]\"";
		print "onclick=\"return confirm('Delete this post?')\">";
		print "delete</a></td><td>$line[1]</td><td>$line[2]</td></tr>\n";
	}
	
	print "</table><p></p></div>\n";
	PrintStandardFooter("View <a href=\"$g_ThisPage?cmd=postmanage&amp;password=$password\">Management Page</a>");
}

function ShowTopicManagementList($password)
{
	global $g_ThisPage, $g_ThreadListTableName;
	PageHeader();
	PrintTitle("Manage Discussion Forum");
	print "<p>Manage the topics and posts below:</p>";
	
	// Performing SQL query
	$query = "SELECT * FROM $g_ThreadListTableName ORDER BY ThreadID DESC";
	$result = mysql_query($query)
	    or DBError("Failed while trying to show topic management list", false);

	if( mysql_num_rows($result) > 0 )
	{
		// Printing results in HTML
		print "<div><table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n";
		print "<tr><th>Thread</th><th>Action</th><th>Title</th><th>Author</th><th>Posts</th></tr>\n";
		while ($line = mysql_fetch_row($result)) 
		{
			print "<tr><td>$line[0]</td><td><a href=\"$g_ThisPage?cmd=manage_deleteThread&amp;password=$password&amp;thread=$line[0]\" ";
			print "onclick=\"return confirm('Delete this thread?')\">delete</a></td>";
			print "<td><a href=\"$g_ThisPage?cmd=manage_showThread&amp;password=$password&amp;thread=$line[0]\">$line[1]</a></td><td>$line[2]</td><td>$line[4]</td></tr>\n";
		}
	
		// Closing connection
		print "</table><p></p></div>\n";
	}
	else
	{
		// if nothing there
		print "<p>There are no entries in the discussion forum.</p>\n";
	}

	PrintStandardFooter("View <a href=\"$g_ThisPage?cmd=postmanage&amp;password=$password\">Management Page</a>");
}
function PrintThreadList($page=0)
{
	global $g_ThisPage, $g_Title, $g_DisablePostsInURLs, $g_TopicsPerPage, $g_ThreadListTableName;
	
	PageHeader();
	PrintTitle("$g_Title");
	//print "<p>An example of a simple discussion forum just like on <a href=\"http://www.joelonsoftware.com/\">Joel's site</a>...</p>\n";

	// Performing SQL query
	 $query = "SELECT * FROM $g_ThreadListTableName where t_status='1' ORDER BY ThreadID DESC";
	$result = mysql_query($query)
	    or DBError("Failed while trying to show thread list", false);

	$rows = mysql_num_rows($result);
	if( $rows > 0 &&
		$rows > $g_TopicsPerPage )
	{
		while( $rows < $page * $g_TopicsPerPage + 1 )
		{
			$page--;
		}
		
		if( $page > 0 )
		{
			// shift results pointer forward to correct place
			mysql_data_seek( $result, $page * $g_TopicsPerPage );
		}
	}

	if( mysql_num_rows($result) > 0 )
	{
		// Printing results in HTML
		print "";
		$count = 0;
		while ($count < $g_TopicsPerPage and $line = mysql_fetch_row($result)) 
		{
			
			$lword=word_limiter($line[2]);

			$to_print = "\t<div class=\"diss\">
			 <img src='../images/diss-icon.png' width='33' height='33' alt='icons' title='icons'>
			<div class=\"dis-inerbox\">
			<h3><a href=\"$g_ThisPage?cmd=show&amp;thread=$line[0]";
			
			if( $g_DisablePostsInURLs != "1" )
			
			$to_print .= "&amp;posts=$line[5]";
			
			$to_print .= "\" title='$line[1]'>$line[1]</a></h3><p>$lword</p>";
			
			print "$to_print";
			
			print "<h3><i>";
			print "Posts : $line[5]";
			/*if( $count == 0 )
			{
				if( $line[4] == "1" )
					print "post";
				else
					print " posts";
			}*/
			print "";
				
			print "</i></h3> 
			
			<h4>By <strong>$line[3]</strong>";
			print "<p>$line[6]</p></h4>\n";
			$count = $count + 1;
		}
	
		print "";
		
		// show previous / next links if necessary
		if( $rows > $g_TopicsPerPage )
		{
			print "<br /><div class=\"subtle\">";
			if( $page > 0 )
			{
				$prev = $page - 1;
				print "<a href=\"$g_ThisPage?cmd=offset&amp;page=$prev\">&lt; Previous $g_TopicsPerPage topics</a> ";
			}
			if( $rows > ( $page + 1 ) * $g_TopicsPerPage )
			{
				$next = $page + 1;
				print " <a href=\"$g_ThisPage?cmd=offset&amp;page=$next\">Next $g_TopicsPerPage topics &gt;</a>";
			}
			
			print "</div>";
		}
	}
	else
	{
		// if nothing there
		print "<p>There are no entries in the discussion forum. Why not create a new one below?</p>\n";
	}

	// Add a link to post a new topic with
	PageFooter();	
	//"Start a <a href=\"$g_ThisPage?cmd=new\">New Topic</a>"
}

function PrintThreadList($page=0)
{
	global $g_ThisPage, $g_Title, $g_DisablePostsInURLs, $g_TopicsPerPage, $g_ThreadListTableName;
	
	PageHeader();
	PrintTitle("$g_Title");
	//print "<p>An example of a simple discussion forum just like on <a href=\"http://www.joelonsoftware.com/\">Joel's site</a>...</p>\n";

	// Performing SQL query
	 $query = "SELECT * FROM $g_ThreadListTableName where t_status='1' ORDER BY ThreadID DESC";
	$result = mysql_query($query)
	    or DBError("Failed while trying to show thread list", false);

	$rows = mysql_num_rows($result);
	if( $rows > 0 &&
		$rows > $g_TopicsPerPage )
	{
		while( $rows < $page * $g_TopicsPerPage + 1 )
		{
			$page--;
		}
		
		if( $page > 0 )
		{
			// shift results pointer forward to correct place
			mysql_data_seek( $result, $page * $g_TopicsPerPage );
		}
	}

	if( mysql_num_rows($result) > 0 )
	{
		// Printing results in HTML
		print "";
		$count = 0;
		while ($count < $g_TopicsPerPage and $line = mysql_fetch_row($result)) 
		{
			
			$lword=word_limiter($line[2]);

			$to_print = "\t<div class=\"df-content\">
			<div class=\"dis-inerbox\">
			<div class=\"topic\"> <div class=\"icon\"> </div>   <h3><a href=\"$g_ThisPage?cmd=show&amp;thread=$line[0]";
			
			if( $g_DisablePostsInURLs != "1" )
			
			$to_print .= "&amp;posts=$line[5]";
			
			$to_print .= "\" title='$line[1]'>$line[1]</a></h3><p>$lword</p></div> ";
			
			print "$to_print";
			
			print "<div class=\"post\"><i>";
			print "Posts : $line[5]";
			/*if( $count == 0 )
			{
				if( $line[4] == "1" )
					print "post";
				else
					print " posts";
			}*/
			print "";
				
			print "</i></div> 
			
			<div class=\"name\">By <strong>$line[3]</strong>";
			print "<p>$line[6]</p></div>
			<div class=\"clear\">  </div></div>\n";
			$count = $count + 1;
		}
	
		print "";
		
		// show previous / next links if necessary
		if( $rows > $g_TopicsPerPage )
		{
			print "<br /><div class=\"subtle\">";
			if( $page > 0 )
			{
				$prev = $page - 1;
				print "<a href=\"$g_ThisPage?cmd=offset&amp;page=$prev\">&lt; Previous $g_TopicsPerPage topics</a> ";
			}
			if( $rows > ( $page + 1 ) * $g_TopicsPerPage )
			{
				$next = $page + 1;
				print " <a href=\"$g_ThisPage?cmd=offset&amp;page=$next\">Next $g_TopicsPerPage topics &gt;</a>";
			}
			
			print "</div>";
		}
	}
	else
	{
		// if nothing there
		print "<p>There are no entries in the discussion forum. Why not create a new one below?</p>\n";
	}

	// Add a link to post a new topic with
	PageFooter();	
	//"Start a <a href=\"$g_ThisPage?cmd=new\">New Topic</a>"
}

function PrintThreadName($thread)
{
	global $g_ThreadListTableName;
	
	$query = "SELECT Title FROM $g_ThreadListTableName WHERE ThreadID = $thread";
	$result = mysql_query($query)
	    or DBError("Failed while trying to find the thread name");

	$line = mysql_fetch_row($result);
	if ($line)
		$title = $line[0];
		
	return $title;
}

function PrintSingleThread($thread,$error)
{
	global $g_ThisPage, $g_MessageListTableName,$HomeURL;
	
	if( strlen($error) > 0 )
		PrintError($error);
	
	// perform an SqL query
		$query = "SELECT MessageID,Message,Author,DATE_FORMAT(CreationDate, '%b %d %Y %h:%i %p') AS mydatestring FROM $g_MessageListTableName WHERE ThreadID = $thread  and m_status='1' ORDER BY MEssageID ASC LIMIT 1,100";
		$result = mysql_query($query)
	    or DBError("Failed while trying to find the thread in the database");

		$nquery = "SELECT Title,short_des,Author,DATE_FORMAT(CreationDate,'%b %d %Y %h:%i %p') as CreationDate from threadlist WHERE ThreadID = $thread ";
		$nresult = mysql_query($nquery);
	
	    //or DBError("Failed while trying to find the thread in the database");
		$nline = mysql_fetch_row($nresult);
		$title= $nline['Title'];
		if( mysql_num_rows($result) < 0 )
		{
			// topic not found
			PageHeader();
			PrintTitle( "Message doesn't exist" );
			print "<p>Topic $thread either doesn't exist or has been deleted.</p>\n";
			PrintStandardFooter("Post <a href=\"$g_ThisPage?cmd=new\">New Topic</a>");
			return;
		}
	
	// print out a heading
	$title = PrintThreadName($thread);
	PageHeader();

	//PrintTitle($title);

//print_r($nline);

print '<div class="blog-section">
<div class="discuss-form">
<div class="return-button"><a href="discuss.php">Back to Topics </a></div>
<div class="clear"> </div>

	<div class="discuss-box"> 


<div class="topic-inerbox">
	<h3>'.$nline['0'].'<br />
	<span>By <strong>'.$nline['2'].'</strong>
	'.$nline['3'].'</span>
	</h3>


	<p> '.$nline['1'].' </p>

<span class="reply-box">';

if($_SESSION['admin_auto']=='')
	{		
		print '<a href="'.$HomeURL.'/auth/index.php" title="Reply With Quote"> Reply With Quote</a></h2>';

	}else{
		print '<a href='.$g_ThisPage.'?cmd=reply&amp;thread='.$thread.' title="Reply With Quote" > Reply With Quote</a></h2>';
	}
print '</span>
<div class="clear"> </div>
</div>'; 

		$i=0;
		while ($line = mysql_fetch_row($result)) 
		{
		if($i==0){ $add=''; }
		else { $add.='&nbsp;&nbsp;';}

		print'
		<div class="comment-ontopic"> 
		<div class="user-icon">
		<span class="user-img"><img src="../images/user.png" width="48" height="48" alt="User"></span>
		<p>'.$line[2].'
		<br />'.$line[3].'</p>
		 </div>

		<div class="comment-comment">
		<p>'.$add.$line[1].'  </p></div>
		<div class="clear"> </div>
		</div>';  
	$i++;
			}

 
 print'</div>';
	
	/* print'<div class="discussion-forum-in"> 

	<div class="dic-date">'.$nline['3'].'  </div>
	<div class="df-heading"><h2>'.$nline['2'].'</h2></div>

	<div class="df-content-in">   
	<div class="topic-in">'.$nline['1'].'
	<h2 class="reply-link">';

	if($_SESSION['admin_auto']=='')
	{		
		print '<a href="'.$HomeURL.'/auth/index.php" title="Reply With Quote"> Reply With Quote</a></h2>';

	}else{
		print '<a href='.$g_ThisPage.'?cmd=reply&amp;thread='.$thread.' title="Reply With Quote" > Reply With Quote</a></h2>';
	}


	$i=0;
	while ($line = mysql_fetch_row($result)) 
	{
	if($i==0){ $add=''; }
	else { $add.='&nbsp;&nbsp;';}
	
	print'<div class="s-reply">';
	print'<h3>'.$add.'Replied By <span>'.$line[2].'</span> <span class="dates">'.$line[3].'</span> </h3>';
	print'<p>'.$add.$line[1].'&nbsp;&nbsp;</p>';
	print '</div><div class="clear">  </div><p></p>';

	$i++;
	}


	print'</div>
	</div>
</div>

<div class="df-heading-in"></div>
<div class="clear"></div>';*/

PageFooter();
}

function CreateNewThread($title, $fullname, $email)
{
	global $g_ThreadListTableName;
	
	// Performing SQL query
	$datetime = date("Y-m-d H:i:s");
	$title = StripHTMLSimple($title);
	$fullname = StripHTMLSimple($fullname);
	$email = StripHTMLSimple($email);
	$messagecount = 0;

	// tidy up user name
	$fullname = trim($fullname);
	
	// See if the thread has already been created
	$query = "SELECT * FROM $g_ThreadListTableName";
	$result = mysql_query($query)
	    or DBError("Failed to query the thread list");

	// Examine each row looking for a match
	while ($line = mysql_fetch_row($result)) 
	{
		// if the title and the author match, assume it is a duplicate
		if (($line[1] == $title) and ($line[2]==$fullname))
			return $line[0];
	}

	// We did not find the thread, so start a new one
	$query = "INSERT INTO $g_ThreadListTableName VALUES (NULL, '$title', '$fullname', '$email', '$messagecount', '$datetime', '$datetime')";
	$result = mysql_query($query)
	    or DBError("Failed to add a new thread");
	    
	return mysql_insert_id();
}

function CreateNewMessage($msg, $fullname, $email, $thread, $flag_id)
{
	global $g_MessageListTableName, $g_ThreadListTableName;

	// Performing SQL query
	$datetime = date("Y-m-d H:i:s");
	$msg = StripHTML($msg);
	$fullname = StripHTMLSimple($fullname);
	$email = StripHTMLSimple($email);

	// tidy up user name
	$fullname = trim($fullname);
	
	// See if the thread has already been created
	$query = "SELECT * FROM $g_MessageListTableName WHERE ThreadID = $thread";
	$result = mysql_query($query)
	    or DBError("Failed to search the database for threads");

	// Examine each row looking for a match
	while ($line = mysql_fetch_row($result)) 
	{
		// if the message and the author match, assume it is a duplicate
		if (($line[1] == $msg) and ($line[2]==$fullname))
			return;
	}

	// was not a duplicate, so add it
	 $query = "INSERT INTO $g_MessageListTableName VALUES (NULL, '$msg', '$fullname', '$email', '$datetime', '$thread','$flag_id','0')";
	$result = mysql_query($query)
	    or DBError("Failed to add a new message");
	    
	// update the thread message count
	$query = "UPDATE $g_ThreadListTableName set Posts=Posts+1 WHERE ThreadID = $thread";
	$result = mysql_query($query)
	    or DBError("Failed to update the posts counter");
	    
	// update last posted date
	$query = "UPDATE $g_ThreadListTableName set LastPostedTo='$datetime' WHERE ThreadID = $thread";
	$result = mysql_query($query)
	    or DBError("Failed to update the last posted to date");
	    
	return GetPostsCount($thread);
}

function GetPostsCount($thread)
{
	// find out how many posts there now are
	global $g_ThreadListTableName;
	
	$query = "SELECT Posts FROM $g_ThreadListTableName WHERE ThreadID = $thread";
	$result = mysql_query($query)
		or DBError("Failed to find out how many posts there are");

	if( mysql_num_rows($result) == 1 )
	{
		$line = mysql_fetch_row($result);
		return $line[0];
	}
		
	return 0;
}

function ShowNewTopicForm($pageTitle, $title, $message, $error)
{
	global $g_ThisPage, $_COOKIE;
	$cookie_fullname = $_COOKIE['cookie_fullname'];
	$cookie_email = $_COOKIE['cookie_email'];
	$cookie_website = $_COOKIE['cookie_website'];
	
	PageHeader();
	PrintTitle($pageTitle);
	if( strlen($error) > 0 )
		PrintError($error);	
	?>
	<form method="post" action="<?php print "$g_ThisPage" ?>">
	  <div align="left">
	    <table border="0" cellpadding="0" cellspacing="0" width="440">
	      <tr>
	        <td width="100" valign="top" align="left">Title:</td>
	        <td width="340" valign="top" align="left"><input class="formBox" type="text" name="title" size="51" value="<?php print "$title" ?>" /></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Message<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><textarea class="formBox" rows="7" name="msg" cols="43"><?php print "$message" ?></textarea></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="subtle">Do not use HTML tags. Surround URLs with spaces.</span></td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left">&nbsp;</td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Full Name<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="fullname" value="<?php print "$cookie_fullname" ?>" size="64" /></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">E-mail:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="email" value="<?php print "$cookie_email" ?>" size="64" /></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="requiredWarning">* - Required for processing</span></td>
              </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left">&nbsp;</td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left" ><input type="submit" value="Post Message" /></td>
	      </tr>
	    </table>
	  </div>
	  <input type="hidden" name="cmd" value="submitnew" />
	</form>
	<?php
	
	PrintStandardFooter("");
}

function ShowReplyForm($msg, $thread, $error)
{
	global $g_ThisPage, $_COOKIE;
	$cookie_fullname = $_COOKIE['cookie_fullname'];
	$cookie_email = $_COOKIE['cookie_email'];
	$cookie_website = $_COOKIE['cookie_website'];

	if( strlen($error) > 0 )
		PrintError($error);
	?>
	<form method="post" id="register-form" name="register-form" action="<?php print "$g_ThisPage" ?>">
	  <div align="left">
	    <table border="0" cellpadding="0" cellspacing="0" width="440">
	      <tr>
	        <td valign="top" align="left"><strong>Message<span class="requiredWarning">*</span>:</strong></td>
	        <td valign="top" align="left"><textarea class="formBox" rows="7" name="msg" cols="43"><?php print "$msg" ?></textarea></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="subtle">Do not use HTML tags. Surround URLs with spaces.</span></td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left">&nbsp;</td>
	      </tr>
	      <tr>
	        <td valign="top" align="left"><strong>Full Name<span class="requiredWarning">*</span>:<strong></td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="fullname" value="<?php print "$cookie_fullname" ?>" size="64" /></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left"><strong>E-mail:<strong></td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="email" value="<?php print "$cookie_email" ?>" size="64" /></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="requiredWarning">* - Required for processing</span></td>
              </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left">&nbsp;</td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left"><input type="submit" value="Post Reply" /></td>
	      </tr>
	    </table>
	  </div>
	  <input type="hidden" name="thread" value="<?php print "$thread" ?>" />
	  <input type="hidden" name="cmd" value="submitreply" />
	</form>
	<?php
	
	PrintStandardFooter("");
}

function ShowReplyForm_next($msg,$thread, $error,$message)
{
	global $g_ThisPage, $_COOKIE;
	$cookie_fullname = $_COOKIE['cookie_fullname'];
	$cookie_email = $_COOKIE['cookie_email'];
	$cookie_website = $_COOKIE['cookie_website'];

	if( strlen($error) > 0 )
		PrintError($error);
	?>
	<form method="post" action="<?php print "$g_ThisPage" ?>">
	  <div align="left">
	    <table border="0" cellpadding="0" cellspacing="0" width="440">
	      <tr>
	        <td valign="top" align="left">Message<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><textarea class="formBox" rows="7" name="msg" cols="43"><?php print "$msg" ?></textarea></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="subtle">Do not use HTML tags. Surround URLs with spaces.</span></td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left">&nbsp;</td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Full Name<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="fullname" value="<?php print "$cookie_fullname" ?>" size="64" /></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">E-mail:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="email" value="<?php print "$cookie_email" ?>" size="64" /></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="requiredWarning">* - Required for processing</span></td>
              </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left">&nbsp;</td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left"><input type="submit" value="Post Reply" /></td>
	      </tr>
	    </table>
	  </div>
	  <input type="hidden" name="thread" value="<?php print "$thread" ?>" />
	   <input type="hidden" name="message" value="<?php print "$message" ?>" />
	  <input type="hidden" name="cmd" value="submitreply_next" />
	</form>
	<?php
	
	PrintStandardFooter("");
}
function ShowNewMailForm($message, $msg, $error)
{
	global $g_ThisPage, $_COOKIE, $g_MessageListTableName, $g_ThreadListTableName;
	$cookie_fullname = $_COOKIE['cookie_fullname'];
	$cookie_email = $_COOKIE['cookie_email'];
	$cookie_website = $_COOKIE['cookie_website'];
	
	$reply_to = "";
	$subject = "";
	
	$query = "SELECT $g_MessageListTableName.Author,$g_ThreadListTableName.Title from $g_MessageListTableName LEFT JOIN $g_ThreadListTableName ON $g_MessageListTableName.ThreadID = $g_ThreadListTableName.ThreadID WHERE $g_MessageListTableName.MessageID = $message";
	$result = mysql_query($query)
	    or DBError("Failed while accessing thread information from the database");
	    
	if( mysql_num_rows($result) == 1 )
	{
		$line = mysql_fetch_row($result);
		$reply_to = "$line[0]";
		$subject = "$line[1]";
	}
	else
	{
		PageHeader();
		PrintError("Unable to find message $message. The topic may have been deleted.");
		PrintStandardFooter("");
		return;
	}
	
	PageHeader();
	if( strlen($error) > 0 )
		PrintError($error);
		
	?>
	<form method="post" action="<?php print "$g_ThisPage" ?>">
	  <div align="left">
	    <table border="0" cellpadding="0" cellspacing="0" width="440">
	      <tr>
	        <td valign="top" align="left">Reply To:</td>
	        <td valign="top" align="left"><strong><?php print "$reply_to" ?></strong></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Subject:</td>
	        <td valign="top" align="left"><strong><?php print "$subject" ?></strong></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left">&nbsp;</td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Message<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><textarea class="formBox" rows="10" name="msg" cols="43"><?php print "$msg" ?></textarea></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="subtle">Do not use HTML tags. Surround URLs with spaces.</span></td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left">&nbsp;</td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">Full Name<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="fullname" value="<?php print "$cookie_fullname" ?>" size="64" /></td>
	      </tr>
	      <tr>
	        <td valign="top" align="left">E-mail<span class="requiredWarning">*</span>:</td>
	        <td valign="top" align="left"><input class="formBox" type="text" name="email" value="<?php print "$cookie_email" ?>" size="64" /></td>
	      </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left"><span class="requiredWarning">* - Required for processing</span></td>
              </tr>
	      <tr>
                <td valign="top" align="left"></td>
                <td valign="top" align="left">&nbsp;</td>
              </tr>
	      <tr>
	        <td valign="top" align="left"></td>
	        <td valign="top" align="left"><input type="submit" value="Send Email" /></td>
	      </tr>
	    </table>
	  </div>
	  <input type="hidden" name="message" value="<?php print "$message" ?>" />
	  <input type="hidden" name="cmd" value="submitnewmail" />
	</form>
	<?php
	
	PrintStandardFooter("");
}

function SendMail2( $toname, $toaddress, $fromname, $fromaddress, $subject, $message )
{
	$MP = "/usr/sbin/sendmail -t"; 
	$spec_envelope = 1; 

	// Access Sendmail
	// Conditionally match envelope address
	if($spec_envelope)
	{
		$MP .= " -f $fromaddress";
	}
	$fd = popen($MP,"w"); 
	fputs($fd, "To: $toname <$toaddress>\n"); 
	fputs($fd, "From: $fromname <$fromaddress>\n");
	fputs($fd, "Subject: $subject\n"); 
	fputs($fd, "X-Mailer: PHP4\n"); 
	fputs($fd, $message); 
	pclose($fd);
}

function SendEmailToPoster( $message, $msg, $fullname, $email )
{
	global $g_Title, $g_URL, $g_ThisPage, $g_ContactEmail, $g_MessageListTableName, $g_ThreadListTableName;
	
	$query = "SELECT $g_MessageListTableName.Author,$g_MessageListTableName.Email,$g_ThreadListTableName.Title,$g_MessageListTableName.ThreadID from $g_MessageListTableName LEFT JOIN $g_ThreadListTableName ON $g_MessageListTableName.ThreadID = $g_ThreadListTableName.ThreadID WHERE $g_MessageListTableName.MessageID = $message";
	$result = mysql_query($query)
	    or DBError("Failed to find poster information from the database");
	    
	if( mysql_num_rows($result) == 1 )
	{
		$line = mysql_fetch_row($result);
		
		$msg .= "\n\n";
		$msg .= "-------------------------------------------------\n\n";
		$msg .= "This message was sent on behalf of $email, from \"$g_Title\" in reply to your posting:\n\n";
		$msg .= "$g_URL";
		$msg .= "$g_ThisPage?cmd=show&thread=$line[3]\n\n";
		$msg .= "Your email address is never revealed to the sender. Please report abuse to $g_ContactEmail.\n"; 
		
		SendMail2( $line[0], $line[1], $fullname, $email, $line[2], $msg );
		return $line[3];
	}
	
	return 0;
}

?>
<?php

$cmd = $_POST['cmd'];
if( strlen($cmd) == 0 )
	$cmd = $_GET['cmd'];

if ($cmd == "new")
{
	ShowNewTopicForm("Start a New Topic", "", "", "");
}
else if ($cmd == "submitnew")
{
	$title = $_POST['title'];
	$msg = $_POST['msg'];
	$email = $_POST['email'];
	$thread = $_POST['thread'];
	$fullname = $_POST['fullname'];
	
	if( strlen($title) == 0 || strlen($msg) == 0 )
	{
		ShowNewTopicForm("Start a New Topic", $title, $msg, "Please complete all the required fields.");
	}
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		if ($title != "" and $msg != "")
		{
			$thread = CreateNewThread($title, $fullname, $email);
			CreateNewMessage($msg, $fullname, $email, $thread);
		}
		CloseSQLConnection($link);
		redirectTo( $g_ThisPage );
	}
}
else if ($cmd == "reply")
{
	$thread = $_GET['thread'];
	
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	$title = "Reply to \"";
	$title .= PrintThreadName($thread);
	$title .= "\"";
	PageHeader();
	PrintTitle($title);
	ShowReplyForm($msg, $thread, "");
	CloseSQLConnection($link);
}
else if ($cmd == "reply_next")
{
	$thread = $_GET['thread'];
	$message = $_GET['message'];
	
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	$title = "Reply to \"";
	$title .= PrintThreadName($thread);
	$title .= "\"";


	PageHeader();
	PrintTitle($title);
	CloseSQLConnection($link);
	
	ShowReplyForm_next($msg, $thread,"",$message);
}

else if ($cmd == "submitreply_next")
{
	$msg = $_POST['msg'];
	$email = $_POST['email'];
	$thread = $_POST['thread'];
	 $message = $_POST['message']; 
	$fullname = $_POST['fullname'];
	
	if( strlen($msg) == 0 || strlen($fullname) == 0 )
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		$title = "Reply to \"";
		$title .= PrintThreadName($thread);
		$title .= "\"";
		PageHeader();
		PrintTitle($title);
		CloseSQLConnection($link);
		
		ShowReplyForm_next($msg, $thread, "Please complete all the required fields.",$message);
	}
	else
	{	
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		$posts = CreateNewMessage($msg, $fullname, $email, $thread, $message);
		CloseSQLConnection($link);
		redirectTo( $g_ThisPage . "?cmd=show&thread=$thread&posts=$posts" );
	}
}
else if ($cmd == "submitreply")
{
	$msg = $_POST['msg'];
	$email = $_POST['email'];
	$thread = $_POST['thread'];
	$fullname = $_POST['fullname'];
	
	if( strlen($msg) == 0 || strlen($fullname) == 0 )
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		$title = "Reply to \"";
		$title .= PrintThreadName($thread);
		$title .= "\"";
		PageHeader();
		PrintTitle($title);
		CloseSQLConnection($link);
		
		ShowReplyForm($msg, $thread, "Please complete all the required fields.");
	}
	else
	{	
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		$posts = CreateNewMessage($msg, $fullname, $email, $thread,'0');
		CloseSQLConnection($link);
		redirectTo( $g_ThisPage . "?cmd=show&thread=$thread&posts=$posts" );
	}
}
else if ($cmd == "show")
{
	$thread = $_GET['thread'];
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	PrintSingleThread($thread, "");
	CloseSQLConnection($link);
}
else if ($cmd == "runscripts")
{
	ShowLoginPage("", "post", "postrunscripts", "Run Database Scripts");
}
else if ($cmd == "postrunscripts")
{
	$password = $_POST['password'];
	if( $password != $g_Password )
		ShowLoginPage( "Incorrect Password!", "post", "postrunscripts", "Run Database Scripts" );
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		RunScripts();
		CloseSQLConnection($link);
		PageHeader();
		print "<p class=pageHeadline>Script run successfully.</p>\n";
		PrintStandardFooter("");
	}
}
else if ($cmd == "manage" )
{
	ShowLoginPage("", "get", "postmanage", "Manage Posts");
}
else if ($cmd == "postmanage" )
{
	$password = $_GET['password'];
	if( $password != $g_Password )
		ShowLoginPage( "Incorrect Password!", "get", "postmanage", "Manage Posts" );
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		ShowTopicManagementList($password);
		CloseSQLConnection($link);
	}
}
else if ($cmd == "manage_deleteThread" )
{
	$password = $_GET['password'];
	$thread = $_GET['thread'];
	if( $password != $g_Password )
		ShowLoginPage( "Incorrect Password!", "get", "postmanage", "Manage Posts" );
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		DeleteThisThread( $thread );		
		ShowTopicManagementList($password);
		CloseSQLConnection($link);
	}
}
else if ($cmd == "manage_showThread" )
{
	$password = $_GET['password'];
	$thread = $_GET['thread'];
	if( $password != $g_Password )
		ShowLoginPage( "Incorrect Password!", "get", "postmanage", "Manage Posts" );
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		ShowThisThread( $thread, $password );
		CloseSQLConnection($link);
	}
}
else if ($cmd == "manage_deletePost" )
{
	$password = $_GET['password'];
	$thread = $_GET['thread'];
	$message = $_GET['message'];
	if( $password != $g_Password )
		ShowLoginPage( "Incorrect Password!", "get", "postmanage", "Manage Posts" );
	else
	{
		$link = OpenSQLConnection()
			or DBError( "Unable to open a connection to the database" );
		DeleteThisPost( $thread, $message );
		ShowThisThread( $thread, $password );
		CloseSQLConnection($link);
	}
}
else if ($cmd == "newmailform" )
{
	$message = $_GET['message'];
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	ShowNewMailForm($message, "", "");
	CloseSQLConnection($link);
}
else if ($cmd == "submitnewmail" )
{
	$message = $_POST['message'];
	$msg = $_POST['msg'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	
	if( strlen($msg) == 0 || strlen($fullname) == 0 || strlen($email) == 0 )
		ShowNewMailForm($message, $msg, "Please complete all required fields!");
	else
	{
		$thread = SendEmailToPoster($message, $msg, $fullname, $email );
		if( $thread > 0 )
		{
			$posts = GetPostsCount($thread);
			redirectTo( $g_ThisPage . "?cmd=show&thread=$thread&posts=$posts" );
		}
		else
		{
			PageHeader();
			PrintError( "An error has occurred. Sorry about that." );
			PrintStandardFooter("");
		}
	}
	
	CloseSQLConnection($link);
}
else if( $cmd == "offset" )
{
	$page = $_GET['page'];
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	PrintThreadList( $page );
	CloseSQLConnection($link);
}
else
{
	$link = OpenSQLConnection()
		or DBError( "Unable to open a connection to the database" );
	PrintThreadList();
	CloseSQLConnection($link);
}



?>

