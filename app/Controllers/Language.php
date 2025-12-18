<?php

namespace App\Controllers;

class Language extends BaseController
{
    private array $available = ['id', 'en'];

    public function switch(string $locale)
    {
        $locale = strtolower($locale);
        if (! in_array($locale, $this->available, true)) {
            $locale = config('App')->defaultLocale ?? 'id';
        }

        session()->set('locale', $locale);
        service('language')->setLocale($locale);

        $referer = $this->request->getServer('HTTP_REFERER');

        return redirect()->to($referer ?: base_url('/'));
    }
}

