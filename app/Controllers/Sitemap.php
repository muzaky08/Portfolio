<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends BaseController
{
    public function index(): ResponseInterface
    {
        $urls = [
            [
                'loc'        => base_url('/'),
                'priority'   => '1.0',
                'changefreq' => 'daily',
            ],
            [
                'loc'        => site_url('admin/login'),
                'priority'   => '0.4',
                'changefreq' => 'monthly',
            ],
        ];

        $projects = (new ProjectModel())->orderBy('updated_at', 'DESC')->findAll();
        foreach ($projects as $project) {
            $urls[] = [
                'loc'        => base_url('/?project=' . $project['slug']),
                'priority'   => '0.6',
                'changefreq' => 'monthly',
            ];
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $urlElement = $dom->createElement('url');
            $loc        = $dom->createElement('loc', htmlspecialchars($url['loc'], ENT_XML1));
            $urlElement->appendChild($loc);
            $urlElement->appendChild($dom->createElement('changefreq', $url['changefreq']));
            $urlElement->appendChild($dom->createElement('priority', $url['priority']));
            $urlset->appendChild($urlElement);
        }

        $dom->appendChild($urlset);

        return $this->response->setHeader('Content-Type', 'application/xml')
            ->setBody($dom->saveXML());
    }
}

