<?php
	require_once("nav.php");
?>

<div class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php require_once("../includes/view_messages_and_errors.php"); ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="title">Edit Election Category</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
								<table class="table ">
									<thead>
										<tr>
											<th width="30%">Category Name</th>
											<th width="20%">Create Timestamp</th>
											<th width="20%">Expire Timestamp</th>
											<th width="20%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($data = fetchData("election_category", "")) :
											foreach ($data as $value) : ?>
												<tr>
													<?php
													$categoryID = $value["id"];
													echo '<td>' . $value['name'] . '</td>';
													echo '<td>' . $value['timestamp'] . '</td>';
													echo '<td>' . $value['expire_timestamp'] . '</td>';
													echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $categoryID . '">Edit</button>&emsp;';
													echo '<button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete' . $categoryID . '">Delete</button>';

													if (isset($_POST['edit' . $categoryID])) {
														unset($_SESSION['category_refID']);
														$_SESSION['category_refID'] = $categoryID;
														exit(header("Location:update_election_category.php"));
													}

													if (isset($_POST['delete' . $categoryID])) {

														if (executeDeleteQuery("election_category","WHERE id=$categoryID")) {
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