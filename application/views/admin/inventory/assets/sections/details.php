<div class="row">
    <div class="col-md-7">
        <div class="card">


            <div class="card-header">
                <h5><?= __('Details') ?></h5>


            </div>



            <div class="card-body">
                <table class="table table-striped table-simple">

                    <tr>
                        <th><?= __("Name"); ?></th>
                        <td><?= $asset['name']; ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Tag"); ?></th>
                        <td><?= $asset['tag']; ?></td>
                    </tr>


       
                    
                    <tr>
                        <th><?= __("Category"); ?></th>
                        <td><?= get_asset_category_name($asset['category_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Status"); ?></th>
                        <td><?= get_status_name($asset['status_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Client"); ?></th>
                        <td><?= get_client_name($asset['client_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("User"); ?></th>
                        <td>
                            <?php if(empty($user)) { ?>
                                <?= __('None'); ?>
                            <?php } else { ?>
                                <?= $user['name'] ?>
                            <?php } ?>

                        </td>
                    </tr>


                    <tr>
                        <th><?= __("Location"); ?></th>
                        <td><?= get_location_name($asset['location_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Supplier"); ?></th>
                        <td><?= get_supplier_name($asset['supplier_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Manufacturer"); ?></th>
                        <td><?= get_manufacturer_name($asset['manufacturer_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Model"); ?></th>
                        <td><?= get_model_name($asset['model_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Purchase Date"); ?></th>
                        <td><?= date_display($asset['purchase_date']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Warranty Expiration"); ?></th>
                        <td><?= date_display($asset['warranty_end']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Serial Number"); ?></th>
                        <td><?= $asset['serial_number']; ?></td>
                    </tr>




                    <?php foreach ($customfields as $customfield) { ?>


                        <tr>
                            <th><?= __($customfield['name']); ?></th>
                            <td><?= extract_value($customfield['id'],$asset['custom_fields_values']); ?></td>
                        </tr>



                    <?php } ?>



                </table>


            </div>


        </div>


        <?php if(!empty($user)) { ?>

            <div class="card">


                <div class="card-header">
                    <h5><?= __('Assigned User') ?></h5>

                    <div class="card-header-right">

                        <div class="btn-group" role="group" >

                            <?php if(has_permission('assets-edit')) { ?>
                            <button data-modal="admin/inventory/assets/release_user/<?= $asset['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                <?= __('Release User') ?>
                            </button>
                            <?php } ?>

                        </div>

                    </div>
                </div>


                <div class="card-body">

                    <table class="table table-striped table-simple">

                        <tr>
                            <th><?= __("Name"); ?></th>
                            <td><?= $user['name']; ?></td>
                        </tr>

                        <tr>
                            <th><?= __("Designation"); ?></th>
                            <td><?= $user['designation']; ?></td>
                        </tr>

                        <tr>
                            <th><?= __("Email"); ?></th>
                            <td><?= $user['email']; ?></td>
                        </tr>

                        <tr>
                            <th><?= __("Client"); ?></th>
                            <td><?= get_client_name($user['client_id']); ?></td>
                        </tr>





                    </table>

                </div>

            </div>


        <?php } ?>


        <?php if($asset['notes'] != "") { ?>
            <div class="card">


                <div class="card-header">
                    <h5><?= __('Notes') ?></h5>

                </div>


                <div class="card-body">
                    <?= $asset['notes'] ?>
                </div>

            </div>

        <?php } ?>
    </div>

    <div class="col-md-5">


        <?php if($asset['main_image'] != "") { ?>
            <div class="card table-card">
                <div class="card-body">
                    <img src="<?= base_url('filestore/img_cache/'); ?><?= get_image($asset['main_image'], 500, 300); ?>" class="img-fluid">
                </div>
            </div>
        <?php } ?>

        <?php if(has_permission('credentials-view')) { ?>
        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Credentials') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('credentials-add')) { ?>
                        <button data-modal="admin/inventory/assets/add_credential/<?= $asset['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                                
                                                <?php if(has_permission('credentials-edit')) { ?>
                                                <button data-modal="admin/inventory/credentials/edit/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Credential') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                                <?php } ?>

                                                <?php if(has_permission('credentials-delete')) { ?>
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


        <?php if(has_permission('licenses-view')) { ?>
        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Assigned Licenses') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('assets-edit')) { ?>
                        <button data-modal="admin/inventory/assets/assign_license/<?= $asset['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Assign License') ?>
                        </button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($assigned_licenses)) { ?>
                    <?= __('No licenses have been assigned.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table  table-hover m-b-0 ">
                            <thead>
                                <tr>
                                    <th><?= __('License Tag') ?></th>
                                    <th><?= __('License Name') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($assigned_licenses as $assigned_license) { ?>
                                    <?php
                                        $license = $this->license->get($assigned_license['license_id']);
                                    ?>
                                    <tr>
                                        <td><?= $license['tag']; ?></td>
                                        <td><?= $license['name']; ?></td>

                                        <td class="text-right">
                                            <div class="btn-group" role="group">

                                                <?php if(has_permission('assets-edit')) { ?>
                                                <button data-modal="admin/inventory/assets/unassign_license/<?= $assigned_license['id']; ?>" data-toggle="tooltip" title="<?= __('Unassign') ?>" type="button" class="btn btn-warning btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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

        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Comments') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >
                        <?php if(has_permission('assets-edit')) { ?>
                        <button data-modal="admin/inventory/assets/add_comment/<?= $asset['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                            <?php if(has_permission('assets-edit')) { ?>
                                            <a href="#" data-modal="admin/inventory/assets/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                            <?php } ?>

                                            <?php if(has_permission('assets-delete')) { ?>
                                            <a href="#" data-modal="admin/inventory/assets/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
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

                        <?php if(has_permission('assets-edit')) { ?>
                        <button data-modal="admin/inventory/assets/upload_file/<?= $asset['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                        <td><a href="<?= base_url('admin/inventory/assets/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/inventory/assets/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                <?php if(has_permission('assets-delete')) { ?>
                                                <button data-modal="admin/inventory/assets/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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
