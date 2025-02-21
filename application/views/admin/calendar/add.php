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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Title") ?></label>
                        <input type="text" class="form-control" name="title" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Calendar") ?></label>
                        <select class="select2 form-control" name="calendar" required>
                            <option value="Private" selected><?= __("Private") ?></option>
                            <option value="Group"><?= __("Group") ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Related Client") ?></label>
                        <select class="select2 select2_clients form-control" name="client_id" >
                            <option value="0"><?= __("Nobody") ?></option>

                        </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Start Date") ?></label>
                        <input type="text" class="form-control" name="start_date" id="datetimepicker">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("End Date") ?></label>
                        <input type="text" class="form-control" name="end_date" id="datetimepicker2">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="all_day" value="0">
                                <input type="checkbox" name="all_day" value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("All Day") ?></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="reminder" value="0">
                                <input type="checkbox" name="reminder" value="1" id="reminder">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Create Reminder") ?></span>
                            </label>
                        </div>
                    </div>

                </div>


                <div class="col-md-12">
                    <div class="row" id="remind_me" style="display: none;">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=""><?= __("Remind me") ?></label>
                                <select class="select2 form-control" name="remind_me" >
                                    <option value="-1 hour" ><?= __("1 hour before") ?></option>
                                    <option value="-2 hours" selected><?= __("2 hours before") ?></option>
                                    <option value="-4 hours" ><?= __("4 hours before") ?></option>
                                    <option value="-1 day" ><?= __("1 day before") ?></option>
                                    <option value="-2 days" ><?= __("2 days before") ?></option>
                                    <option value="-5 days" ><?= __("5 days before") ?></option>
                                    <option value="-7 days" ><?= __("7 days before") ?></option>
                        
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12">
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


                        



                    </div>
                </div>

                
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Event") ?></button>
        </div>

    <?= form_close(); ?>

</div>


<script>

    $(document).ready(function() {
        $("#reminder").on('change', function() {
            if(this.checked) {
                $('#remind_me').slideDown();
            } else {
                $('#remind_me').slideUp();
            }
        });


    });

</script>