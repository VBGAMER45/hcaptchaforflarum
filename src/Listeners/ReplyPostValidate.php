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

use Flarum\Post\Event\Saving;
use vbgamer45\hcaptchaforflarum\Validators\hCaptchaValidator;
use Illuminate\Support\Arr;

class ReplyPostValidate
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
        if (!$event->post->exists) {
            // If it's a new discussion, the hCaptcha is already validated in discussion saving event
            // When this code runs, the discussion already exists, and the number has not been assigned to the post yet
            // So we look in the discussion number index, just like the reply permission check does in PostReplyHandler
            if ($event->post->discussion->post_number_index === 0) {
                return;
            }

            if ($event->actor->hasPermission('vbgamer45-hCaptcha.postWithoutCaptcha')) {
                return;
            }

            $this->validator->assertValid([
                'hCaptcha' => Arr::get($event->data, 'attributes.g-hCaptcha-response'),
            ]);
        }
    }
}
