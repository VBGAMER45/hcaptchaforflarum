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

namespace vbgamer45\hCaptcha\Listeners;

use Flarum\Discussion\Event\Saving;
use vbgamer45\hCaptcha\Validators\hCaptchaValidator;
use Illuminate\Support\Arr;

class StartDiscussionValidate
{
    /**
     * @var hCaptchaValidator
     */
    protected $validator;

    /**
     * @param hCaptchaValidator $validator
     */
    public function __construct(hCaptchaValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Saving $event)
    {
        if (!$event->discussion->exists) {
            if ($event->actor->hasPermission('vbgamer45-hCaptcha.postWithoutCaptcha')) {
                return;
            }

            $this->validator->assertValid([
                'hCaptcha' => Arr::get($event->data, 'attributes.g-hCaptcha-response'),
            ]);
        }
    }
}
