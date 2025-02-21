<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-tasks bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">
                   
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">

                        <div class="col-xl-8 col-md-12">
                            <div class="card comp-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="f-w-700 text-c-blue"><?= $issue['name']; ?></h3>
                                            <br>
                                            <p class="m-b-0">
                                               
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <?php if($issue['priority'] == "Low") { ?>
                                                <i class="fas fa-flag bg-c-green" data-toggle="tooltip" title="<?= __('Low priority') ?>"></i>
                                            <?php } else if($issue['priority'] == "Normal") { ?>
                                                <i class="fas fa-flag bg-c-blue" data-toggle="tooltip" title="<?= __('Normal priority') ?>"></i>
                                            <?php } else { ?>
                                                <i class="fas fa-flag bg-c-red" data-toggle="tooltip" title="<?= __('High priority') ?>"></i>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Description') ?></h5>
                                </div>
                                <div class="card-body">
                                    <?= purify($issue['description']); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 col-md-12">
                                    <div class="card table-card">
                                        <div class="card-header">
                                            <h5><?= __('Comments') ?></h5>
                                            <div class="card-header-right">

                                                <div class="btn-group" role="group" >
                                       
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
                                                                    <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted t-size-12"><?= datetime_display($comment['created_at']); ?></span></span>
                                                                    
                                                                </div>
                                                                <p class="m-t-15 m-b-0"><?= nl2br($comment['comment']); ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-12">
                                    <div class="card table-card">
                                        <div class="card-header">
                                            <h5><?= __('Files') ?></h5>
                                            <div class="card-header-right">

                                                <div class="btn-group" role="group" >

                                                    <button data-modal="issues/upload_file/<?= $issue['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                                        <?= __('Upload File') ?>
                                                    </button>

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
                                                                    <td><a href="<?= base_url('issues/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                                                    <td class="text-right">
                                                                        <div class="btn-group" role="group">
                                                                            <a href="<?= base_url('issues/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                                            
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

                        </div>


                        <div class="col-xl-4 col-md-12">


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Issue Details') ?></h5>

                                </div>
                                <div class="card-body p-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-simple">
                                            <tbody>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Issue Name') ?><br>
                                                        <?= $issue['name']; ?>
                                                    </td>
                                     
                                                </tr>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Type') ?><br>
                                                        <?= format_issue_icon($issue['type']); ?> <?= __($issue['type']); ?>
                                                    </td>
                                    
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Status') ?><br>
                                                        <?php if($issue['status'] == 'To Do') { ?>
                                                            <span class="label label-primary"><?= __('To Do') ?></span>
                                                        <?php } else if($issue['status'] == 'In Progress') { ?>
                                                            <span class="label label-warning"><?= __('In Progres') ?></span>
                                                        <?php } else { ?>
                                                            <span class="label label-success"><?= __('Done') ?></span>
                                                        <?php } ?>
                                                    </td>
                                            
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Priority') ?><br>
                                                        <?php if($issue['priority'] == 'Low') { ?>
                                                            <span class="label label-inverse-success"><?= __('Low') ?></span>
                                                        <?php } else if($issue['priority'] == 'Normal') { ?>
                                                            <span class="label label-inverse-primary"><?= __('Normal') ?></span>
                                                        <?php } else { ?>
                                                            <span class="label label-inverse-danger"><?= __('High') ?></span>
                                                        <?php } ?>
                                                    </td>
                                           
                                                </tr>


                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Due Date') ?><br>
                                                        <?= date_display($issue['due_date']); ?>
                                                    </td>
                                                    
                                                </tr>

              

                             


                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Asset') ?><br>
                                                        <?= get_asset_name($issue['asset_id']); ?>
                                                    </td>
                                          
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('License') ?><br>
                                                        <?= get_license_name($issue['license_id']); ?>
                                                    </td>
                                      
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Project') ?><br>
                                                        <?= get_project_name($issue['project_id']); ?>
                                                    </td>
                                              
                                                </tr>


                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Created At') ?><br>
                                                        <?= datetime_display($issue['created_at']); ?>
                                                    </td>
                                                  
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Last Updated') ?><br>
                                                        <?= datetime_display($issue['updated_at']); ?>
                                                    </td>
                                               
                                                </tr>


                                                <?php foreach ($customfields as $customfield) { ?>


                                                    <tr>
                                                        <td class="text-right">
                                                            <?= __($customfield['name']); ?><br>
                                                            <?= extract_value($customfield['id'],$issue['custom_fields_values']); ?>
                                                        </td>
                                                   
                                                    </tr>



                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>





                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>







<script type="text/javascript">
    $(document).ready(function() {


        $('#DataTables-SS').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "ajax": {
                "url": "<?= base_url(); ?>admin/issues/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "status" },
                { "data": "due_date" },
                { "data": "assigned_to" },
                { "data": "priority" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip()
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip()
            },


        });

    });
</script>
