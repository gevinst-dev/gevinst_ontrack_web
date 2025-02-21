<?php
error_reporting(0);
$db_config_path = '../application/config/';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST) {

	require_once('taskCoreClass.php');
	require_once('includes/databaseLibrary.php');

	$core = new Core();
	$database = new Database();

	if($core->checkEmpty($_POST) == true)
	{
		if($database->create_database($_POST) == false)
		{
			$message = $core->show_message('error',"The database could not be created, make sure your host, username, password, database name is correct.");
		}
		else if ($database->create_tables($_POST) == false)
		{
			$message = $core->show_message('error',"The database could not be created, make sure your host, username, password, database name is correct.");
		}

		//else if ($core->checkFile() == false)
		//{
		//	$message = $core->show_message('error',"File application/config/app-config.php is Empty");
		//}

		else if ($core->write_config($_POST) == false)
		{
			$message = $core->show_message('error',"The configuration file could not be written, please make sure application/config/ folder is writable.");
		}

		if(!isset($message)) {
            $urlWb = $core->getAllData($_POST['url']);
            header( 'Location: ' . $urlWb . 'admin/' ) ;
		}
	}
	else {
		$message = $core->show_message('error','The host, username, password, database name, and URL are required.');
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Install | onTrack</title>
		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/installer.css" rel="stylesheet">
	</head>
	<body>
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <h1>onTrack Installer</h1>
            <hr>


            <div class="row">
                <div class="col-md-6">

                    <h3>Requirements</h3>


                    <?php $prevent = false; ?>

                    <?php if (version_compare(PHP_VERSION, '7.2.0', '<')) { $prevent = true; ?>

                        <div class="card bg-danger text-light mb-3">
                       
                            <div class="card-body">
                                <h3 class="card-title">PHP Version</h3>
                                &#9888; You are running PHP version <?= PHP_VERSION ?><br>
                                onTrack requires at least PHP version 7.2.0
                            </div>
                        </div>


                    <?php } else { ?>

                        <div class="card bg-success text-light mb-3">
                
                            <div class="card-body">
                                <h4 class="card-title">PHP Version</h4>
                                &#10003; You are running PHP version <?= PHP_VERSION ?>
                            </div>
                        </div>

                    <?php }  ?>


                    <?php if (!function_exists('gd_info')) { $prevent = true; ?>


                        <div class="card bg-danger text-light mb-3">
                    
                            <div class="card-body">
                                <h3 class="card-title">php-gd</h3>
                                &#9888; <b>php-gd</b> extension is not availble<br>
                                This extenstion is required.
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="card bg-success text-light mb-3">
                         
                            <div class="card-body">
                                <h3 class="card-title">php-gd</h3>
                                &#10003; <b>php-gd</b> extenstion is available
                            </div>
                        </div>
                    <?php }  ?>

                    <?php if (!function_exists('mb_check_encoding')) { $prevent = true; ?>


                        <div class="card bg-danger text-light mb-3">
                        
                            <div class="card-body">
                                <h3 class="card-title">php-mbstring</h3>
                                &#9888; <b>php-mbstring</b> extension is not availble<br>
                                This extenstion is required.
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="card bg-success text-light mb-3">
                         
                            <div class="card-body">
                                <h3 class="card-title">php-mbstring</h3>
                                &#10003; <b>php-mbstring</b> extenstion is available
                            </div>
                        </div>
                    <?php }  ?>







                    <?php if (!function_exists('imap_open')) { ?>



                        <div class="card bg-warning text-light mb-3">
                        
                            <div class="card-body">
                                <h3 class="card-title">php-imap</h3>
                                &#9888; <b>php-imap</b> extension is not availble<br>
                                This extenstion is recommended if you will be connection to an email account in order to import tickets.
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="card bg-success text-light mb-3">
                     
                            <div class="card-body">
                                <h3 class="card-title">php-imap</h3>
                                &#10003; <b>php-imap</b> extenstion is available
                            </div>
                        </div>
                    <?php }  ?>



                    <?php if($prevent) { ?>

                        <button class="btn btn-success btn-block retry" > Retry</button>

                    <?php } ?>



                </div>

                <div class="col-md-6">
                    <h3>Configuration</h3>

                    <?php
                    if(is_writable($db_config_path))
                    {
                    ?>
                        <?php if(isset($message)) {
                        echo '
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        ' . $message . '
                        </div>';
                        }?>


                        <?php if($prevent) { ?>

                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Please fix the warning from the left pane in order to proceed.
                            </div>

                        <?php } ?>

                        <form id="install_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">


                            <div class="form-group">
                                <label for="hostname">Database Hostname</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="text" id="hostname" value="localhost" class="form-control" name="hostname" placeholder="You database hostname" required />
                            </div>

                            <div class="form-group">
                                <label for="username">Database Username</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="text" id="username" class="form-control" name="username" placeholder="You database username" required />

                            </div>

                            <div class="form-group">
                                <label for="password">Database Password</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="password" id="password" class="form-control" name="password" placeholder="You database password" />

                            </div>

                            <div class="form-group">
                                <label for="database">Database Name</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="text" id="database" class="form-control" name="database" placeholder="You database name" required />

                            </div>

                            <div class="form-group">
                                <label for="database">URL</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="text" id="url" class="form-control" name="url" placeholder="Application URL" value="<?= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"). "://". @$_SERVER['HTTP_HOST'] ?>/" required />
                                <p class="help-block">Including trailing slash, E.g. https://ontrack.example.com/</p>
                            </div>

                            <div class="form-group">
                                <label for="database">Email Address</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="email" id="email" class="form-control" name="email" required placeholder="Administrator email address" />
                            </div>

                            <div class="form-group">
                                <label for="database">Administrator Password</label>
                                <input <?php if($prevent) echo 'disabled'; ?> type="password" id="admin_password" class="form-control" name="admin_password" required placeholder="Administrator password" />

                            </div>



                            <input type="submit" value="Install" class="btn btn-primary btn-block" id="submit" <?php if($prevent) echo 'disabled'; ?> />
                        </form>

                        <?php
                        }
                        else {
                        ?>
                        <p class="alert alert-danger">
                            Please make sure the application/config/ folder is writable.
                            </p>
                        <?php
                        }
                        ?>


                </div>
            </div>

        </div>

            <footer>
                <div class="col-md-12 text-center m-b-20">
                    <hr>
                    onTrack Installer
                </div>
            </footer>
      </div>
      <script src="assets/jquery/jquery.min.js" type="text/javascript"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/installer.js"></script>

	</body>
</html>
