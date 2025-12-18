<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Services\PortfolioService;

class Home extends BaseController
{
    protected PortfolioService $portfolioService;

    public function __construct()
    {
        $this->portfolioService = new PortfolioService();
        helper(['text']);
    }

    public function index()
    {
        $data                   = $this->portfolioService->homepageData();
        $data['contact']        = $this->portfolioService->contactDetails();
        $data['pageTitle']      = $data['settings']['hero_headline'] ?? lang('App.default_title');
        $data['activitySample'] = $this->portfolioService->paginatedActivities(['sort' => 'desc'], 3, 1)['items'];
        $data['educationSample']= $this->portfolioService->paginatedEducations(['sort' => 'desc'], 3, 1)['items'];
        $data['projectSample']  = array_slice($data['projects'], 0, 3);

        return view('frontend/home', $data);
    }
}
