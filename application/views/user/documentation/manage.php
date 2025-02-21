<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-book bg-c-blue"></i>
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

                        <div class="col-md-3">
                            <div class="card">

                                <div class="card-block tree-view">

                                    <div id="basicTree">
                                        <?php documentation_page_tree_client($space['id'], 0, $selected_page_id); ?>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-block">

                                    <?php if(empty($selected_page)) { ?>

                                        <div class="alert alert-info background-info">
                                            <strong><?= __('This space is empty!') ?></strong> <br><?= __('Start adding pages to start editing this documentation space.') ?>
                                        </div>

                                    <?php } else { ?>




                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4><?= html_escape($selected_page['name']) ?></h4>
                                                    <hr>

                                                </div>

                                                <div class="col-md-12">
                                                    <h4><?= purify($selected_page['content']) ?></h4>
                                                </div>



                                            </div>

















                                    <?php } ?>

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


