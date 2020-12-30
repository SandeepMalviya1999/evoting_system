<div class="row">
    <div class="col-sm-12">
        <?php require_once("../includes/view_messages_and_errors.php"); ?>
        <div class="panel panel-default">
        <div class="panel-heading">
						<div class="title">Vote Your Candidate for Category ( <?php echo $category_name ?> )</div>
					</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th width="30%">Name</th>
                                        <th width="20%">Photo</th>
                                        <th width="20%">Symbol</th>
                                        <th width="25%">Vote</th>
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
                                                echo '<td><label class="switch"><input type="checkbox" name="votes[]" value="' . $candidate_id . '"><span class="slider"></span></label></td>';
                                                //echo '<td><button type="submit" class="btn btn-primary btn-sm" name="edit' . $candidate_id . '">Edit</button>&emsp;';
                                                ?>

                                            </tr>

                                    <?php endforeach;
                                    endif; ?>
                                    <tr>
                                        <td colspan="4"><button class="btn-primary btn-lg navbar-right" type="submit" name="submit">Submit Your Vote</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>