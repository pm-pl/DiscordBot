<?php

/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Discord :: JaxkDev
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Plugin\Events;

use JaxkDev\DiscordBot\Models\Role;
use pocketmine\plugin\Plugin;

/**
 * Emitted when a role gets updated.
 *
 * @see RoleDeleted
 * @see RoleCreated
 */
final class RoleUpdated extends DiscordBotEvent{

    private Role $role;

    public function __construct(Plugin $plugin, Role $role){
        parent::__construct($plugin);
        $this->role = $role;
    }

    public function getRole(): Role{
        return $this->role;
    }
}