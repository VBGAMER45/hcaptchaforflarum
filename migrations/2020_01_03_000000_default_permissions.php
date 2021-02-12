<?php

/*
 * This file is part of fof/hCaptcha.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Database\Migration;
use Flarum\Group\Group;

return Migration::addPermissions([
    // Allow all members, effectively disabling the post hCaptcha by default
    'vbgamer45-hCaptcha.postWithoutCaptcha' => Group::MEMBER_ID,
]);
