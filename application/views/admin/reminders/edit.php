<div class="modal-content">
    <?= form_open(base_url('admin/reminders/edit/'.$reminder['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" value="<?= $reminder['description'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Status") ?></label>
                        <select class="select2 form-control" name="status" required>
                            <option value="Upcoming" <?php if($reminder['status'] == "Upcoming") echo "selected"; ?> ><?= __("Upcoming") ?></option>
                            <option value="Reminded" <?php if($reminder['status'] == "Reminded") echo "selected"; ?> ><?= __("Reminded") ?></option>
                        </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Assigned to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if($item['id'] == $reminder['assigned_to']) echo "selected"; ?> ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Related Client") ?></label>
                        <select class="select2 select2_clients form-control" name="client_id" >
                            <?php if($client) { ?>
                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?> - <?php echo $client['company_taxid']; ?></option>
                            <?php } else { ?>

                                <option value="0"><?= __("Nobody") ?></option>
                            <?php } ?>


                        </select>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Datetime") ?></label>
                        <input type="text" class="form-control" name="datetime" value="<?= datetime_hi_display($reminder['datetime']) ?>" id="datetimepicker" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
            </div>


            <div class="form-group">
                
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="notify_client" value="0">
                        <input type="checkbox" name="notify_client" value="1" <?php if($reminder['notify_client'] == 1) echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Notify client") ?></span>
                    </label>
                </div>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
