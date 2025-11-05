<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use SimpleXMLElement;

class ExportController extends Controller
{
    /**
     * Export user data as XML
     */
    public function xml()
    {
        $profiles = Profile::with('galleries')->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><profiles/>');

        foreach ($profiles as $profile) {
            $profileElement = $xml->addChild('profile');
            $profileElement->addChild('id', $profile->id);
            $profileElement->addChild('user_id', $profile->user_id);
            $profileElement->addChild('username', $profile->username ?? 'N/A');
            $profileElement->addChild('bio', $profile->bio ?? 'N/A');
            $profileElement->addChild('avatar_url', $profile->avatar_url ?? 'N/A');

            // Add contact info
            if ($profile->contact_info) {
                $contactElement = $profileElement->addChild('contact_info');
                foreach ($profile->contact_info as $key => $value) {
                    $contactElement->addChild($key, $value);
                }
            }

            // Add wallet addresses
            if ($profile->wallet_addresses) {
                $walletsElement = $profileElement->addChild('wallet_addresses');
                foreach ($profile->wallet_addresses as $index => $wallet) {
                    $walletsElement->addChild('wallet', $wallet);
                }
            }

            // Add galleries
            if ($profile->galleries->count() > 0) {
                $galleriesElement = $profileElement->addChild('galleries');
                foreach ($profile->galleries as $gallery) {
                    $galleryElement = $galleriesElement->addChild('image');
                    $galleryElement->addChild('id', $gallery->id);
                    $galleryElement->addChild('url', $gallery->image_url);
                    $galleryElement->addChild('filename', $gallery->filename ?? 'N/A');
                }
            }

            $profileElement->addChild('created_at', $profile->created_at->toIso8601String());
            $profileElement->addChild('updated_at', $profile->updated_at->toIso8601String());
        }

        $xmlContent = $xml->asXML();

        return response($xmlContent)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="profiles-export.xml"');
    }
}
