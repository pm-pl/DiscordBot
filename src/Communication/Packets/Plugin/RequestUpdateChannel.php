<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Communication\Packets\Plugin;

use JaxkDev\DiscordBot\Communication\BinaryStream;
use JaxkDev\DiscordBot\Communication\Packets\Packet;
use JaxkDev\DiscordBot\Models\Channels\GuildChannel;

class RequestUpdateChannel extends Packet{

    public const SERIALIZE_ID = 80;

    private GuildChannel $channel;

    public function __construct(GuildChannel $channel, ?int $uid = null){
        parent::__construct($uid);
        $this->channel = $channel;
    }

    public function getChannel(): GuildChannel{
        return $this->channel;
    }

    public function binarySerialize(): BinaryStream{
        $stream = new BinaryStream();
        $stream->putSerializable($this->channel); //todo
        return $stream;
    }

    public static function fromBinary(BinaryStream $stream): self{
        return new self(
            $stream->getSerializable(GuildChannel::class) //todo
        );
    }
}