<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table         = 'messages';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'email', 'subject', 'message', 'is_read', 'read_at'];
    protected $useTimestamps = true;

    public function unreadCount(): int
    {
        return $this->where('is_read', 0)->countAllResults();
    }

    public function markAsRead(int $id): bool
    {
        return $this->update($id, ['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
    }
}


