<div class="modal-content">
    <?= form_open_multipart(NULL, 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-5">
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

           





                <div class="col-md-5">
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

          
                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Asset") ?></label>
                        <select class="select2 form-control" name="asset_id" >
                            <option><?= __('-- None --') ?></option>
                            <?php foreach($assets as $asset) { ?>
                                <option value="<?= $asset['id'] ?>"><?= $asset['tag'] ?> <?= $asset['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("License") ?></label>
                        <select class="select2 form-control" name="license_id" >
                        <option><?= __('-- None --') ?></option>
                            <?php foreach($licenses as $license) { ?>
                                <option value="<?= $license['id'] ?>"><?= $license['tag'] ?> <?= $license['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Project") ?></label>
                        <select class="select2 form-control" name="project_id" >
                        <option><?= __('-- None --') ?></option>
                            <?php foreach($projects as $project) { ?>
                                <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
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





        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Send") ?></button>
        </div>

    <?= form_close(); ?>

</div>
