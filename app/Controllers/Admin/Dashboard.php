<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExperienceModel;
use App\Models\MessageModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $projectModel    = new ProjectModel();
        $skillModel      = new SkillModel();
        $experienceModel = new ExperienceModel();
        $messageModel    = new MessageModel();

        $data = [
            'projectCount'    => $projectModel->countAllResults(),
            'skillCount'      => $skillModel->countAllResults(),
            'experienceCount' => $experienceModel->countAllResults(),
            'messageCount'    => $messageModel->countAllResults(),
            'unreadMessages'  => $messageModel->unreadCount(),
            'latestProjects'  => $projectModel->orderBy('created_at', 'DESC')->findAll(5),
            'latestMessages'  => $messageModel->orderBy('created_at', 'DESC')->findAll(5),
        ];

        return view('admin/dashboard', $data);
    }
}


