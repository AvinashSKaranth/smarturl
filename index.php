<? include('includes/config.php');
require_once 'vendor/autoload.php';
use MaxMind\Db\Reader;
if(isset($_GET["id"])&&$_GET["id"]!=""){
	$url = mysqli_fetch_assoc(execute_query("SELECT * FROM `url` WHERE `id` = ".mysql_prep(toNum($_GET["id"]))." LIMIT 1"));
	//print_r($url);
	if($url!=null){
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$databaseFile = 'vendor/maxmind-db/reader/GeoLite2-City.mmdb';
		$reader = new Reader($databaseFile);
		$ip = $reader->get($ipAddress);
		$ip_result = array();
		$ip_details["country"] =  $ip["registered_country"]["names"]["en"];
		$ip_details["region"] =  $ip["subdivisions"][0]["names"]["en"];
		$ip_details["city"] =  $ip["city"]["names"]["en"];
		$ip_details["latitude"] =  $ip["location"]["latitude"];
		$ip_details["longitude"] =  $ip["location"]["longitude"];
		$reader->close();
		//$ip_details = json_decode(file_get_contents('http://geoip.ga/?ip='.$_SERVER['REMOTE_ADDR']),true);;
		execute_insert_query("INSERT INTO `url_click`(`url_id`, `country`, `state`, `city`, `ip`, `referer`, `latitude`, `longitude`, `useragent`, `click_time`) VALUES ('".$url["id"]."','".$ip_details["country"]."','".$ip_details["region"]."','".$ip_details["city"]."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER["HTTP_REFERER"]."','".$ip_details["latitude"]."','".$ip_details["longitude"]."','".$_SERVER["HTTP_USER_AGENT"]."',NOW())");
		redirect_to($url["url"]);
	}else{
		include('includes/header.php');
		echo "<div style=\"padding-top:30vh;\"></div>";
		echo "<center><h2>Welcome to ".APP_NAME."</h2></center>";
		echo "<center><p>Unable to find your url</p></center>";
		include('includes/footer.php');
	}
}else if(isset($_GET["url"])&&$_GET["url"]!=""){
	if(filter_var($_GET["url"], FILTER_VALIDATE_URL) === FALSE){
		if(isset($_GET["method"])&&$_GET["method"]==="api"){
			echo "Invalid URL";
		}else{
			include('includes/header.php');
			echo "<a href=\"http://".WEBSITE_URL."/doc.php\" target=\"_blank\" class=\"btn btn-danger\" style=\"margin-top:20px;margin-right:5px; position: fixed;  top: 0;right: 0; -webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -ms-transform: rotate(30deg); -o-transform: rotate(30deg); \">API Docs</a>";
			echo "<div style=\"padding-top:30vh;\"></div>";
			echo "<center><h2>Welcome to ".APP_NAME."</h2></center>";
			echo "<center><h4>".$_GET["url"]." is a Invalid URL</h4></center>";
			echo "<center><form action=\"index.php\" method=\"get\" style=\"width:320px; max-width:90%\"><input class=\"form-control\" type=\"text\" name=\"url\" placeholder=\"Enter the url here\"/><br><input class=\"btn btn-success\" type=\"submit\" name=\"submit\" value=\"shortify\"/></form></center>";
			include('includes/footer.php');
		}
	}else{
		$id = execute_insert_query("INSERT INTO `url`(`url`, `created_time`) VALUES ('".mysql_prep($_GET["url"])."',".get_sql_india_time().")");
		$surl = "http://".WEBSITE_URL."/".toChars($id);
		$durl = WEBSITE_URL."/".toChars($id);
		$saurl = "http://".WEBSITE_URL."/analyse.php?id=".toChars($id);
		$daurl = WEBSITE_URL."/analyse.php?id=".toChars($id);
		if(isset($_GET["method"])&&$_GET["method"]==="api"){
			echo $surl;
		}else{
			include('includes/header.php');
			echo "<a href=\"http://".WEBSITE_URL."/doc.php\" target=\"_blank\" class=\"btn btn-danger\" style=\"margin-top:20px;margin-right:5px; position: fixed;  top: 0;right: 0; -webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -ms-transform: rotate(30deg); -o-transform: rotate(30deg); \">API Docs</a>";
			echo "<div style=\"padding-top:30vh;\"></div>";
			echo "<center><h2>Welcome to ".APP_NAME."</h2></center>";
			echo "<center><h4><a href=\"".$_GET["url"]."\">".$_GET["url"]."</a></h4><p>is shortened into </p><h1><a href=\"".$surl."\">".$durl."</a></h1><p>Url Analytics here:</p><h4><a href=\"".$saurl."\">".$daurl."</a></h4></center>";
			echo "<br><br><center><p>try again</p></center>";
			echo "<center><form action=\"index.php\" method=\"get\" style=\"width:320px; max-width:90%\"><input class=\"form-control\" type=\"text\" name=\"url\" placeholder=\"Enter a new url here\"/><br><input class=\"btn btn-success\" type=\"submit\" name=\"submit\" value=\"shortify\"/></form></center>";
			include('includes/footer.php');
		}
	}
}else{
	include('includes/header.php');
	echo "<a href=\"http://".WEBSITE_URL."/doc.php\" target=\"_blank\" class=\"btn btn-danger\" style=\"margin-top:20px;margin-right:5px; position: fixed;  top: 0;right: 0; -webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -ms-transform: rotate(30deg); -o-transform: rotate(30deg); \">API Docs</a>";
	echo "<div style=\"padding-top:30vh;\"></div>";
	echo "<center><h2>Welcome to ".APP_NAME."</h2></center>";
	echo "<center><form action=\"index.php\" method=\"get\" style=\"width:320px; max-width:90%\"><input class=\"form-control\" type=\"text\" name=\"url\" placeholder=\"Enter the url here\"/><br><input class=\"btn btn-success\" type=\"submit\" name=\"submit\" value=\"shortify\"/></form></center>";
	include('includes/footer.php');
}
//http://smarturl.gq/index.php?url=http://google.com
//http://smarturl.gq/index.php?method=api&url=http://google.com
