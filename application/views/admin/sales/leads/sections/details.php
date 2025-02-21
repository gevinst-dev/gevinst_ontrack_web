<div class="row">
    <div class="col-md-8">
        <div class="card">


            <?= form_open_multipart(base_url('admin/sales/leads/edit/'.$lead['id']), 'data-toggle="validator"'); ?>
                <div class="card-block">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=""><?= __("Name") ?></label>
                                <input type="text" class="form-control" name="name" value="<?= $lead['name']; ?>" required>
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?= __("Tax/VAT ID") ?></label>
                                <input type="text" class="form-control" name="company_taxid" value="<?= $lead['company_taxid']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?= __("Company ID") ?></label>
                                <input type="text" class="form-control" name="company_id" value="<?= $lead['company_id']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Phone") ?></label>
                                <input type="text" class="form-control" name="phone" value="<?= $lead['phone']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Website") ?></label>
                                <input type="text" class="form-control" name="website" value="<?= $lead['website']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Email") ?></label>
                                <input type="email" class="form-control" name="email" value="<?= $lead['email']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>



                        <div class="col-md-8">
                            <div class="form-group">
                                <label class=""><?= __("Address") ?></label>
                                <input type="text" class="form-control" name="address" value="<?= $lead['address']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Country") ?></label>
                                <input type="text" class="form-control" name="country" value="<?= $lead['country']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("City") ?></label>
                                <input type="text" class="form-control" name="city" value="<?= $lead['city']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("State") ?></label>
                                <input type="text" class="form-control" name="state" value="<?= $lead['state']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Zip/Postal Code") ?></label>
                                <input type="text" class="form-control" name="zip_code" value="<?= $lead['zip_code']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                    </div>





                </div>

                <?php if(has_permission('leads-edit')) { ?>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                </div>
                <?php } ?>

            <?= form_close(); ?>
        </div>
    </div>

    <div class="col-md-4">

       

        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Comments') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('leads-edit')) { ?>
                        <button data-modal="admin/sales/leads/add_comment/<?= $lead['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Add Comment') ?>
                        </button>
                        <?php } ?>

                    </div>



                </div>
            </div>
            <div class="card-body">
                <?php if(empty($comments)) { ?>
                    <?= __('No comments have been added.') ?>
                <?php } else { ?>
                    <div class="review-block">
                        <?php foreach($comments as $comment) { ?>
                            <div class="row m-b-10">
                                <div class="col-sm-auto p-r-0">
                                    <img src="<?= gravatar($this->staff->get_email($comment['added_by']), 50); ?>" alt="user image" class="img-radius profile-img cust-img m-b-15">
                                </div>
                                <div class="col">
                                    <div class="m-b-15">
                                        <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted f-size-12"><?= datetime_display($comment['created_at']); ?></span></span>
                                        <div class="float-right">

                                            <?php if(has_permission('leads-edit')) { ?>
                                            <a href="#" data-modal="admin/sales/leads/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                            <?php } ?>

                                            <?php if(has_permission('leads-delete')) { ?>
                                            <a href="#" data-modal="admin/sales/leads/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <p class="m-t-15 m-b-0"><?= nl2br($comment['comment']); ?></p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Files') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >
                        
                        <?php if(has_permission('leads-edit')) { ?>
                        <button data-modal="admin/sales/leads/upload_file/<?= $lead['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Upload File') ?>
                        </button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($files)) { ?>
                    <?= __('No files have been uploaded.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0 without-header">
                            <tbody>
                                <?php foreach($files as $file) { ?>
                                    <tr>
                                        <td><a href="<?= base_url('admin/sales/leads/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/sales/leads/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                
                                                <?php if(has_permission('leads-delete')) { ?>
                                                <button data-modal="admin/sales/leads/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>


</div>
