<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session('isLoggedIn')) {
            helper('cookie');
            $token = get_cookie('remember_token');
            if ($token) {
                $user = (new UserModel())->findByRememberToken($token);
                if ($user) {
                    session()->set([
                        'isLoggedIn' => true,
                        'user_id'    => $user['id'],
                        'user_name'  => $user['full_name'],
                        'user_role'  => $user['role'],
                    ]);
                } else {
                    delete_cookie('remember_token');
                }
            }
        }

        if (! session('isLoggedIn')) {
            return redirect()->to(site_url('admin/login'))->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}


