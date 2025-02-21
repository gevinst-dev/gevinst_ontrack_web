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
                    <?php echo form_open(base_url('auth/sign_in'), 'data-toggle="validator" class="md-float-material form-material"');  ?>
                 
                        <div class="auth-box card">

                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12 text-center">



                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" id="email" name="email" class="form-control" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label"><?= __('Email') ?></label>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>

                                <div class="form-group form-primary">
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label"><?= __('Password') ?></label>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>

                                <div class="row m-t-25 text-left">
                                    <div class="col-md-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="hidden" name="remember_me" value="0">
                                                <input type="checkbox" name="remember_me" value="1">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse"><?= __('Remember me') ?></span>
                                            </label>
                                        </div>
                                        <div class="forgot-phone text-right float-right">
                                            <a href="<?= base_url()?>auth/forgot_password" class="text-right f-w-600"> <?= __('Forgot Password?') ?></a>
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
                                        
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"><?= __('SIGN IN') ?></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php echo form_close(); ?>

                    <script>
                        $(document).ready(function() {
                            
                            var email = $("#email").val();
                            if(email != "") {
                                $("#email").addClass('fill');
                            }
                            
                            var password = $("#password").val();
                            if(password != "") {
                                $("#password").addClass('fill');
                            }
                            
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>

</div>


   
