<?php
function my_site_root()
{	
	//this work only in your system if the project will not run for intranet
	//un comment this if not intranet but comment if intranet
	
	$path ="http://localhost/FPI_REGISTRATION/";
	
	//goes every where both in your system or not in your system
	//if the program runs for intranet uncomment this else comment this
	//always change sherif-pc to the name of pc that hold the server
	//$path ="http://sherif-pc/FPI_REGISTRATION/";
	return $path;
	
	///echo "<a href=".$path2.">Click with computer Name</a><br /><br /><br />";
	//echo "<a href=".$path.">Click without computer Name</a>";
}
//$rat = my_site_root();
//echo $rat;
?>