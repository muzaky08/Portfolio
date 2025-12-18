<?php

namespace App\Services;

use App\Models\ActivityModel;
use App\Models\BiodataModel;
use App\Models\EducationModel;
use App\Models\ExperienceModel;
use App\Models\MessageModel;
use App\Models\ProjectModel;
use App\Models\SettingModel;
use App\Models\SkillModel;

class PortfolioService
{
    public function __construct(
        private SettingModel $settingModel = new SettingModel(),
        private ProjectModel $projectModel = new ProjectModel(),
        private SkillModel $skillModel = new SkillModel(),
        private ExperienceModel $experienceModel = new ExperienceModel(),
        private BiodataModel $biodataModel = new BiodataModel(),
        private ?MessageModel $messageModel = null,
    ) {
        $this->messageModel ??= new MessageModel();
    }

    public function homepageData(): array
    {
        return cache()->remember(CacheKeys::HOMEPAGE_DATA, 300, function () {
            $settings = $this->localizedSettings($this->settingModel->getPairs());
            return [
                'settings'    => $settings,
                'skills'      => $this->skillModel->findAll(),
                'skillGroups' => $this->skillModel->categorized(),
                'projects'    => $this->projectModel->orderBy('completed_at', 'DESC')->findAll(6),
                'experiences' => $this->experienceModel->ordered(),
                'profile'     => $this->biodataModel->getBiodata(),
            ];
        });
    }

    public function featuredProjects(int $limit = 3): array
    {
        return $this->projectModel->featured($limit);
    }

    public function contactDetails(): array
    {
        return cache()->remember(CacheKeys::CONTACT_DETAILS, 600, function () {
            return [
                'email'   => $this->settingModel->findValue('contact_email', 'email@example.com'),
                'phone'   => $this->settingModel->findValue('contact_phone', ''),
                'address' => $this->settingModel->findValue('contact_address', ''),
            ];
        });
    }

    public function unreadMessages(): int
    {
        return $this->messageModel->unreadCount();
    }

    public function paginatedActivities(array $filters, int $perPage = 10, int $page = 1): array
    {
        $model = new ActivityModel();
        $items = $model->applyFilters($filters)->paginate($perPage, 'activities', $page);

        return [
            'items' => $items,
            'pager' => $model->pager,
        ];
    }

    public function paginatedEducations(array $filters, int $perPage = 10, int $page = 1): array
    {
        $model = new EducationModel();
        $items = $model->applyFilters($filters)->paginate($perPage, 'educations', $page);

        return [
            'items' => $items,
            'pager' => $model->pager,
        ];
    }

    private function localizedSettings(array $settings): array
    {
        $locale = service('request')->getLocale();
        foreach ($settings as $key => $value) {
            if (str_ends_with($key, '_' . $locale)) {
                continue;
            }

            $localizedKey = $key . '_' . $locale;
            if (isset($settings[$localizedKey]) && $settings[$localizedKey] !== '') {
                $settings[$key] = $settings[$localizedKey];
            }
        }

        return $settings;
    }
}


