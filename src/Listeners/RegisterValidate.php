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

namespace vbgamer45\hcaptchaforflarum\Listeners;

use Flarum\User\Event\Saving;
use vbgamer45\hcaptchaforflarum\Validators\hCaptchaValidator;
use Illuminate\Support\Arr;

class RegisterValidate
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
        if (!$event->user->exists) {
            $this->validator->assertValid([
                'hCaptcha' => Arr::get($event->data, 'attributes.g-hCaptcha-response'),
            ]);
        }
    }
}
