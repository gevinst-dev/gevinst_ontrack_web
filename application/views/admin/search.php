<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-search bg-c-blue"></i>
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

                    <div class="card">
                        <div class="card-block">


                            <?php if($result_count == 0) { ?>

                                <p class="alert alert-warning">
                                    <b><?= __('No results have been found mathcing your query.') ?></b><br>
                                    <?= __('Please try again using a different search query') ?>
                                </p>

                            <?php } else { ?>


                                <?php if(count($assets) > 0) { ?>
                                    <h5><?= __("Assets") ?></h5>
                                    <hr>

                                    <?php foreach($assets as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/inventory/assets/details/'.$item['id']) ?>">
                                                <b><?= $item['tag']; ?></b> <?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>

                                <?php if(count($licenses) > 0) { ?>
                                    <h5><?= __("Licenses") ?></h5>
                                    <hr>

                                    <?php foreach($licenses as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/inventory/licenses/details/'.$item['id']) ?>">
                                                <b><?= $item['tag']; ?></b> <?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>


                                <?php if(count($domains) > 0) { ?>
                                    <h5><?= __("Domains") ?></h5>
                                    <hr>

                                    <?php foreach($domains as $item) { ?>
                                        <p>
                                            <a data-modal="admin/inventory/domains/view/<?= $item['id']; ?>" href="#">
                                                <b><?= $item['domain']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>


                                <?php if(count($clients) > 0) { ?>
                                    <h5><?= __("Clients") ?></h5>
                                    <hr>

                                    <?php foreach($clients as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/clients/overview/'.$item['id']) ?>">
                                                <b><?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>


                                <?php if(count($projects) > 0) { ?>
                                    <h5><?= __("Projects") ?></h5>
                                    <hr>

                                    <?php foreach($projects as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/projects/details/'.$item['id']) ?>">
                                                <b><?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>


                                <?php if(count($tickets) > 0) { ?>
                                    <h5><?= __("Tickets") ?></h5>
                                    <hr>

                                    <?php foreach($tickets as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/tickets/view/'.$item['id']) ?>">
                                                <b><?= $item['ticket']; ?></b> <?= $item['subject']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>


                                <?php if(count($issues) > 0) { ?>
                                    <h5><?= __("Issues") ?></h5>
                                    <hr>

                                    <?php foreach($issues as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/issues/view/'.$item['id']) ?>">
                                                <b><?= $item['id']; ?></b> <?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>




                                <?php if(count($suppliers) > 0) { ?>
                                    <h5><?= __("Suppliers") ?></h5>
                                    <hr>

                                    <?php foreach($suppliers as $item) { ?>
                                        <p>
                                            <a href="<?= base_url('admin/expenses/suppliers/details/'.$item['id']) ?>">
                                                <b><?= $item['name']; ?>
                                            </a>
                                        </p>
                                    <?php } ?>
                                <?php } ?>







                            <?php } ?>

                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>
