<?php
require_once("nav.php");

$category_refID = $_SESSION['category_refID'];

$data = fetchData("election_category", "WHERE id=$category_refID");
foreach ($data as $value) :
	$getName = $value["name"];
	$getExpireTimestamp = $value["expire_timestamp"];
endforeach;


if (isset($_POST["submit"])) {
	$name = trim($_POST["category_name"]);
	$expire_timestamp = trim($_POST["expire_timestamp"]);

	$sql = "UPDATE election_category SET name = '$name', expire_timestamp = '$expire_timestamp' WHERE id = $category_refID";
	if (executeInsertQuery($sql)) {
		$_SESSION["messages"][] = "Data Updation Successful";
		echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
		exit(0);
	} else {
		$_SESSION["errors"][] = "Data Updation Failed";
	}
}
?>

<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Edit Category (<?php echo $getName; ?>) Details</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="reference_id">Reference ID</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="<?php echo $category_refID; ?>" required disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="category_name">Category Name</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" value="<?php echo $getName; ?>" required>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-primary btn-sm" id="submit" name="submit">Update</button>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="expire_timestamp">Expire Time</label>
								<div class="col-sm-7">
									<div class="input-group date form_datetime col-md-7" data-date="2020-09-18T11:00:00Z" data-date-format="yyyy-mm-dd HH:mm:ss" data-link-field="expire_timestamp">
										<input class="form-control" size="16" type="text" id="expire_timestamp" name="expire_timestamp" value="<?php echo $getExpireTimestamp; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
								</div>
							</div>
						</form>
					</div>
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

<?php
	require_once("../includes/footer.php");
?>