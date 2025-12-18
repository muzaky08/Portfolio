<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\MessageModel;
use App\Models\SettingModel;

class MessageController extends BaseController
{
    protected MessageModel $messageModel;
    protected SettingModel $settingModel;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->messageModel = new MessageModel();
        $this->settingModel = new SettingModel();
        helper('form');
    }

    public function store()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[120]',
            'email'   => 'required|valid_email|max_length[150]',
            'subject' => 'permit_empty|max_length[150]',
            'message' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $payload = [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ];

        $this->messageModel->insert($payload);
        $this->notifyAdmin($payload);

        return redirect()->back()->with('success', lang('App.contact_success'));
    }

    private function notifyAdmin(array $payload): void
    {
        $recipient = $this->settingModel->findValue('contact_email');
        if (empty($recipient)) {
            return;
        }

        try {
            $email = service('email');
            $email->setTo($recipient);
            $subject = '[Portfolio] ' . ($payload['subject'] ?: 'Pesan baru');
            $email->setSubject($subject);
            $email->setMessage(view('emails/contact_notification', ['payload' => $payload]));
            $email->send();
        } catch (\Throwable $throwable) {
            log_message('error', 'Gagal mengirim notifikasi email: {error}', ['error' => $throwable->getMessage()]);
        }
    }
}


