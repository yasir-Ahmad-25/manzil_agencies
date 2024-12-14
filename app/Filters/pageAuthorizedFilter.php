<?php

// app/Filters/AuthFilter.php
namespace App\Filters;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Back\AuthModel;

class pageAuthorizedFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Retrieve the class and method name from the URI
        $class = $request->uri->getSegment(2);  // Example: "admin"
        $method = $request->uri->getSegment(3); // Example: "view"

        // Check authorization
        $auth = new AuthModel();
        $url = $class . '/' . $method;
        $userId = session()->get('user')['user_id']; // Getting user id

        $qry = $auth->query("SELECT id FROM `tbl_menu_access` ma JOIN tbl_menu m ON m.tab_id=ma.tab_id 
                             WHERE ma.user_id='$userId' AND m.tab_url='$url'");

        // If the user does not have access, redirect them to the 404 page
        if ($qry->getNumRows() <= 0) {
            // Return a redirect response if not authorized
            return redirect()->to('/admin/page_404');
            // return "user : ". $userId ." that cannot access this page ?";
        }

        // If authorized, return nothing so the request continues
        // No need to explicitly return a Response, as it will continue processing
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // This method can be left empty if no action is required after the controller is executed
    }
}
