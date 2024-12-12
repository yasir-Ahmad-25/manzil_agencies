<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class AuthController extends BaseController
{

    use ResponseTrait;
    public function verify_token()
    {
        // $key = getenv('JWT_SECRET');
        $header = $this->request->header("Authorization");
        $token = null;

        // extract the token from the header
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        if (is_null($token) || empty($token)) {
            return false;
        }
        // $decoded = JWT::decode($token, new Key($key, 'HS256'));
        $users = new UserModel;
        $user = $users->where('jwt_token', $token)->first();
        if (is_null($user)) {
            return $this->respond(['message' => 'token is not valid'], 406);
        }
        if ($user['status'] !== 'Active') {
            return false;
        } else {
            return true;
        }

    }

    public function login()
    {
        $userModel = new UserModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $username)->first();

        if (is_null($user)) {
            return $this->respond(['error' => 'Invalid username or password34.'], 401);
        }

        $pwd_verify = password_verify($password, $user['password']);
        if (!$pwd_verify) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600 * 3600;
        $payload = array(
            "iss" => "Unogate",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "mer_id" => $user['mer_id'],
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
        );

        $token = JWT::encode($payload, $key, 'HS256');
        $data = [
            'id' => $user['id'],
            'jwt_token' => $token
        ];
        $userModel->upsert($data);
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];

        return $this->respond($response, 200);
    }
    public function register()
    {
        $rules = [
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
            'username' => ['rules' => 'required'],
            'password' => ['rules' => 'required|min_length[6]|max_length[255]'],
            'confirm_password' => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];


        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'email' => $this->request->getVar('user_email'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);

            return $this->respond(['message' => 'Registered Successfully'], 200);
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 409);

        }

    }



}
