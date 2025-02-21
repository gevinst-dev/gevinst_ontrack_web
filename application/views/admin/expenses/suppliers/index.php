<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-4">
                <div class="page-header-title">
                    <i class="fas fa-sign-in-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-right">

                    <?php if(has_permission('expenses-add')) { ?>
                    <?php if($section == "expenses") { ?>
                        <button data-modal="admin/expenses/expenses/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Expense') ?></button>
                    <?php } ?>
                    <?php } ?>


                    <?php if(has_permission('recurringexp-add')) { ?>
                    <?php if($section == "recurring_expenses") { ?>
                        <button data-modal="admin/expenses/recurring/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Recurring Expense') ?></button>
                    <?php } ?>
                    <?php } ?>

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
                        <div class="card-header">
                            <ul class="nav nav-pills nav-fill card-header-pills">
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('admin/expenses/suppliers/details/'.$supplier['id']) ?>"><?= __('Details') ?></a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "expenses") echo "active"; ?>" href="<?= base_url('admin/expenses/suppliers/expenses/'.$supplier['id']) ?>"><?= __('Expenses') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "recurring_expenses") echo "active"; ?>" href="<?= base_url('admin/expenses/suppliers/recurring_expenses/'.$supplier['id']) ?>"><?= __('Recurring Expenses') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "notes") echo "active"; ?>" href="<?= base_url('admin/expenses/suppliers/notes/'.$supplier['id']) ?>"><?= __('Notes') ?></a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('admin/expenses/suppliers/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "expenses") echo "show active"; ?>" id="expenses" role="tabpanel">
                            <?php if($section == "expenses") $this->load->view('admin/expenses/suppliers/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "recurring_expenses") echo "show active"; ?>" id="recurring_expenses" role="tabpanel">
                            <?php if($section == "recurring_expenses") $this->load->view('admin/expenses/suppliers/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "notes") echo "show active"; ?>" id="notes" role="tabpanel">
                            <?php if($section == "notes") $this->load->view('admin/expenses/suppliers/sections/'.$section); ?>
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




    });
</script>
