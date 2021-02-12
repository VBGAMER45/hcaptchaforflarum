<?php
/*
 * This file is part of vbgamer45/hcaptchaforflarum
 *
 * Copyright (c) 2021 FlarumPlugins.com
 * Based fof/hCaptcha by FriendsOfFlarum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        /**
         * @var \Flarum\Settings\SettingsRepositoryInterface
         */
        $settings = app('flarum.settings');

        if ($value = $settings->get($key = 'sijad-hCaptcha.sitekey')) {
            $settings->set('vbgamer45-hCaptcha.credentials.site', $value);
            $settings->delete($key);
        }

        if ($value = $settings->get($key = 'sijad-hCaptcha.secret')) {
            $settings->set('vbgamer45-hCaptcha.credentials.secret', $value);
            $settings->delete($key);
        }
    },
];
