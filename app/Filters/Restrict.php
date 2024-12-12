<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
 
class Restrict implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url($request->getLocale().'/admin/auth'));
        }
        if(!session()->get('exp_date')){
            return redirect()->to(base_url($request->getLocale().'/admin/auth'))->with('expired', "wrong credentials");
        }else{
            $status = session()->get('status');
            if($status == false){
                return redirect()->to(base_url($request->getLocale().'/admin/auth'))->with('expired', "your Account is blocked");
            }
            $currentDate    = new \DateTimeImmutable();
            $existingDateStr = session()->get('exp_date');
            $existingDate = new \DateTimeImmutable($existingDateStr);
            if ($currentDate <= $existingDate) {
                
            } else {
                // dd($existingDate,$currentDate, $currentDate<=$existingDate);
                // dd($currentDate, $existingDate);
              //  return redirect()->to(base_url($request->getLocale().'/admin/auth'))->with('expired', "your subscription is expired");
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}