<?php

require_once("nav.php");

$categoryCount = getRowCount("election_category", "");
$organisationCount = getRowCount("system_users", "WHERE role='organiser'");
$voterCount = getRowCount("system_users", "WHERE role='voter'");
$pending_request = getRowCount("request_to_register", "WHERE ac_status='Pending'");

?>


<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Request for Election System</div>
					</div>
					<div class="panel-body">
						<h2 class="text-center"><?php echo $pending_request?></h2><br/>
						<div class="col-md-12 text-center"> 
							<input type="button" id="singlebutton" name="singlebutton" class="btn btn-primary"  onclick="window.location='request_to_register.php';" value="Go to Pending Request Page">
					
						</div>
					</div>
					
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Total Users Base</div>
					</div>
					<div id="barChart"></div>
				</div>

			
			</div>

			<div class="col-sm-7">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Category Details in Short</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
								<table class="table ">
									<thead>
										<tr>
											<th width="35%">Category Name</th>
											<th width="35%">Expire In</th>
											<th width="20%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($data = fetchData("election_category", "")) :
											date_default_timezone_set('Asia/Kolkata');
											$now = time();
											foreach ($data as $value) : ?>
												<tr>
													<?php
													$categoryID = $value["id"];
													$expire_timestamp = strtotime($value['expire_timestamp']);
													$time_difference = $expire_timestamp - $now;
													$days_left = floor($time_difference / ( 60 * 60 * 24));

													echo '<td>' . $value['name'] . '</td>';

													if($days_left > 0) {
														echo '<td><strong >'.$days_left.' day left</strong></td>';
													}else {
														echo '<td><strong>Expired!</strong></td>';
													}
								
													echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $categoryID . '">Edit</button>&emsp;';
													echo '<button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete' . $categoryID . '">Delete</button>';

													if (isset($_POST['edit' . $categoryID])) {
														unset($_SESSION['category_refID']);
														$_SESSION['category_refID'] = $categoryID;
														exit(header("Location:update_election_category.php"));
													}

													if (isset($_POST['delete' . $categoryID])) {

														if (executeDeleteQuery("candidate","WHERE category_id=$categoryID") && executeDeleteQuery("election_category","WHERE id=$categoryID") && executeDeleteQuery("system_users","WHERE election_category_id=$categoryID") && executeDeleteQuery("vote_details","WHERE category_id=$category_id")) {
															$_SESSION["messages"][] = "Data Deleted Successfully";
															echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
															exit(0);
														} else {
															$_SESSION["errors"][] = "Data Deletion Failed" + $_SESSION["errors"];
															echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
															exit(0);
														}
													}
													?>
												</tr>
										<?php endforeach;
										endif; ?>

									</tbody>
								</table>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['bar']
	});
	google.charts.setOnLoadCallback(drawStuff);

	function drawStuff() {
		var data = new google.visualization.arrayToDataTable([
			['Result', 'Count'],
			["Category", parseInt("<?php echo "$categoryCount" ?>")],
			["Organiser", parseInt("<?php echo "$organisationCount" ?>")],
			["Voter", parseInt("<?php echo "$voterCount" ?>")],
		]);

		var chartwidth = $('#chartparent').width() * 0.5;

		var options = {
			width: chartwidth,

			legend: {
				position: 'none'
			},
			bar: {
				groupWidth: "50%"
			}
		};

		var chart = new google.charts.Bar(document.getElementById('barChart'));
		// Convert the Classic options to Material options.
		chart.draw(data, google.charts.Bar.convertOptions(options));
	};
</script>

<?php
require_once("../includes/footer.php");
?>