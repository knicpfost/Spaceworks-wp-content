<?php

function cnpcf_formshelp() {
?>
<div class="logo"><a href="https://clickandpledge.com" target="_blank"><img src="<?php print plugins_url(); ?>/clickandpledge_connect/images/logo-cp.png"></a></div>
<div class="instructions">
	<h2>Welcome to Click &amp; Pledge Connect</h2>
	<p>For quick start, follow these instructions</p>
	<ol>
		<li>Go to <a href="admin.php?page=cnp_formssettings">Settings</a> page and add Click &amp; Pledge Account Number, Account GUID and Nickname. Find Account GUID in your Click &amp; Pledge Connect. Find out <a href="http://help.clickandpledge.com/customer/portal/articles/2228929-how-to-locate-account-id-api-account-guid" target="_blank">how</a>.</li>
		<li>Once the Account information is added, additional menu items will appear and you may add <strong>"<a href="admin.php?page=cnp_formsdetails">Form Groups</a>"</strong>.</li>
		<li>After saving the Form Group details, a new table will appear on the same page where you may select one or more forms from different campaigns. <br><small><strong>Note:</strong> All campaigns and forms are retrieved from <a href="https://connect.clickandpledge.com/" target="_blank">Click &amp; Pledge Connect</a>.</small></li>
	</ol>
	<p>
		For step by step guide follow our manual <a href="https://manual.clickandpledge.com/WordPress-Connect-Plugin.html">here</a>.
	</p>
</div>
<div class="news" style="border-top:1px solid #d8d8d8;">
	<h2>Latest news from Click &amp; Pledge</h2>
	<?php
// this is the url of the rss feed that you want to display
$feed = 'https://forums.clickandpledge.com/external?type=rss2&nodeid=20'; //replace this with the RSS's URL
$xml = simplexml_load_file($feed);
//if the feed exists, then continue...
if ($xml!=''){
	?>
	<ul>
	<?php
	$i = 0;
foreach ($xml->channel->item as $item){
$i++;
// create variables from the title and description (can also be used for images and  links)
$title = $item->title;
$description = $item->description;
$date = $item->pubDate;
$user = $item->children('dc', true)->creator;
$link = $item->link;



// displays the title and description on your website, formatted any way you want

echo '<li>
<h4 style="margin:5px 0;"><a href="'.$link.'" target="_blank">'.$title.'</a></h4> - On <small>'.$date.'</small><br />'.$description.'<a href="'.$link.'" target="_blank">Read More</a></li>';
if ($i === 6) break;
}}
?>
</ul>
</div>
<?php

}

?>
