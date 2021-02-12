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

namespace vbgamer45\hcaptchaforflarum;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Discussion\Event\Saving as DiscussionSaving;
use Flarum\Extend;
use Flarum\Post\Event\Saving as PostSaving;
use Flarum\User\Event\Saving as UserSaving;
use vbgamer45\hcaptchaforflarum\Listeners\AddValidatorRule;
use vbgamer45\hcaptchaforflarum\Validators\hCaptchaValidator;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less')
        ->content(Content\AddhCaptchaJs::class)
        ->content(Content\ExtensionSettings::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Settings())
        ->serializeToForum('darkMode', 'theme_dark_mode', function ($val) {
            return (bool) $val;
        }),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('postWithoutCaptcha', function (ForumSerializer $serializer) {
            return (bool) $serializer->getActor()->hasPermission('vbgamer45-hCaptcha.postWithoutCaptcha');
        }),

    (new Extend\Validator(hCaptchaValidator::class))
        ->configure(AddValidatorRule::class),

    (new Extend\Event())
        ->listen(UserSaving::class, Listeners\RegisterValidate::class)
        ->listen(DiscussionSaving::class, Listeners\StartDiscussionValidate::class)
        ->listen(PostSaving::class, Listeners\ReplyPostValidate::class),
];
