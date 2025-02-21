<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?> | <?= APP_NAME; ?></title>
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <meta name="author" content="Codeniner">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" href="<?= base_url()?>public/favicon.png">
      <link rel="apple-touch-icon" href="<?= base_url()?>public/favicon.png">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap/css/bootstrap.min.css">

      <!-- waves.css -->
      <link rel="stylesheet" href="<?= base_url()?>public/assets/pages/waves/css/waves.min.css" type="text/css" media="all">

      <!-- feather icon -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/feather/css/feather.css">
      <!-- font-awesome-n -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/font-awesome-n.min.css">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/themify-icons/themify-icons.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/icofont/css/icofont.css">

      <!-- jQuery Toast -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/jquery-toast-plugin-master/dist/jquery.toast.min.css">

      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/pages.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/custom.css">

  </head>

  <body themebg-pattern="theme1">
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <?php echo form_open(base_url('admin/auth/forgot_password'), 'data-toggle="validator" class="md-float-material form-material"');  ?>
                        <div class="text-center">
                            <div class="trans-logo">
                                <?php if(file_exists(FCPATH.'public/logo_dark.png')) { ?>
                                        <img src='<?= base_url('public/logo_dark.png')?>' class="max-height-60">
                                <?php } else { ?>
                                        <?= get_setting('app_name'); ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="auth-box card">

                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary"><?= __('Admin Panel') ?></h3>
                                        <br>
                                        <p class="text-center"><?= __('To reset your password please enter your email address.') ?></p>
                                    </div>
                                </div>

                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label"><?= __('Email') ?></label>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>

                                <div class="row m-t-25 text-left">
                                    <div class="col-md-12">
                                        <div class="forgot-phone text-right float-right">
                                            <a href="<?= base_url()?>admin/auth/sign_in" class="text-right f-w-600"> <?= __('Sign In') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <?php if(get_setting('google_recaptcha') == "1") { ?>
                                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                            <div class="g-recaptcha" data-sitekey="<?= get_setting('google_recaptcha_sitekey') ?>" ></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-12 p-top-10">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"><?= __('CONTINUE') ?></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php echo form_close(); ?>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->

        <!-- end of container-fluid -->
    </section>


<!-- Required Jquery -->
<script type="text/javascript" src="<?= base_url()?>public/components/jquery/js/jquery-3.6.1.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>public/components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>public/components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>public/components/bootstrap/js/bootstrap.min.js"></script>
<!-- waves js -->
<script src="<?= base_url()?>public/assets/pages/waves/js/waves.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?= base_url()?>public/components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<!-- jq validation -->
<script src="<?= base_url()?>public/components/bootstrap-validator/validator.min.js"></script>
<!-- jquery toast -->
<script type="text/javascript" src="<?= base_url()?>public/components/jquery-toast-plugin-master/dist/jquery.toast.min.js"></script>

<!-- Custom js -->
<script type="text/javascript" src="<?= base_url()?>public/assets/js/common-pages.js"></script>

<script>
    $(document).ready(function() {
        <?php if($this->session->flashdata('toast-success') != ''): ?>
            $.toast({
                heading: '<?= __("Success") ?>',
                text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-success') ); ?>",
                icon: 'success',
                position: 'top-right',
            });
        <?php endif; ?>

        <?php if($this->session->flashdata('toast-warning') != ''): ?>
            $.toast({
                heading: '<?= __("Warning") ?>',
                text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-warning') ); ?>",
                icon: 'warning',
                position: 'top-right',
            });
        <?php endif; ?>

        <?php if($this->session->flashdata('toast-error') != ''): ?>
            $.toast({
                heading: '<?= __("Error") ?>',
                text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-error') ); ?>",
                icon: 'error',
                position: 'top-right',
            });
        <?php endif; ?>

        <?php if($this->session->flashdata('toast-validation') != ''): ?>
            $.toast({
                heading: '<?= __("Data Validation Error") ?>',
                text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-validation') ); ?>",
                icon: 'warning',
                position: 'top-right',
            });
        <?php endif; ?>

        <?php if(validation_errors() !== ''): ?>
            $.toast({
                heading: '<?= __("Data Validation Error") ?>',
                text: "<?= preg_replace( "/\r|\n/", "", validation_errors() ); ?>",
                icon: 'warning',
                position: 'top-right',
            });
        <?php endif; ?>

        $('[data-toggle="tooltip"]').tooltip();



    });

</script>

</body>

</html>
