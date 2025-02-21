<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-laptop bg-c-blue"></i>
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



                            <div class="form-group">
                                <label class=""><?= __("Report Name") ?></label>
                                <input type="text" class="form-control" name="name" required>
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>




                            <div class="form-group">
                                <label class=""><?= __("Choose Report Type") ?></label>

                            <div class="form-radio">
                                <form>
                                    <div class="radio radio-inline">
                                    <label>
                                    <input type="radio" name="radio" checked="checked">
                                    <i class="helper"></i><?= __("Tabular Reports") ?>
                                    </label>
                                    </div>

                                    <div class="radio radio-inline">
                                    <label>
                                    <input type="radio" name="radio">
                                    <i class="helper"></i><?= __("Matrix Reports") ?>
                                    </label>
                                    </div>

                                    <div class="radio radio-inline">
                                    <label>
                                    <input type="radio" name="radio">
                                    <i class="helper"></i><?= __("Summary Reports") ?>
                                    </label>
                                    </div>
                                </form>
                            </div>
                            </div>


                            <div class="form-group">
                                <label class=""><?= __("Choose Module") ?></label>
                                <select class="select2 form-control" name="module" required>
                                    <option value="Assets"><?= __("Assets") ?></option>
                                    <option value="Licenses"><?= __("Licenses") ?></option>
                                    <option value="Domains"><?= __("Domains") ?></option>
                                    <option value="Tickets"><?= __("Tickets") ?></option>
                                    <option value="Issues"><?= __("Issues") ?></option>
                                </select>
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>



                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Next") ?></button>
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
                "url": "<?= base_url(); ?>admin/inventory/assets/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "tag" },
                { "data": "name" },
                { "data": "category" },
                { "data": "client_name" },
                { "data": "status" },
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
