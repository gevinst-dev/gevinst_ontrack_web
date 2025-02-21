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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Subject") ?></label>
                        <input type="text" class="form-control" name="subject" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
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

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Status") ?></label>
                        <select class="select2 form-control" name="status" required>
                            <option value="Open" selected><?= __("Open") ?></option>
                            <option value="Reopened"><?= __("Reopened") ?></option>
                            <option value="In Progress"><?= __("In Progress") ?></option>
                            <option value="Answered"><?= __("Answered") ?></option>
                            <option value="Closed"><?= __("Closed") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("User") ?></label>
                        <select class="select2 form-control" name="user_id" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($users as $user) { ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Email Address") ?></label>
                        <input type="email" class="form-control" name="email" id="email" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Assign to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("CC Recipients") ?></label>
                        <input type="text" class="form-control" name="cc">
                        <span class="help-block with-errors messages text-danger"></span>
                        <span class="help-block text-muted"><?= __("Comma separated") ?></span>
                    </div>
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


                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify" value="0">
                                <input type="checkbox" name="notify" value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify user that a new ticket has been opened.") ?></span>
                            </label>
                        </div>
                    </div>
                </div>



            </div>





        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Ticket") ?></button>
        </div>

    <?= form_close(); ?>

</div>
