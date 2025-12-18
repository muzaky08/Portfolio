<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MessageModel;
use App\Services\AdminActivityLogger;
use CodeIgniter\Exceptions\PageNotFoundException;

class Messages extends BaseController
{
    protected MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    public function index()
    {
        $messages = $this->messageModel->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin/messages/index', [
            'messages' => $messages,
            'pager'    => $this->messageModel->pager,
        ]);
    }

    public function show(int $id)
    {
        $message = $this->messageModel->find($id);
        if (! $message) {
            throw PageNotFoundException::forPageNotFound('Pesan tidak ditemukan');
        }

        if (! (int) $message['is_read']) {
            $this->messageModel->markAsRead($id);
            $message['is_read'] = 1;
        }

        return view('admin/messages/show', ['message' => $message]);
    }

    public function destroy(int $id)
    {
        $this->messageModel->delete($id, true);
        AdminActivityLogger::log('message.delete', 'Menghapus pesan masuk ID ' . $id);
        return redirect()->to(site_url('admin/messages'))->with('success', 'Pesan dihapus.');
    }
}


