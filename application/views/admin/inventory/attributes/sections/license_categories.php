<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Color') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($license_categories as $license_category) { ?>
                        <tr>
                            <td><?= $license_category['id']; ?></td>
                            <td><?= $license_category['name']; ?></td>
                            <td>
                                <span class="label" style="background-color:<?= $license_category['color']; ?>"><?= $license_category['color']; ?></span>



                            </td>

                            <td class="text-right">
                                <div class="btn-group" role="group">

                                    <?php if(has_permission('attributes-edit')) { ?>
                                    <button data-modal="admin/inventory/attributes/edit_license_category/<?= $license_category['id']; ?>" data-toggle="tooltip" title="<?= __('Edit License Category') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                    <?php } ?>


                                    <?php if(has_permission('attributes-delete')) { ?>
                                    <button data-modal="admin/inventory/attributes/delete_license_category/<?= $license_category['id']; ?>" data-toggle="tooltip" title="<?= __('Delete License Category') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                    <?php } ?>
                                    
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
            <?php if($this->session->staff_language_rtl == '1') { ?>
                "language": {
                    "url": "<?= base_url()?>public/components/datatables/ar.json"
                },
            <?php } ?>
        });

    });
</script>
