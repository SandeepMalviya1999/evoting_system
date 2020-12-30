<?php
require_once("nav.php");
?>

<div class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="title">Send Mail to User</div>
                    </div>
                    <div class="panel-body">
                        <form action="email_script.php" method="post" class="form-signin">
                            <div class="form-label-group">
                                <label for="inputEmail">From <span style="color: #FF0000">*</span></label>
                                <input type="text" name="fromEmail" id="fromEmail" class="form-control" value="swethan006@gmail.com" readonly required autofocus>
                            </div> <br />
                            <div class="form-label-group">
                                <label for="inputEmail">To <span style="color: #FF0000">*</span></label>
                                <input type="text" name="toEmail" id="toEmail" class="form-control" placeholder="Email address" required autofocus>
                            </div> <br />
                            <label for="inputPassword">Subject <span style="color: #FF0000">*</span></label>
                            <div class="form-label-group">
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                            </div><br />
                            <label for="inputPassword">Message <span style="color: #FF0000">*</span></label>
                            <div class="form-label-group">
                                <textarea id="message" name="message" class="form-control" placeholder="Message" required></textarea>
                            </div> <br />
                            <button type="submit" name="sendMailBtn" class="btn btn-lg btn-primary btn-block text-uppercase">Send Email</button>
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