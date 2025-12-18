<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\AdminActivityLogger;

class AuthController extends BaseController
{
    protected $helpers = ['form'];

    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'cookie']);
    }

    public function login()
    {
        $this->attemptRememberedLogin();

        if (session('isLoggedIn')) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/auth/login');
    }

    public function register()
    {
        if (session('isLoggedIn')) {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return view('admin/auth/register');
    }

    public function store()
    {
        $rules = [
            'full_name'         => 'required|min_length[3]|max_length[120]',
            'username'          => 'required|min_length[3]|max_length[80]|is_unique[users.username]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $payload = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'admin',
        ];

        $this->userModel->createAdmin($payload);
        AdminActivityLogger::log('auth.register', 'Registrasi akun baru', ['username' => $payload['username']]);

        return redirect()->to(site_url('admin/login'))->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }

    public function attempt()
    {
        $rules = [
            'identity' => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $identity = $this->request->getPost('identity');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByIdentity($identity);
        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Kombinasi kredensial salah.')->withInput();
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'user_name'  => $user['full_name'],
            'user_role'  => $user['role'],
        ]);

        $this->userModel->recordLogin((int) $user['id']);
        AdminActivityLogger::log('auth.login', 'Login berhasil', ['user_id' => $user['id']]);

        if ($this->request->getPost('remember_me')) {
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
            $this->userModel->setRememberToken((int) $user['id'], $token, $expires);
            set_cookie('remember_token', $token, 60 * 60 * 24 * 30);
        } else {
            $this->clearRemember((int) $user['id']);
        }

        return redirect()->to(site_url('admin/dashboard'));
    }

    public function logout()
    {
        $this->clearRemember(session('user_id'));
        session()->destroy();
        AdminActivityLogger::log('auth.logout', 'Logout dari panel admin');
        return redirect()->to(site_url('admin/login'))->with('success', 'Anda sudah keluar.');
    }

    private function attemptRememberedLogin(): void
    {
        if (session('isLoggedIn')) {
            return;
        }

        $token = get_cookie('remember_token');
        if (! $token) {
            return;
        }

        $user = $this->userModel->findByRememberToken($token);
        if (! $user) {
            delete_cookie('remember_token');
            return;
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'user_name'  => $user['full_name'],
            'user_role'  => $user['role'],
        ]);

        $this->userModel->recordLogin((int) $user['id']);
    }

    private function clearRemember(?int $userId = null): void
    {
        delete_cookie('remember_token');
        if ($userId) {
            $this->userModel->setRememberToken($userId, null, null);
        }
    }
}


