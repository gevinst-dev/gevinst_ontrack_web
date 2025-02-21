<div class="row">
    <div class="col-md-6">
        <div class="card">


            <div class="card-header">
                <h5><?= __('Details') ?></h5>


            </div>



            <div class="card-body">
                <table class="table table-striped table-simple">

                    <tr>
                        <th><?= __("Name"); ?></th>
                        <td><?= $license['name']; ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Tag"); ?></th>
                        <td><?= $license['tag']; ?></td>
                    </tr>



                    <tr>
                        <th><?= __("Category"); ?></th>
                        <td><?= get_license_category_name($license['category_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Status"); ?></th>
                        <td><?= get_status_name($license['status_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Client"); ?></th>
                        <td><?= get_client_name($license['client_id']); ?></td>
                    </tr>



                    <tr>
                        <th><?= __("Supplier"); ?></th>
                        <td><?= get_supplier_name($license['supplier_id']); ?></td>
                    </tr>



                    <tr>
                        <th><?= __("Serial Number"); ?></th>
                        <td><?= $license['serial_number']; ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Seats"); ?></th>
                        <td><?= $license['seats']; ?></td>
                    </tr>



                    <?php foreach ($customfields as $customfield) { ?>


                        <tr>
                            <th><?= __($customfield['name']); ?></th>
                            <td><?= extract_value($customfield['id'],$license['custom_fields_values']); ?></td>
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

                            <?php if(has_permission('licenses-edit')) { ?>
                            <button data-modal="admin/inventory/licenses/release_user/<?= $license['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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

        <?php if($license['notes'] != "") { ?>
            <div class="card">


                <div class="card-header">
                    <h5><?= __('Notes') ?></h5>


                </div>



                <div class="card-body">
                    <?= $license['notes'] ?>
                </div>

            </div>

        <?php } ?>
    </div>

    <div class="col-md-6">





        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Assigned Assets') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('licenses-edit')) { ?>
                        <button data-modal="admin/inventory/licenses/assign_asset/<?= $license['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Assign Asset') ?>
                        </button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($assigned_assets)) { ?>
                    <?= __('No assets have been assigned.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table  table-hover m-b-0 ">
                            <thead>
                                <tr>
                                    <th><?= __('Asset Tag') ?></th>
                                    <th><?= __('Asset Name') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($assigned_assets as $assigned_asset) { ?>
                                    <?php
                                        $asset = $this->asset->get($assigned_asset['asset_id']);
                                    ?>
                                    <tr>
                                        <td><?= $asset['tag']; ?></td>
                                        <td><?= $asset['name']; ?></td>

                                        <td class="text-right">
                                            <div class="btn-group" role="group">

                                                <?php if(has_permission('licenses-edit')) { ?>
                                                <button data-modal="admin/inventory/licenses/unassign_asset/<?= $assigned_asset['id']; ?>" data-toggle="tooltip" title="<?= __('Unassign') ?>" type="button" class="btn btn-warning btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Comments') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('licenses-edit')) { ?>
                        <button data-modal="admin/inventory/licenses/add_comment/<?= $license['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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

                                            <?php if(has_permission('licenses-edit')) { ?>
                                            <a href="#" data-modal="admin/inventory/licenses/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                            <?php } ?>


                                            <?php if(has_permission('licenses-delete')) { ?>
                                            <a href="#" data-modal="admin/inventory/licenses/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
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

                        <?php if(has_permission('licenses-edit')) { ?>
                        <button data-modal="admin/inventory/licenses/upload_file/<?= $license['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                        <td><a href="<?= base_url('admin/inventory/licenses/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/inventory/licenses/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                
                                                <?php if(has_permission('licenses-delete')) { ?>
                                                    <button data-modal="admin/inventory/licenses/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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
