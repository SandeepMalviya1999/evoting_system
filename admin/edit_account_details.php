<?php
require_once("nav.php");
?>

<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Edit Account Details</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<table class="table ">
									<thead>
										<tr>
											<th width="20%">Full Name</th>
											<th width="25%">Email</th>
											<th width="15%">Category</th>
											<th width="25%">Account Create Date / Time</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($data = fetchData("system_users", "WHERE role='organiser'")) :
											foreach ($data as $value) : ?>
												<tr>
													<?php
													echo '<td>' . $value['full_name'] . '</td>';
													echo '<td>' . $value['email'] . '</td>';
													$categoryID = $value["election_category_id"];

													if ($getCategoryName = fetchData("election_category", "WHERE id=$categoryID")) :
														foreach ($getCategoryName as $value1) :
															echo '<td>' . $value1['name'] . '</td>';
														endforeach;
													endif;

													echo '<td>' . $value['created_timestamp'] . '</td>';
													echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $value['user_id'] . '">Edit</button>&emsp;';
													echo '<button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete' . $value['user_id'] . '">Delete</button>';

													if (isset($_POST['edit' . $value['user_id']])) {
														unset($_SESSION['organiser_refID']);
														$_SESSION['organiser_refID'] = $value['user_id'];

														exit(header("Location:update_account_details.php"));
													}

													if (isset($_POST['delete' . $value['user_id']])) {

														$user_id = $value['user_id'];
														
														if (executeDeleteQuery("system_users","WHERE user_id=$user_id")) {
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