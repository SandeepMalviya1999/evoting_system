<?php
require_once("nav.php");

$user_id = $_SESSION['user_id'];

$data = fetchData("system_users", "WHERE user_id=$user_id");
foreach ($data as $value) :
	$category_id = $value["election_category_id"];
endforeach;

?>


<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Edit Candidate Details</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<table class="table ">
									<thead>
										<tr>
											<th width="30%">Name</th>
											<th width="15%">Photo</th>
											<th width="15%">Symbol</th>
											<th width="15%">Timestamp</th>
											<th width="20%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($data = fetchData("candidate", "WHERE category_id='$category_id'")) :
											foreach ($data as $value) : ?>
												<tr>
													<?php
													$candidate_id = $value['id'];
													echo '<td>' . $value['full_name'] . '</td>';
													echo '<td><img src="../upload/photo/' . $value['photo'] . '" alt="Photo" style="width:100px;height:100px;vertical-align: middle;max-width: 100px;max-height: 100px;display: -moz-inline-box;display: inline-block;"> </td>';
													echo '<td><img src="../upload/symbol/' . $value['symbol'] . '" alt="Photo" style="width:100px;height:100px;vertical-align: middle;max-width: 100px;max-height: 100px;display: -moz-inline-box;display: inline-block;"> </td>';
													echo '<td>' . $value['timestamp'] . '</td>';
													echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $candidate_id . '">Edit</button>&emsp;';
													echo '<button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete' . $candidate_id . '">Delete</button>';

													if (isset($_POST['edit' . $candidate_id])) {
														unset($_SESSION['candidate_refID']);
														$_SESSION['candidate_refID'] = $candidate_id;
														exit(header("Location:update_candidate_details.php"));
													}

													if (isset($_POST['delete' . $candidate_id])) {
														if (executeDeleteQuery("candidate", "WHERE id='$candidate_id'")) {
												
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


<?php
require_once("../includes/footer.php");
?>