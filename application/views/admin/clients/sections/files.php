<div class="row">
    <div class="col-lg-12">

        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        
                        <th><?= __('Name') ?></th>
                    

                
                        <th><?= __('Actions') ?></th>
                    </tr>
                </thead>


                <tbody>
                    <?php foreach($files as $file) { ?>
                        <tr>
                            <td><?= $file['id']; ?></td>

                            <td><a href="<?= base_url('admin/clients/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>

                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/clients/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                    
                                    <?php if(has_permission('clients-delete')) { ?>
                                    <button data-modal="admin/clients/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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
