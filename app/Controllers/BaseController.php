<?php

namespace App\Controllers;

use App\Models\Back\AuthModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['security'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    protected $viewData = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->viewData['locale'] = $request->getLocale();
        $this->viewData['supportedLocales'] = $request->config->supportedLocales;
    }


    ###### methods used regularly #####

    public function stat_icon($status)
    {
        if ($status == 'Active') $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
        if ($status == 'Confirmed') $stat_icon = '<i class="fas fa-sync text-info mx-1"></i>';
        if ($status == 'Received') $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
        if ($status == 'Rejected') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Pending') $stat_icon = '<i class="fas fa-sync text-warning mx-1"></i>';
        if ($status == 'Recovered') $stat_icon = '<i class="fas fa-sync text-dark mx-1"></i>';
        if ($status == 'Blocked') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Cancelled') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status != 'Active' && $status != 'Confirmed' && $status != 'Received'  && $status != 'Rejected' && $status != 'Blocked' &&  $status != 'Pending' &&  $status != 'Cancelled' &&  $status != 'Recovered') $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';
        return $stat_icon;
    }

    public function alert($message, $type) // Alert function 
    {
        $alert = '<div class="alert alert-' . $type . ' alert-dismissible" id="alert" role="alert">'
            . '<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">'
            . '<span aria-hidden="true">&times;</span></button> ' . $message
            . '<div class="progress"  style="height: 2px;">
            <div class="progress-bar bg-' . $type . '" id="progress_bar" role="progressbar" style="width: 0%;" ></div>
            </div></div>';
        return $alert;
    }

    public function get_table_info($table)
    {
        $auth = new AuthModel();
        $qry = $auth->query("SELECT * FROM $table");
        return $qry->getResultArray();
    }
    public function get_table_with_branch($table)
    {
        $auth = new AuthModel();
        $brid = session()->get('user')['branch_id'];
        $qry = $auth->query("SELECT * FROM $table where branch_id='$brid'");
        return $qry->getResultArray();
    }

    public function page_authorized($class, $method)
    {
        $auth = new AuthModel();
        $url = $class.'/'. $method;
        $userid = session()->get('user')['user_id'];
        $qry = $auth->query("SELECT id FROM `tbl_menu_access` ma JOIN tbl_menu m ON m.tab_id=ma.tab_id 
        WHERE ma.user_id='$userid' AND m.tab_url='$url'");
        return $qry->getNumRows() > 0;
    }

    public function get_cash_bank_accounts()
    {
        $auth = new AuthModel();
        $brid = session()->get('user')['branch_id'];
        $sql = "SELECT account_id, acc_name FROM tbl_cl_accounts acc 
        JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id WHERE tp.acc_type_tag='CB'";

        $query = $auth->query($sql);
        return $query->getResultArray();
    }
}
