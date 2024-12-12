<?= $this->extend("admin/layouts/base");?>

<?= $this->section('content');?>

    <div class="page-breadcrumb">
    <div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Access Control</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table  -->
    <div class="container-fluid">
    

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Access Control Panel </h4> </br>

                        <form id="data_form" action="<?php echo base_url($locale.'/settings/update_access') ?>" method="POST">

                            
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select name="ut_id" id="ut_id" class="form-control" required>
                                                <option value="" disabled selected>Select User</option>
                                                <?php
                                                foreach ($users as $val) {

                                                    $rn = $val['fullname'];

                                                ?>
                                                    <option value="<?= $val['user_id']; ?>"><?= $rn; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-8">
                                        <div id="menus_table"></div>
                                    </div>


                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input id="btn-signup" type="submit" class="btn btn-info" value="Save changes">
                                        </div>
                                    </div>

                           
                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var base_url = "<?php echo base_url($locale); ?>";

        $(document).ready(function() {

            const def = $('#ut_id').val();
            loadData(def);

            $('#ut_id').on('change', function() {

                const ut_id = $(this).val();

                loadData(ut_id);

            });

        });


        /*************************************************
         *  select parent checkbox if one child checked 
         *
         **************************************************/

        function changeChild(id) {
            $(".ckall[data-id=" + id + "]").prop('checked', true);

            var child = '.chchild-' + id;

            var len = $(child).length;

            var unselected = 0;

            $(child).each(function() {

                if (!this.checked) {

                    unselected = unselected + 1;
                }

            });
            if (len === unselected) {
                $(".ckall[data-id=" + id + "]").prop('checked', false);
            }
        }

        function loadData(ut_id) {

            $.ajax({
                type: 'POST',
                url: base_url + '/settings/get_menus',
                data: {
                    'ut_id': ut_id
                },
                success: function(data) {
                    $('#menus_table').html(data);

                    $('tr').on('click', '.sendmsg', function() {
                        var tr = $(this).closest('tr').next('tr');
                        tr.toggle();
                    });

                    $('td').on("change", ".ckall", function() {

                        var dataid = $(this).data('id');
                        var child = '.chchild-' + dataid;

                        if (this.checked) {

                            console.log('this.checked=' + $(this).data('id'));

                            $(child).each(function() {
                                this.checked = true;
                            });
                        } else {
                            $(child).each(function() {
                                this.checked = false;
                            });
                        }
                    });

                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                    console.log(status);
                }
            });
        }
    </script>

<?= $this->endSection();?>