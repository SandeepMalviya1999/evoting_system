<?php
require_once("nav.php");

$user_id = $_SESSION['user_id'];

$data = fetchData("system_users", "WHERE user_id=$user_id");
foreach ($data as $value) :
	$categoryID = $value["election_category_id"];
endforeach;

$data = fetchData("election_category", "WHERE id=$categoryID");
foreach ($data as $value) :
	$get_vote_start_dt = $value["vote_start_time"];
	$get_vote_end_dt = $value["vote_end_time"];
endforeach;

$voterReceived = getRowCount("system_users", "WHERE role='voter' AND voted='Yes'");
$voterPending = getRowCount("system_users", "WHERE role='voter' AND voted='No' ");

$candidate_name_array = array();
$candidate_vote_array = array();
$count = 0;

$data = fetchData("candidate", "WHERE category_id=$categoryID");
foreach ($data as $value) :
	$candidate_id = $value["id"];
	$candidate_name = $value["full_name"];

	$data1 = fetchData("vote_details", "WHERE candidate_id=$candidate_id");
	foreach ($data1 as $value1) :
		$candidate_vote = $value1["vote"];
		array_insert($candidate_name_array, $count, $candidate_name);
		array_insert($candidate_vote_array, $count, $candidate_vote);
		$count++;
	endforeach;
endforeach;

for ($i = 0; $i < count($candidate_vote_array); $i++) {
	for ($j = $i + 1; $j < count($candidate_vote_array); $j++) {
		if ($candidate_vote_array[$i] > $candidate_vote_array[$j]) {
			$temp = $candidate_vote_array[$i];
			$candidate_vote_array[$i] = $candidate_vote_array[$j];
			$candidate_vote_array[$j] = $temp;

			$temp = $candidate_name_array[$i];
			$candidate_name_array[$i] = $candidate_name_array[$j];
			$candidate_name_array[$j] = $temp;
		}
	}
}



if (isset($_POST["update_vote_time"])) {
	$start_datetime = trim($_POST["start_timestamp"]);
	$end_datetime = trim($_POST["end_timestamp"]);
	$sql = "UPDATE election_category SET vote_start_time = '$start_datetime', vote_end_time = '$end_datetime' WHERE id = $categoryID";
	if (executeInsertQuery($sql)) {
		$_SESSION["messages"][] = "Voting Time Updated";
		echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
		exit(0);
	} else {
		$_SESSION["errors"][] = "Voting Failed to Update";
		echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
		exit(0);
	}
}

function array_insert(&$array, $position, $insert)
{
	if (is_int($position)) {
		array_splice($array, $position, 0, $insert);
	} else {
		$pos   = array_search($position, array_keys($array));
		$array = array_merge(
			array_slice($array, 0, $pos),
			$insert,
			array_slice($array, $pos)
		);
	}
}
?>


<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-7">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Vote Graph</div>
					</div>
					<div id="barChart"></div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Edit Voting Start and End Time</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-4 highlight" for="start_timestamp">Start Time</label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime col-md-10" data-date="2020-09-18T11:00:00Z" data-date-format="yyyy-mm-dd HH:mm:ss" data-link-field="start_timestamp">
										<input class="form-control" size="16" type="text" id="start_timestamp" name="start_timestamp" value="<?php echo $get_vote_start_dt; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-4 highlight" for="end_timestamp">End Time</label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime col-md-10" data-date="2020-09-18T11:00:00Z" data-date-format="yyyy-mm-dd HH:mm:ss" data-link-field="end_timestamp">
										<input class="form-control" size="16" type="text" id="end_timestamp" name="end_timestamp" value="<?php echo $get_vote_end_dt; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-10">
									<button type="submit" class="btn btn-primary btn-sm" id="update_vote_time" name="update_vote_time">Update Voting Time</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>

				<div class="panel panel-default">
				<div class="panel-heading">
						<div class="title">Winning Candidate</div>
					</div>
					<div class="panel-body">
						<h2 class="text-center">
							<?php if($count > 0) 
							{
								echo $candidate_name_array[$count-1];
							} else {
								echo "No Candidate. ";
								echo '<div class="col-md-12 text-center"> <br/>
								<input type="button" id="singlebutton" name="singlebutton" class="btn btn-primary"  onclick="window.location=\'create_candidate_account.php\';" value="Create Candidate">
						
							</div>';
							}?>
						</h2><br/>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Votes (Recevied vs Pending)</div>
					</div>

					<div id="piechart"></div>

				</div>

				
			</div>

		</div>
	</div>
</div>

<script type="text/javascript" src="assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="assets/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<script type="text/javascript">
	$('.form_datetime').datetimepicker({
		//language:  'fr',
		weekStart: 1,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
		showMeridian: 1
	});
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	var candidate_name_array = <?php echo json_encode($candidate_name_array); ?>;
	var candidate_vote_array = <?php echo json_encode($candidate_vote_array); ?>;


	google.charts.load('current', {
		'packages': ['bar']
	});
	google.charts.setOnLoadCallback(drawStuff);

	function drawStuff() {
		var data = [];

		var Header = ['Candidate', 'Votes'];



		data.push(Header);

		for (var i = 0; i < candidate_name_array.length; i++) {

			var temp = [];
			temp.push(candidate_name_array[i]);
			temp.push(candidate_vote_array[i]);
			data.push(temp);
		}

		var chartdata = new google.visualization.arrayToDataTable(data);


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
		chart.draw(chartdata, google.charts.Bar.convertOptions(options));
	};
</script>

<script type="text/javascript">
	// Load google charts
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);


	// Draw the chart and set the chart values
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			['Vote Received', parseInt("<?php echo "$voterReceived" ?>")],
			['Vote Pending', parseInt("<?php echo "$voterPending" ?>")],
		]);

		var chartwidth = $('#chartparent').width();


		// Optional; add a title and set the width and height of the chart
		var options = {
			pieHole: 0.5,
			pieSliceTextStyle: {
				color: 'black',
			},
			legend: 'none',
			width: chartwidth,
			height: $(window).height() * 0.5
		};

		// Display the chart inside the <div> element with id="piechart"
		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	}
</script>




<?php
require_once("../includes/footer.php");
?>