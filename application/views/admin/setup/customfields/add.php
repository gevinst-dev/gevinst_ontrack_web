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
                        <label class=""><?= __("For") ?></label>
                        <select class="select2 form-control" name="for" required>
                            <option value=""><?= __("- Please select -") ?></option>

                            <option value="Assets"><?= __("Assets") ?></option>
                            <option value="Licenses"><?= __("Licenses") ?></option>
                            <option value="Projects"><?= __("Projects") ?></option>

                            <option value="Tickets"><?= __("Tickets") ?></option>
                            <option value="Issues"><?= __("Issues") ?></option>

                            <option value="Clients"><?= __("Clients") ?></option>

                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Type") ?></label>
                        <select class="select2 form-control" name="type" required>
                            <option value=""><?= __("- Please select -") ?></option>

                            <option value="Text Box"><?= __("Text Box") ?></option>
                            <option value="Text Area"><?= __("Text Area") ?></option>
                            <option value="Dropdown"><?= __("Dropdown") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Options") ?></label>
                        <input type="text" class="form-control" name="options" >
                        <span class="help-block with-errors messages text-muted"><?= __("For Dropdowns Only - Comma Seperated List") ?></span>
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="required" value="0">
                                <input type="checkbox" name="required" value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Required") ?></span>
                            </label>
                        </div>
                    </div>
                </div>



            </div>







        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
