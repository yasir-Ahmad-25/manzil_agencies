<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\AuthModel;

class AuthController extends BaseController

{
    
    public function index(): string
    {
        return view('admin/login', $this->viewData);
    }
    public function check_login()
    {
        $session = session();
        if ($this->request->getMethod() == 'post') {

                $model = new AuthModel();
 
                $result =  $model->login($this->request->getVar('username'),$this->request->getVar('password'),$this->request->getLocale());

                if ($result['success']) {

                    // $subscription_id = $model->db->query("Select * from company_info")->getRow()->subscription_id;
                    // $url = 'http://192.168.100.35/raed24/en/api/get_validity'; // Replace with your API endpoint
    
                    // $data = [
                    //     'subscription_id' => $subscription_id,
                    // ];
    
                    // $ch = curl_init($url);
    
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
                    // $response = curl_exec($ch);
    
                    // if ($response === false) {
                    //     $error = curl_error($ch);
                     //     echo "cURL Error: $error";
                    // }
    
                    // curl_close($ch);
                    // $data = json_decode($response);
                    // $exp_date = new \DateTime($data->expire_date);
                    // $exp_date_format = $exp_date->format('Y-m-d H:i:s');
    
                    // $session->set(['exp_date'=>$exp_date_format, 'status'=>$data->status]);

                    $session->set(['exp_date'=> '2024-12-24 12:00:00', 'status'=> true]);
                    $session->set($result['sess']);
                    $rs = [
                        'success' => 1,
                        'message' => 'Login Successful'
                    ];
                    echo json_encode($rs);
                }else{
                    echo json_encode($result);
                }
            
        }
        
    }

    public function signout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url($this->viewData['locale'].'/admin'));
    }
}
