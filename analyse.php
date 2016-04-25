<? include('includes/config.php');
include('includes/header.php');
echo "<a href=\"http://".WEBSITE_URL."\" class=\"btn btn-danger\" style=\"margin-top:20px;margin-right:5px; position: fixed;  top: 0;right: 0; -webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -ms-transform: rotate(30deg); -o-transform: rotate(30deg); \">Website</a>";
$url = mysqli_fetch_assoc(execute_query("SELECT * FROM `url` WHERE `id` = ".mysql_prep(toNum($_GET["id"]))." LIMIT 1"));?>
<div class="container">
<center><h2>Welcome to <?echo APP_NAME?></h2></center>
<center><h4>Analyzing  <?echo WEBSITE_URL."/".$_GET["id"]." (".$url["url"].")";?></h4></center>
<center><p>Total Clicks: <?echo mysqli_fetch_assoc(execute_query("SELECT count(*) AS clicks FROM `url_click` WHERE `url_id` = ".$url["id"]))["clicks"]?></p>
<div class="row">
	<div class="col-sm-4">
		<h4>Date</h4>
		<table class="table table-responsive">
			<tr>
				<td>Date</td>
				<td>Clicks</td>
				<?
				$dates = execute_query("SELECT date(`click_time`) as date_v,count(*) AS clicks FROM `url_click` WHERE `url_id` = ".$url["id"]." GROUP BY 1 ORDER BY 1 DESC");
				while($date = mysqli_fetch_assoc($dates)){
					echo "<tr><td>".$date["date_v"]."</td><td>".$date["clicks"]."</td></tr>";
				}
				?>
			</tr>
		</table>
	</div>
	<div class="col-sm-4">
		<h4>Country</h4>
		<table class="table table-responsive">
			<tr>
				<td>Country</td>
				<td>Clicks</td>
				<?
				$countries = execute_query("SELECT `country`,count(*) AS clicks FROM `url_click` WHERE `url_id` = ".$url["id"]." GROUP BY 1 ORDER BY 2 DESC");
				while($country = mysqli_fetch_assoc($countries)){
					echo "<tr><td>".$country["country"]."</td><td>".$country["clicks"]."</td></tr>";
				}
				?>
			</tr>
		</table>
	</div>
	<div class="col-sm-4">
		<h4>Browser</h4>
		<table class="table table-responsive">
			<tr>
				<td>Browser</td>
				<td>Clicks</td>
				<?
				$user_agents = execute_query("SELECT `useragent`,count(*) AS clicks FROM `url_click` WHERE `url_id` = ".$url["id"]." GROUP BY 1 ORDER BY 2 DESC");
				while($user_agent = mysqli_fetch_assoc($user_agents)){
					echo "<tr><td>".$user_agent["useragent"]."</td><td>".$user_agent["clicks"]."</td></tr>";
				}
				?>
			</tr>
		</table>
	</div>
</div>
</div>
<?include('includes/footer.php');?>