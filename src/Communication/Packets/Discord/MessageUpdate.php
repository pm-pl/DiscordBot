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

namespace JaxkDev\DiscordBot\Communication\Packets\Discord;

use JaxkDev\DiscordBot\Communication\BinaryStream;
use JaxkDev\DiscordBot\Communication\Packets\Packet;
use JaxkDev\DiscordBot\Models\Messages\Message;

final class MessageUpdate extends Packet{

    public const SERIALIZE_ID = 26;

    /**
     * @var Message|array{"message_id": string, "channel_id": string, "guild_id": ?string}
     */
    private Message|array $message;

    /**
     * @param Message|array{"message_id": string, "channel_id": string, "guild_id": ?string} $message
     */
    public function __construct(Message|array $message, ?int $uid = null){
        parent::__construct($uid);
        $this->message = $message;
    }

    /**
     * @return Message|array{"message_id": string, "channel_id": string, "guild_id": ?string}
     */
    public function getMessage(): Message|array{
        return $this->message;
    }

    public function binarySerialize(): BinaryStream{
        $stream = new BinaryStream();
        $stream->putInt($this->getUID());
        if($this->message instanceof Message){
            $stream->putBool(false); // not partial
            $stream->putSerializable($this->message);
        }else{
            $stream->putBool(true); // partial
            $stream->putNullableString($this->message["guild_id"]);
            $stream->putString($this->message["channel_id"]);
            $stream->putString($this->message["message_id"]);
        }
        return $stream;
    }

    public static function fromBinary(BinaryStream $stream): self{
        $uid = $stream->getInt();
        if($stream->getBool()){ //partial
            return new self(
                [
                    "guild_id" => $stream->getNullableString(),
                    "channel_id" => $stream->getString(),
                    "message_id" => $stream->getString()
                ],
                $uid
            );
        }else{
            return new self(
                $stream->getSerializable(Message::class),
                $uid
            );
        }
    }
}