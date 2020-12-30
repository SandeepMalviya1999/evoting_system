<?php
require_once("nav.php");

$user_id = $_SESSION['user_id'];

$data = fetchData("system_users", "WHERE user_id=$user_id");
foreach ($data as $value) :
	$category_id = $value["election_category_id"];
endforeach;

$data = fetchData("election_category", "WHERE id=$category_id");
foreach ($data as $value) :
	$vote_start_time = $value["vote_start_time"];
	$vote_end_time = $value["vote_end_time"];
	$category_name = $value["name"];
endforeach;

$candidate_name_array = array();
$candidate_vote_array = array();
$count = 0;

$data = fetchData("candidate", "WHERE category_id=$category_id");
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

if (isset($_POST["submit"])) {

	$votes_list = $_POST['votes'];
	foreach ($votes_list as $candidate_id) {
		$sql = "UPDATE vote_details SET vote = vote+1 WHERE category_id = $category_id AND candidate_id = $candidate_id";
		if (executeInsertQuery($sql)) {
			$sql = "UPDATE system_users SET voted = 'Yes' WHERE user_id = $user_id";
			if (executeInsertQuery($sql)) {
				$_SESSION["messages"][] = "Data Updation Successful";
			} else {
				$_SESSION["errors"][] = "Data Updation Failed";
			}
		} else {
			$_SESSION["errors"][] = "Data Insertion Failed";
			echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
			exit(0);
		}
	}
}

?>


<div class="page-section">
	<div class="container">



		<?php
		date_default_timezone_set('Asia/Kolkata');

		$start_time  = strtotime($vote_start_time);
		$end_time  = strtotime($vote_end_time);
		$now = time();
		$diff_start_time = $start_time - $now;
		$diff_end_time = $end_time - $now;


		$data = fetchData("system_users", "WHERE user_id=$user_id");
		foreach ($data as $value) :
			$voted = $value["voted"];
		endforeach;



		if ($voted == "Yes") {
			if ($diff_end_time < 0) {
				echo '
				<div class="col-sm-12">
						<div class="alert alert-info">
							<strong>WINNING PARTY!</strong> '. $candidate_name_array[$count-1].'
							</div>
					</div>
				<div class="col-sm-12">
						<div class="panel panel-default">
						<div class="panel-heading">
							<div class="title">Vote Graph</div>
						</div>
						<div id="barChart"></div>
					</div>
	
				</div>';
			} else {
				echo '<div class="row">
						<div class="alert alert-success">
							<strong>Submitted!</strong> Your Vote is submitted, you cant vote now. Result will be declare after the voting time is expired.
							</div>
					</div>';
			}
		} else {
			if ($diff_start_time > 0) {
				echo '<div class="row">
					<div class="col-sm-12">
						<div class="counter">
							<h3>Voting will start in :</h3>
							<div class="countdown" id="vote_start_countdown"></div>
						</div>
					</div>
				</div>';
			} else {
				if ($diff_end_time > 0) {
					echo '<div class="row">
						<div class="col-sm-12">
							<div class="counter">
								<h3>Voting will end in :</h3>
								<div class="countdown" id="vote_end_countdown"></div>
							</div>
						</div>
					</div>';
					require_once("give_vote.php");
				} else {
					echo '<div class="row">
					<div class="alert alert-danger">
						<strong>Time Expired!</strong> Voting Time Period is Expired.
	  					</div>
					</div>';
				}
			}
		}
		?>
	</div>
</div>

<script type="text/javascript">
	// set the date we're counting down to
	var start_dt = new Date("<?php echo $vote_start_time ?>");
	var end_dt = new Date("<?php echo $vote_end_time ?>");

	var start_target = start_dt.getTime();
	var end_target = end_dt.getTime();

	// variables for time units
	var days, hours, minutes, seconds;

	// get tag element
	var vote_start_countdown = document.getElementById('vote_start_countdown');
	var vote_end_countdown = document.getElementById('vote_end_countdown');

	// update the tag with id "countdown" every 1 second
	setInterval(function() {

		// find the amount of "seconds" between now and target
		var current_date = new Date().getTime();

		var seconds_left_start = (current_date - start_target) / 1000;

		// do some time calculations
		days_start = parseInt(seconds_left_start / 86400);
		seconds_left_start = seconds_left_start % 86400;

		hours_start = parseInt(seconds_left_start / 3600);
		seconds_left_start = seconds_left_start % 3600;

		minutes_start = parseInt(seconds_left_start / 60);
		seconds_left_start = parseInt(seconds_left_start % 60);

		// format countdown string + set tag value
		vote_start_countdown.innerHTML = '<span class="days">' + days_start + ' <b>Days</b></span> <span class="hours">' + hours_start + ' <b>Hours</b></span> <span class="minutes">' +
			minutes_start + ' <b>Minutes</b></span> <span class="seconds">' + seconds_left_start + ' <b>Seconds</b></span>';

	}, 1000);

	// update the tag with id "countdown" every 1 second
	setInterval(function() {

		// find the amount of "seconds" between now and target
		var current_date = new Date().getTime();

		var seconds_end_start = (current_date - end_target) / 1000;

		// do some time calculations
		days_end = parseInt(seconds_end_start / 86400);
		seconds_end_start = seconds_end_start % 86400;

		hours_end = parseInt(seconds_end_start / 3600);
		seconds_end_start = seconds_end_start % 3600;

		minutes_end = parseInt(seconds_end_start / 60);
		seconds_end_start = parseInt(seconds_end_start % 60);

		// format countdown string + set tag value
		vote_end_countdown.innerHTML = '<span class="days">' + days_end + ' <b>Days</b></span> <span class="hours">' + hours_end + ' <b>Hours</b></span> <span class="minutes">' +
			minutes_end + ' <b>Minutes</b></span> <span class="seconds">' + seconds_end_start + ' <b>Seconds</b></span>';

	}, 1000);
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

<style>
	.counter {
		background: #2C2C2C;
		-moz-box-shadow: inset 0 0 5px #000000;
		-webkit-box-shadow: inset 0 0 5px #000000;
		box-shadow: inset 0 0 5px #000000;
		min-height: 150px;
		text-align: center;
	}

	.counter h3 {
		color: #E5E5E5;
		font-size: 14px;
		font-style: normal;
		font-variant: normal;
		font-weight: lighter;
		letter-spacing: 1px;
		padding-top: 20px;
		margin-bottom: 30px;
	}

	.countdown {
		color: #FFFFFF;
	}

	.countdown span {
		color: #E5E5E5;
		font-size: 26px;
		font-weight: normal;
		margin-left: 20px;
		margin-right: 20px;
		text-align: center;
	}

	.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}

	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked+.slider {
		background-color: #2196F3;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked+.slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>

<?php
require_once("../includes/footer.php");
?>