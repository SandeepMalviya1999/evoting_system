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
						<div class="title">Edit Voter Details</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<table class="table ">
									<thead>
										<tr>
											<th width="20%">Full Name</th>
											<th width="25%">Email</th>
											<th width="15%">Voted</th>
											<th width="25%">Account Create Timestamp</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($data = fetchData("system_users", "WHERE role='voter' AND election_category_id='$category_id'")) :
											foreach ($data as $value) : ?>
												<tr>
													<?php
													$voter_id = $value['user_id'];
													echo '<td>' . $value['full_name'] . '</td>';
													echo '<td>' . $value['email'] . '</td>';
													echo '<td>' . $value['voted'] . '</td>';
													echo '<td>' . $value['created_timestamp'] . '</td>';
													echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $voter_id . '">Edit</button>&emsp;';
													echo '<button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete' . $voter_id . '">Delete</button>';

													if (isset($_POST['edit' . $voter_id])) {
														unset($_SESSION['voter_refID']);
														$_SESSION['voter_refID'] = $voter_id;
														exit(header("Location:update_voter_details.php"));
													}

													if (isset($_POST['delete' . $voter_id])) {
															if (executeDeleteQuery("system_users","WHERE user_id=$voter_id")) {
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