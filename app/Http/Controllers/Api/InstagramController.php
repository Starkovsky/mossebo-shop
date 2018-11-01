<?php

namespace App\Http\Controllers\Api;

use App\Instagram\Instagram;
use Illuminate\Http\Request;

class InstagramController extends ApiController
{
    protected $availableProfiles = null;

    public function widget(Request $request)
    {
        $count = (int) $request->input('count');

        $count = max(
            4,
            min(30, $count)
        );

        $profileName = $request->input('profile');

        if (! $this->checkProfileName($profileName)) {
            $profileName = $this->getDefaultProfileName();
        }

        $data = [
            'profile' => $profileName,
            'images' => Instagram::getLastImages($profileName)->splice(0, $count)
        ];

        return $this->widgetResponse($data);
    }

    protected function getAvailableProfileNames()
    {
        if (is_null($this->availableProfiles)) {
            $settingsKeys = [
                'public-social-instagram',
                'instagram-vladislav',
                'instagram-yuri',
                'instagram-mark',
            ];

            $this->availableProfiles = array_reduce($settingsKeys, function($carry, $key) {
                $link = settings($key);

                if (! $link) {
                    return $carry;
                }

                $link = str_replace('https://', '', $link);
                $link = str_replace('http://', '', $link);
                $link = str_replace('//', '', $link);
                $link = str_replace('www.instagram.com', '', $link);

                $carry[] = trim($link, '/');

                return $carry;
            }, []);
        }

        return $this->availableProfiles;
    }

    protected function getDefaultProfileName()
    {
        $profileNames = $this->getAvailableProfileNames();

        return $profileNames[0];
    }

    protected function checkProfileName($profileName)
    {
        return in_array($profileName, $this->getAvailableProfileNames());
    }

    protected function widgetResponse($data)
    {
        return response('showInstagramWidget(' . json_encode($data, JSON_UNESCAPED_UNICODE) . ')')
            ->header('Content-Type', 'application/javascript');
    }
}
