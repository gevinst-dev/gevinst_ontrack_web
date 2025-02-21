<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="about-table" class="table table-striped table-bordered">


                <tbody>

                    <tr>
                        <th colspan="2">BASE SYSTEM</th>
                    </tr>

                    <tr>
                        <th>App</th>
                        <td><?= APP_NAME ?></td>
                    </tr>


                    <tr>
                        <th>Version</th>
                        <td><?= APP_VER ?></td>
                    </tr>

                    <tr>
                        <th colspan="2">DATABASE</th>
                    </tr>

                    <tr>
                        <th>Database Hostname</th>
                        <td><?= APP_DB_HOSTNAME ?></td>
                    </tr>

                    <tr>
                        <th>Database Name</th>
                        <td><?= APP_DB_NAME ?></td>
                    </tr>
                    <tr>
                        <th>Database User</th>
                        <td><?= APP_DB_USERNAME ?></td>
                    </tr>
                    <tr>
                        <th>Database Level</th>
                        <td><?= get_setting('db_level') ?></td>
                    </tr>
                    <tr>
                        <th>Required Database Level</th>
                        <td><?= REQ_DB_LEVEL ?></td>
                    </tr>


                    <tr>
                        <th colspan="2">CODEIGNITER</th>
                    </tr>

                    <tr>
                        <th>CI Version</th>
                        <td><?= CI_VERSION ?></td>
                    </tr>


                    <tr>
                        <th colspan="2">PHP</th>
                    </tr>

                    <tr>
                        <th>Version</th>
                        <td><?= phpversion() ?></td>
                    </tr>

              


  


   


                </tbody>

            </table>

        </div>






    </div>
</div>
