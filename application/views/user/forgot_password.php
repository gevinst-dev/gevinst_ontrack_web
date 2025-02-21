
<div class="pcoded-content">


<div class="page-header card">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-title">
                    <i class="fas fa-lock bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
          
        </div>
    </div>


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <!-- Authentication card start -->
                    <?php echo form_open(base_url('auth/forgot_password'), 'data-toggle="validator" class="md-float-material form-material"');  ?>
                     
                        <div class="auth-box card">

                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                    
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
                                            <a href="<?= base_url()?>auth/sign_in" class="text-right f-w-600"> <?= __('Sign In') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">

                                    <div class="col-md-6">
                                        <?php if(get_setting('google_recaptcha') == "1") { ?>
                                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                            <div class="g-recaptcha" data-sitekey="<?= get_setting('google_recaptcha_sitekey') ?>" ></div>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-6 p-top-10">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"><?= __('CONTINUE') ?></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php echo form_close(); ?>


                </div>
            </div>
        </div>
    </div>

</div>

