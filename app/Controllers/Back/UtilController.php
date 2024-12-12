<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\PosModel;
use App\Models\Back\UserModel;
use App\Models\Back\WaiterModel;

class UtilController extends BaseController
{

    public function status_changer() // change status activate/block/delete
    {
       $util = new UserModel();
        $response = array();
        $response['success'] = false;
        $response['message'] = $this->alert('Enter Tenant Name', 'danger');
        if (empty($_POST['rec_id'])) $response['alert_inner'] = $this->alert('Error, Record is not Available', 'danger');
        else {
            $response['success'] = $util->updatedata($_POST['rec_tbl'], $_POST['rec_id_col'], $_POST['rec_id'], [$_POST['rec_tag_col'] => $_POST['rec_tag']]);
            $response['message'] = $this->alert('Process Completed Successfully', 'success');
        }
        echo json_encode($response);
    }

    public function change_status()
    {
        $response = array();
        if ($_POST['rec_tag'] == 'Blocked') {
            $color = 'danger';
            $icon = 'ban';
            $title = 'block_modal';
            $btn = 'Block';
        } else if ($_POST['rec_tag'] == 'Deleted') {
            $color = 'danger';
            $icon = 'trash-alt';
            $title = 'delete_modal';
            $btn = 'Delete';
        } else if ($_POST['rec_tag'] == 'Active') {
            $color = 'success';
            $icon = 'check-circle';
            $title = 'activate_modal';
            $btn = 'Activate';
        } else {
            $color = 'dark';
            $icon = 'question';
            $title = 'delete_modal';
            $btn = 'Delete';
        }

        $response['status'] = '<div class="modal-body">
                        <h3 class="text-center"><i class="fas fa-' . $icon . ' text-' . $color . ' m-2 fa-2x"></i><br>' . ($_POST['rec_page']) . '</h3>
                        <div class="row">
                        <div class="col-md-12">
                        <div id="inner_status"></div>
                                <div class="form-group text-dark" style="margin:5px">
                                    <input readonly type="text" class="form-control " value="' . $_POST['rec_title'] . '" name="rec_title">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_id'] . '" name="rec_id">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tag'] . '" name="rec_tag">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tbl'] . '" name="rec_tbl">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tag_col'] . '" name="rec_tag_col">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_id_col'] . '" name="rec_id_col">
                                </div>
                            </div>

                            <div class="col-md-9">
                                <button type="button" class="btn btn-block btn-rounded btn-outline-secondary" data-bs-dismiss="modal">
                                    <b>Cancel</b></button>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-block btn-rounded btn-outline-' . $color . '">
                                    <b>' . $btn . '</b></button>
                            </div>
                        </div>
        </div>';
        echo json_encode($response);
    }
}