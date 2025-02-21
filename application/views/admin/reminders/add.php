<div class="modal-content">
    <?= form_open(NULL, 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Assign to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Related Client") ?></label>
                        <select class="select2 select2_clients form-control" name="client_id" >
                            <option value="0"><?= __("Nobody") ?></option>

                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Datetime") ?></label>
                        <input type="text" class="form-control" name="datetime" id="datetimepicker" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="notify_client" value="0">
                        <input type="checkbox" name="notify_client" value="1" >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Notify client") ?></span>
                    </label>
                </div>
            </div>
            







        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
