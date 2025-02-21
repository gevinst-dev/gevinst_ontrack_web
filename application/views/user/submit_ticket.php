<div class="pcoded-content">


<div class="page-header card">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-title">
                    <i class="fas fa-ticket-alt bg-c-blue"></i>
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

                <div class="card">
                        <div class="card-block">


                        <?= form_open_multipart(NULL, 'id="modal-form"'); ?>

                    
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class=""><?= __("Subject") ?></label>
                                            <input type="text" class="form-control" name="subject" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>




                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class=""><?= __("Priority") ?></label>
                                            <select class="select2 form-control" name="priority" required>
                                                <option value="Low"><?= __("Low") ?></option>
                                                <option value="Normal" selected><?= __("Normal") ?></option>
                                                <option value="High"><?= __("High") ?></option>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                            

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""><?= __("Email Address") ?></label>
                                            <input type="email" class="form-control" name="email" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                         
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""><?= __("CC Recipients") ?></label>
                                            <input type="text" class="form-control" name="cc">
                                            <span class="help-block with-errors messages text-danger"></span>
                                            <span class="help-block text-muted"><?= __("Comma separated") ?></span>
                                        </div>
                                    </div>



                    

                                    <div class="col-md-12">
                                        <hr>
                                    </div>

                                </div>




                                <div class="row" id="customfields">
                                    <?php foreach ($customfields as $customfield) { ?>
                                        <div class="col-md-6">
                                            <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], "", $customfield['description']) ?>
                                        </div>
                                    <?php } ?>
                                </div>



                                <div class="form-group">
                                    <label class=""><?= __("Message") ?></label>
                                    <textarea name="message" class="form-control" id="tinymceinput"></textarea>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>




                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="userfiles[]" multiple>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                </div>

                                <?php if(get_setting('google_recaptcha') == "1") { ?>
                                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                    <div class="g-recaptcha" data-sitekey="<?= get_setting('google_recaptcha_sitekey') ?>" ></div>
                                <?php } ?>




                            </div>
                            <div class="modal-footer">



                             
                                <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Send") ?></button>
                            </div>

                            <?= form_close(); ?>

                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

</div>


   
