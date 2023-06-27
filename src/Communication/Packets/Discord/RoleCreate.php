<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev#2698
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Communication\Packets\Discord;

use JaxkDev\DiscordBot\Models\Role;
use JaxkDev\DiscordBot\Communication\Packets\Packet;

class RoleCreate extends Packet{

    private Role $role;

    public function __construct(Role $role){
        parent::__construct();
        $this->role = $role;
    }

    public function getRole(): Role{
        return $this->role;
    }

    public function __serialize(): array{
        return [
            $this->UID,
            $this->role
        ];
    }

    public function __unserialize(array $data): void{
        [
            $this->UID,
            $this->role
        ] = $data;
    }
}