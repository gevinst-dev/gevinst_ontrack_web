<div class="row">
    <div class="col-md-8">
        <div class="card">

            <?= form_open(base_url('admin/projects/edit/'.$project['id']), 'id="modal-form"'); ?>


                <div class="modal-body">

                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" value="<?= $project['name']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>



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



                    <div class="form-group">
                        <label class=""><?= __("Status") ?></label>
                        <select class="select2 form-control" name="status" required>
                            <option value="Draft" <?php if($project['status'] == "Draft") echo "selected"; ?> ><?= __("Draft") ?></option>
                            <option value="In Progress" <?php if($project['status'] == "In Progress") echo "selected"; ?> ><?= __("In Progress") ?></option>
                            <option value="Done" <?php if($project['status'] == "Done") echo "selected"; ?> ><?= __("Done") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>


                    <div class="row" id="customfields">
                        <?php foreach ($customfields as $customfield) { ?>
                            <div class="col-md-6">
                                <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], extract_value($customfield['id'],$project['custom_fields_values']) ) ?>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <textarea name="description" class="form-control" id="tinymceinput"><?= $project['description']; ?></textarea>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>


                </div>

                <?php if(has_permission('projects-edit')) { ?>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
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

                    <?php if(has_permission('projects-edit')) { ?>
                        <div class="btn-group" role="group" >
                            <button data-modal="admin/projects/add_comment/<?= $project['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                <?= __('Add Comment') ?>
                            </button>

                        </div>
                    <?php } ?>



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

                                            <?php if(has_permission('projects-edit')) { ?>
                                                <a href="#" data-modal="admin/projects/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                            <?php } ?>
                                            
                                            <?php if(has_permission('projects-delete')) { ?>
                                                <a href="#" data-modal="admin/projects/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
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

                        <?php if(has_permission('projects-edit')) { ?>
                        <button data-modal="admin/projects/upload_file/<?= $project['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                        <td><a href="<?= base_url('admin/projects/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/projects/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                
                                                <?php if(has_permission('projects-edit')) { ?>
                                                <button data-modal="admin/projects/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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

        <?php if(has_permission('credentials-view')) { ?>
        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Credentials') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('projects-edit')) { ?>
                            <button data-modal="admin/projects/add_credential/<?= $project['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                <?= __('Add Credential') ?>
                            </button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($credentials)) { ?>
                    <?= __('No credentials have been added.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table  table-hover m-b-0 ">
                            <thead>
                                <tr>
                                    <th><?= __('Type') ?></th>
                                    <th><?= __('Username') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($credentials as $credential) { ?>
                                    <tr>
                                        <td><?= $credential['type']; ?></td>
                                        <td><?= $credential['username']; ?></td>

                                        <td class="text-right">
                                            <div class="btn-group" role="group">

                                                <button data-modal="admin/inventory/credentials/view/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('View Credential') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>
                                               
                                                <?php if(has_permission('projects-edit')) { ?>

                                                    <button data-modal="admin/inventory/credentials/edit/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Credential') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                                    <button data-modal="admin/inventory/credentials/delete/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Credential') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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
        <?php } ?>


    </div>


</div>
