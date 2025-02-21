<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Status') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($paymentmethods as $paymentmethod) { ?>
                        <tr>
                            <td><?= $paymentmethod['id']; ?></td>
                            <td><?= $paymentmethod['name']; ?></td>
                            <td>
                                <?php if($paymentmethod['status'] == "Inactive") { ?>
                                    <span class="label label-inverse-danger"><?= __('Inactive') ?></span>
                                <?php } ?>
                                <?php if($paymentmethod['status'] == "Active") { ?>
                                    <span class="label label-inverse-success"><?= __('Active') ?></span>
                                <?php } ?>
                            </td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button data-modal="admin/setup/settings/edit_paymentmethod/<?= $paymentmethod['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Payment Method') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                    <button data-modal="admin/setup/settings/delete_paymentmethod/<?= $paymentmethod['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Payment Method') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>






    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        $('#DataTables').DataTable({
            "processing": true,
            "stateSave": true,
            "fixedHeader": true,
        });

    });
</script>
