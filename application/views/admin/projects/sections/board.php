

<div class="row">



    <div class="col-lg-4">


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('To Do') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >



                    </div>

                </div>
            </div>


            <div class="card-body" id="todo_empty">
                <?= __('No issues here.') ?>
            </div>


            <div class="card-body min-height-50" id="todo">
                <?php if(!empty($todo)) { ?>


                    <?php foreach($todo as $item) { ?>


                            <div class="card-sub board-item" id="<?= $item['id'] ?>" >
                                <div class="card-block">


                                    <div class="row">

                                        <div class="col-sm-8">
                                            <h5 class="card-title">
                                                <?php if($item['priority'] == "Low") { ?>
                                                    <i class="far fa-flag text-success" data-toggle="tooltip" title="<?= __('Low priority') ?>"></i>
                                                <?php } else if($item['priority'] == "Normal") { ?>
                                                    <i class="far fa-flag text-primary" data-toggle="tooltip" title="<?= __('Normal priority') ?>"></i>
                                                <?php } else { ?>
                                                    <i class="far fa-flag text-danger" data-toggle="tooltip" title="<?= __('High priority') ?>"></i>
                                                <?php } ?>

                                                &nbsp;<a class="t-size-16" href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><?= $item['id'] ?> - <?= $item['name'] ?></a>

                                            </h5>

                                        </div>

                                        <div class="col-sm-4 text-right">

                                            <?php if(has_permission('issues-delete')) { ?>
                                            <a href="#" data-modal="admin/issues/delete/<?= $item['id']; ?>" ><i class="far fa-trash-alt"></i></a>&nbsp;
                                            <?php } ?>

                                            <?php if(has_permission('issues-edit')) { ?>
                                            <a href="#" data-modal="admin/issues/edit/<?= $item['id']; ?>" ><i class="far fa-edit"></i></a>&nbsp;
                                            <?php } ?>
                                            
                                            <a href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><i class="far fa-eye"></i></a>


                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="card-text"><?= shorten_text($item['description'], 95) ?></p>
                                        </div>
                                    </div>

                                    <div class="row p-top-10">

                                        <div class="col-sm-6">

                                            <?php if($item['assigned_to'] != "0") { $staff = $this->staff->get($this->session->staff_id); ?>

                                                <img src="<?= gravatar($staff['email'], 28); ?>" class="img-radius" data-toggle="tooltip" title="<?= __('Assigned to') ?> <?= $staff['name']; ?>">&nbsp;&nbsp;

                                            <?php } ?>

                                            <?= date_display($item['due_date']); ?>
                                        </div>

                                        <div class="col-sm-6 text-right">
                                            <?= format_issue_icon($item['type']); ?> <?= __($item['type']); ?>


                                        </div>


                                    </div>



                                </div>
                            </div>



                    <?php } ?>

                <?php } ?>
            </div>
        </div>







    </div>



    <div class="col-lg-4">


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('In Progress') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >


                    </div>

                </div>
            </div>

            <div class="card-body" id="inprogress_empty">
                <?= __('No issues here.') ?>
            </div>


            <div class="card-body min-height-50" id="inprogress">
                <?php if(!empty($inprogress)) { ?>



                    <?php foreach($inprogress as $item) { ?>


                            <div class="card-sub board-item" id="<?= $item['id'] ?>" >
                                <div class="card-block">


                                    <div class="row">

                                        <div class="col-sm-8">
                                            <h5 class="card-title">
                                                <?php if($item['priority'] == "Low") { ?>
                                                    <i class="far fa-flag text-success" data-toggle="tooltip" title="<?= __('Low priority') ?>"></i>
                                                <?php } else if($item['priority'] == "Normal") { ?>
                                                    <i class="far fa-flag text-primary" data-toggle="tooltip" title="<?= __('Normal priority') ?>"></i>
                                                <?php } else { ?>
                                                    <i class="far fa-flag text-danger" data-toggle="tooltip" title="<?= __('High priority') ?>"></i>
                                                <?php } ?>

                                                &nbsp;<a class="t-size-16" href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><?= $item['id'] ?> - <?= $item['name'] ?></a>

                                            </h5>

                                        </div>

                                        <div class="col-sm-4 text-right">
                                            <?php if(has_permission('issues-delete')) { ?>
                                            <a href="#" data-modal="admin/issues/delete/<?= $item['id']; ?>" ><i class="far fa-trash-alt"></i></a>&nbsp;
                                            <?php } ?>

                                            <?php if(has_permission('issues-edit')) { ?>
                                            <a href="#" data-modal="admin/issues/edit/<?= $item['id']; ?>" ><i class="far fa-edit"></i></a>&nbsp;
                                            <?php } ?>
                                            
                                            <a href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><i class="far fa-eye"></i></a>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="card-text"><?= shorten_text($item['description'], 95) ?></p>
                                        </div>
                                    </div>

                                    <div class="row p-top-10">

                                        <div class="col-sm-6">

                                            <?php if($item['assigned_to'] != "0") { $staff = $this->staff->get($this->session->staff_id); ?>

                                                <img src="<?= gravatar($staff['email'], 28); ?>" class="img-radius" data-toggle="tooltip" title="<?= __('Assigned to') ?> <?= $staff['name']; ?>">&nbsp;&nbsp;

                                            <?php } ?>

                                            <?= date_display($item['due_date']); ?>
                                        </div>

                                        <div class="col-sm-6 text-right">
                                            <?= format_issue_icon($item['type']); ?> <?= __($item['type']); ?>


                                        </div>


                                    </div>



                                </div>
                            </div>



                    <?php } ?>


                <?php } ?>
            </div>
        </div>



    </div>



    <div class="col-lg-4">


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Done') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('projects-edit')) { ?>
                            <button data-modal="admin/projects/release/<?= $project['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                <?= __('Release') ?>
                            </button>
                        <?php } ?>

                    </div>

                </div>
            </div>


            <div class="card-body" id="done_empty">
                <?= __('No issues here.') ?>
            </div>


            <div class="card-body min-height-50" id="done">
                <?php if(!empty($done)) { ?>


                    <?php foreach($done as $item) { ?>


                            <div class="card-sub board-item" id="<?= $item['id'] ?>" >
                                <div class="card-block">


                                    <div class="row">

                                        <div class="col-sm-8">
                                            <h5 class="card-title">
                                                <?php if($item['priority'] == "Low") { ?>
                                                    <i class="far fa-flag text-success" data-toggle="tooltip" title="<?= __('Low priority') ?>"></i>
                                                <?php } else if($item['priority'] == "Normal") { ?>
                                                    <i class="far fa-flag text-primary" data-toggle="tooltip" title="<?= __('Normal priority') ?>"></i>
                                                <?php } else { ?>
                                                    <i class="far fa-flag text-danger" data-toggle="tooltip" title="<?= __('High priority') ?>"></i>
                                                <?php } ?>

                                                &nbsp;<a class="t-size-16" href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><?= $item['id'] ?> - <?= $item['name'] ?></a>

                                            </h5>

                                        </div>

                                        <div class="col-sm-4 text-right">
                                            <?php if(has_permission('issues-delete')) { ?>
                                            <a href="#" data-modal="admin/issues/delete/<?= $item['id']; ?>" ><i class="far fa-trash-alt"></i></a>&nbsp;
                                            <?php } ?>

                                            <?php if(has_permission('issues-edit')) { ?>
                                            <a href="#" data-modal="admin/issues/edit/<?= $item['id']; ?>" ><i class="far fa-edit"></i></a>&nbsp;
                                            <?php } ?>
                                            
                                            <a href="#" data-modal="admin/issues/quick_view/<?= $item['id']; ?>" ><i class="far fa-eye"></i></a>


                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="card-text"><?= shorten_text($item['description'], 95) ?></p>
                                        </div>
                                    </div>

                                    <div class="row p-top-10">

                                        <div class="col-sm-6">

                                            <?php if($item['assigned_to'] != "0") { $staff = $this->staff->get($this->session->staff_id); ?>

                                                <img src="<?= gravatar($staff['email'], 28); ?>" class="img-radius" data-toggle="tooltip" title="<?= __('Assigned to') ?> <?= $staff['name']; ?>">&nbsp;&nbsp;

                                            <?php } ?>

                                            <?= date_display($item['due_date']); ?>
                                        </div>

                                        <div class="col-sm-6 text-right">
                                            <?= format_issue_icon($item['type']); ?> <?= __($item['type']); ?>


                                        </div>


                                    </div>



                                </div>
                            </div>



                    <?php } ?>



                <?php } ?>
            </div>
        </div>



    </div>



