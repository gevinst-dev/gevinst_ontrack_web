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

                 





                    </table>

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


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Credentials') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >


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

                                                <button data-modal="inventory/view_credential/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('View Credential') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>
                                               
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
                <h5><?= __('Assigned Licenses') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >


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
                <h5><?= __('Files') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                      

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
                                        <td><a href="<?= base_url('inventory/download_asset_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('inventory/download_asset_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
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
