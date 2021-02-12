<?php

/*
 * This file is part of fof/hCaptcha.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vbgamer45\hCaptcha\Content;

use Flarum\Frontend\Document;

class AddhCaptchaJs
{
    public function __invoke(Document $document)
    {
        $locale = app('translator')->getLocale();

        $document->head[] = "<script src=\"https://hcaptcha.com/1/api.js?hl=$locale&render=explicit\" async defer></script>";
    }
}
