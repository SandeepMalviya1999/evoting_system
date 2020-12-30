<?php
require_once("nav.php");
$candidate_refID = $_SESSION['candidate_refID'];

$data = fetchData("candidate", "WHERE id=$candidate_refID");
foreach ($data as $value) :
	$get_name = $value["full_name"];
	$get_photo = $value["photo"];
	$get_symbol = $value["symbol"];
endforeach;


if (isset($_POST["submit"])) {
	$candidate_name = trim($_POST["candidate_name"]);

	$photoFileName = $_FILES["uploadPhoto"]["name"];
	$photoTempName = $_FILES["uploadPhoto"]["tmp_name"];
	$photoFolder = "../upload/photo/" . $photoFileName;

	$symbolFileName = $_FILES["uploadSymbol"]["name"];
	$symbolTempName = $_FILES["uploadSymbol"]["tmp_name"];
	$symbolFolder = "../upload/symbol/" . $symbolFileName;

	$sql = "UPDATE candidate SET full_name = '$candidate_name', photo = '$photoFileName', symbol = '$symbolFileName' WHERE id = $candidate_refID";

	if (executeInsertQuery($sql)) {

		if (move_uploaded_file($photoTempName, $photoFolder) && move_uploaded_file($symbolTempName, $symbolFolder)) {
			$_SESSION["messages"][] = "Data Inserted Successfully";
			echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
			exit(0);
		} else {
			$_SESSION["errors"][] = "Image Move Failed";
		}
	} else {
		$_SESSION["errors"][] = "Data Insertion Failed";
		echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
		exit(0);
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
						<div class="title">Update Candidate (<?php echo $get_name; ?>) Details</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							
						<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="reference_id">Reference ID</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="<?php echo $candidate_refID; ?>" required disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="candidate_name">Candidate Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="candidate_name" name="candidate_name" placeholder="Enter candidate name" value="<?php echo $get_name; ?>" required>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="uploadPhoto">Candidate Photo</label>
								<div class="col-sm-6">
									Select image to upload: <input type="file" name="uploadPhoto" id="uploadPhoto" required><br />
								</div>
								<?php
								echo '<td><img src="../upload/photo/'.$get_photo.'" alt="Photo" style="width:150px;height:150px;vertical-align: middle;max-width: 200px;max-height: 200px;display: -moz-inline-box;display: inline-block;"> </td>';
								?>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="uploadSymbol">Candidate Symbol</label>
								<div class="col-sm-6">
									Select image to upload: <input type="file" name="uploadSymbol" id="uploadSymbol" required><br />
								</div>
								<?php
								echo '<td><img src="../upload/symbol/'.$get_symbol.'" alt="Symbol" style="width:150px;height:150px;vertical-align: middle;max-width: 200px;max-height: 200px;display: -moz-inline-box;display: inline-block;"> </td>';
								?>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-primary btn-sm" id="submit" name="submit" >Update</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once("../includes/footer.php");
?>