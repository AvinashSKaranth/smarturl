<?include('includes/config.php');?>
<?include('includes/header.php');?>
<div class="container">
	<? echo "<a href=\"http://".WEBSITE_URL."\" class=\"btn btn-danger\" style=\"margin-top:20px;margin-right:5px; position: fixed;  top: 0;right: 0; -webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -ms-transform: rotate(30deg); -o-transform: rotate(30deg); \">Website</a>";?>
	<center><h2>Welcome to <?echo APP_NAME?> API</h2></center>
	<div class="row">
	<h2>Shorten using API</h2>
	<pre>
	GET
	http://<?echo WEBSITE_URL;?>/index.php?method={web/api}&url={url}
	
	api returns text output with shortened url
	web return html rendered output
	
	example
	http://<?echo WEBSITE_URL;?>/index.php?method=api&url=http://google.com
	*url needs to UrlEncoded
	</pre>
	<br>
	<h2>Analysis of URL</h2>
	<pre>
	http://<?echo WEBSITE_URL;?>/analyse.php?id={id}
	
	example
	http://<?echo WEBSITE_URL;?>/abc
	Then id = abc
	</pre>
	</div>
</div>
<?	include('includes/footer.php');?>