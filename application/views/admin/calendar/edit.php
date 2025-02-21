<div class="modal-content">
    <?= form_open(base_url('admin/calendar/edit/'.$event['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <fieldset <?php if(!has_permission('calendar-edit')) { ?>disabled<?php } ?> >
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Title") ?></label>
                        <input type="text" class="form-control" name="title" value="<?= $event['title']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Calendar") ?></label>
                        <select class="select2 form-control" name="calendar" required>
                            <option value="Private" <?php if($event['calendar'] == "Private") echo "selected"; ?>><?= __("Private") ?></option>
                            <option value="Group" <?php if($event['calendar'] == "Group") echo "selected"; ?>><?= __("Group") ?></option>
                        </select>
                    </div>
                </div>


                <div class="col-md-3">
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



                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Start Date") ?></label>
                        <input type="text" class="form-control" name="start_date" id="datetimepicker" required value="<?= datetime_hi_display($event['start_date']) ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("End Date") ?></label>
                        <input type="text" class="form-control" name="end_date" id="datetimepicker2" value="<?= datetime_hi_display($event['end_date']) ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="all_day" value="0">
                                <input type="checkbox" name="all_day" <?php if($event['all_day'] == "1") echo "checked"; ?> value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("All Day") ?></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"><?= $event['description']; ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <?php if(!empty($reminder)) { ?>

                <a data-modal="admin/reminders/edit/<?= $event['reminder_id']; ?>" class="btn"><i class="fas fa-bell"></i> <?= __('Reminder') ?> <?= datetime_hi_display($reminder['datetime']) ?></a>

            <?php } ?>



            </fieldset>





        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            
            <?php if(has_permission('calendar-delete')) { ?>
            <button data-modal="admin/calendar/delete/<?= $event['id']; ?>" class="btn btn-danger btn-md waves-effect waves-light"><?= __('Delete Event') ?></button>
            <?php } ?>

            <?php if(has_permission('calendar-edit')) { ?>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Event") ?></button>
            <?php } ?>
        
        </div>

    <?= form_close(); ?>

</div>