</div>



<script type="text/javascript" src="<?= base_url()?>public/components/dragula/dragula.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        if( $( '#todo' ).children().length == 0 ) {
            $('#todo_empty').show();
        } else { $('#todo_empty').hide(); }

        if( $( '#inprogress' ).children().length == 0 ) {
            $('#inprogress_empty').show();
        } else { $('#inprogress_empty').hide(); }

        if( $( '#done' ).children().length == 0 ) {
            $('#done_empty').show();
        } else { $('#done_empty').hide(); }

    });


    dragula(
        [document.querySelector('#todo'), document.querySelector('#inprogress'), document.querySelector('#done')],
        {



            accepts: function (el, target, source, sibling) {


                // remove or add empty text
                $('#'+target.id+'_empty').hide();
                if( $( '#'+source.id ).children().length == 0 ) {  $('#'+source.id+'_empty').show(); }


                if(target.id == "todo") status = "To Do";
                if(target.id == "inprogress") status = "In Progress";
                if(target.id == "done") status = "Done";


                // update issue status on move
                if(source.id != target.id) {

                    $.post("<?= base_url('admin/projects/ajax_update_issue'); ?>",
                        {
                          id: el.id,
                          status: status,
                          <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>"
                        }
                    );

                }



                // update order

                order = "";

                $('#'+target.id).children('div').each(function(i) {
                    order = order + $(this).attr('id') + ",";

                });

        

                $.post("<?= base_url('admin/projects/ajax_update_issues_order'); ?>",
                    {
                     
                      status: status,
                      order: order,
                      <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>"
                    }
                );


                return true; // elements can be dropped in any of the `containers` by default
            },



        }
    );




</script>
