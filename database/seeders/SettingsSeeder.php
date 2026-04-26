<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Naija Property Hub',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
            ],
            [
                'key' => 'support_email',
                'value' => 'support@realestate.ng',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Support Email',
            ],
            [
                'key' => 'support_whatsapp',
                'value' => '+2348000000000',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Support WhatsApp',
            ],
            [
                'key' => 'favicon_path',
                'value' => null,
                'type' => 'string',
                'group' => 'branding',
                'label' => 'Favicon',
            ],
            [
                'key' => 'logo_path',
                'value' => null,
                'type' => 'string',
                'group' => 'branding',
                'label' => 'Application Logo',
            ],
            [
                'key' => 'allow_free_first_sale_listing',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'listing',
                'label' => 'Allow One Free Sale Listing',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
