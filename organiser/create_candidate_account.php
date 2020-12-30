<?php

require_once("nav.php");

$user_id = $_SESSION['user_id'];

$data = fetchData("system_users", "WHERE user_id=$user_id");
foreach ($data as $value) :
	$category_id = $value["election_category_id"];
endforeach;



if (isset($_POST["submit"])) {
	$candidate_name = trim($_POST["candidate_name"]);

	$photoFileName = $_FILES["uploadPhoto"]["name"];
	$photoTempName = $_FILES["uploadPhoto"]["tmp_name"];
	$photoFolder = "../upload/photo/" . $photoFileName;

	$symbolFileName = $_FILES["uploadSymbol"]["name"];
	$symbolTempName = $_FILES["uploadSymbol"]["tmp_name"];
	$symbolFolder = "../upload/symbol/" . $symbolFileName;


	$sql = "INSERT INTO candidate(full_name, photo, symbol, category_id) VALUES('$candidate_name','$photoFileName','$symbolFileName','$category_id')";

	if (executeInsertQuery($sql)) {

		if (move_uploaded_file($photoTempName, $photoFolder) && move_uploaded_file($symbolTempName, $symbolFolder)) {

			$data = fetchData("candidate", "WHERE full_name='$candidate_name'");
			foreach ($data as $value) :
				$candidate_id = $value["id"];
			endforeach;


			$sql = "INSERT INTO vote_details(category_id, candidate_id, vote) VALUES($category_id, $candidate_id, 0)";
			if (executeInsertQuery($sql)) {
				$_SESSION["messages"][] = "Data Inserted Successfully";
				echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
				exit(0);
			} else {
				$_SESSION["errors"][] = "Data Insertion Failed";
				echo "<script>window.location='" . $_SERVER["PHP_SELF"] . "';</script>";
				exit(0);
			}
		} else {
			$_SESSION["errors"][] = "Image Move Failed";
		}
	} else {
		$_SESSION["errors"][] = "Data Updation Failed";
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
						<div class="title">Add Candidate</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="candidate_name">Candidate Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="candidate_name" name="candidate_name" placeholder="Enter candidate name" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="uploadPhoto">Candidate Photo</label>
								<div class="col-sm-8">
									Select photo to upload:
									<input type="file" name="uploadPhoto" id="uploadPhoto" value=""><br />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3 highlight" for="uploadSymbol">Candidate Symbol</label>
								<div class="col-sm-8">
									Select symbol to upload:
									<input type="file" name="uploadSymbol" id="uploadSymbol" value=""><br />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-primary btn-sm" id="submit" name="submit">Create</button>
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