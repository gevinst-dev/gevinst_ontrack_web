<div class="modal-content">
    <?= form_open(base_url('admin/inventory/licenses/assign_user/'.$license['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="row">


                <div class="col-md-12">
                    <label class=""><?= __("User") ?></label>
                    <select class="select2 form-control" name="user_id" id="user_id" required >
                        <option value="0"><?= __("- Select user -") ?></option>
                        <?php foreach($users as $user) { ?>
                            <option value="<?= $user['id'] ?>"  ><?= $user['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>





            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Assign") ?></button>
        </div>

    <?= form_close(); ?>

</div>
