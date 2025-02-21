<div class="modal-content">
    <?= form_open(base_url('admin/inventory/attributes/edit_location/'.$location['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Client") ?></label>
                <select class="select2 form-control" name="client_id" required>
                    <option value="0"><?= __("- None -") ?></option>
                    <?php foreach($clients as $client) { ?>
                        <option value="<?= $client['id'] ?>" <?php if($location['client_id'] == $client['id']) echo "selected"; ?> ><?= $client['name'] ?></option>
                    <?php } ?>
                </select>
            </div>




            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $location['name']; ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
