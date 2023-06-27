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

namespace JaxkDev\DiscordBot\Models;

//https://github.com/discord/discord-api-docs/blob/master/docs/topics/Gateway.md#activity-object
class Activity{

    //TODO Enums?
    const
        TYPE_PLAYING = 0,
        TYPE_STREAMING = 1,
        TYPE_LISTENING = 2,
        TYPE_WATCHING = 3,
        TYPE_CUSTOM = 4,
        TYPE_COMPETING = 5,

        FLAG_INSTANCE = 1,
        FLAG_JOIN = 2,
        FLAG_SPECTATE = 4,
        FLAG_JOIN_REQUEST = 8,
        FLAG_SYNC = 16,
        FLAG_PLAY = 32;

    /** Activity Name */
    private string $name;

    /** Activity Type */
    private int $type;

    /** Only null when sending new presence, Unix timestamp of when the activity was added to the user's session */
    private int $created_at;

    /** Stream url, only when type is streaming. */
    private ?string $url;

    /** https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-timestamps */
    private ?int $start_timestamp;
    private ?int $end_timestamp;

    /** Application id for the game */
    private ?string $application_id;

    /** What the player is currently doing */
    private ?string $details;

    /** The user's current party status*/
    private ?string $state;

    private ?string $emoji;

    /** https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-party */
    private ?string $party_id;
    private ?int    $party_size;
    private ?int    $party_max_size;

    /** https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-assets */
    private ?string $large_image;
    private ?string $large_text;
    private ?string $small_image;
    private ?string $small_text;

    ///** @var null|string https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-secrets */
    //private $join_secret;
    ///** @var null|string */
    //private $spectate_secret;
    ///** @var null|string */
    //private $match_secret;

    /** Whether the activity is an instanced game session */
    private ?bool $instance;

    /** https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-flags */
    private ?int $flags;

    //Buttons (max 2) https://github.com/discord-php/DiscordPHP/issues/561

    public function __construct(string $name, int $type, int $created_at = null, ?string $url = null, ?int $start_timestamp = null,
                                ?int $end_timestamp = null, ?string $application_id = null, ?string $details = null,
                                ?string $state = null, ?string $emoji = null, ?string $party_id = null, ?int $party_size = null,
                                ?int $party_max_size = null, ?string $large_image = null, ?string $large_text = null,
                                ?string $small_image = null, ?string $small_text = null, /*?string $join_secret = null,
                                ?string $spectate_secret = null, ?string $match_secret = null,*/ ?bool $instance = null,
                                ?int $flags = null){
        $this->setName($name);
        $this->setType($type);
        $this->setCreatedAt($created_at??time());
        $this->setUrl($url);
        $this->setStartTimestamp($start_timestamp);
        $this->setEndTimestamp($end_timestamp);
        $this->setApplicationId($application_id);
        $this->setDetails($details);
        $this->setState($state);
        $this->setEmoji($emoji);
        $this->setPartyId($party_id);
        $this->setPartySize($party_size);
        $this->setPartyMaxSize($party_max_size);
        $this->setLargeImage($large_image);
        $this->setLargeText($large_text);
        $this->setSmallImage($small_image);
        $this->setSmallText($small_text);
        /*$this->setJoinSecret($join_secret);
        $this->setSpectateSecret($spectate_secret);
        $this->setMatchSecret($match_secret);*/
        $this->setInstance($instance);
        $this->setFlags($flags);
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function getType(): int{
        return $this->type;
    }

    public function setType(int $type): void{
        if($type < self::TYPE_PLAYING or $type > self::TYPE_COMPETING){
            throw new \AssertionError("Invalid type '{$type}'");
        }
        $this->type = $type;
    }

    public function getCreatedAt(): int{
        return $this->created_at;
    }

    public function setCreatedAt(int $timestamp): void{
        if($timestamp < 0){
            throw new \AssertionError("Invalid created_at timestamp '$timestamp'.");
        }
        $this->created_at = $timestamp;
    }

    public function getUrl(): ?string{
        return $this->url;
    }

    public function setUrl(?string $url): void{
        /*
        // Discord says it checks when type is streaming, but it seems it doesn't, both inbound and outbound...
        if($url !== null and $this->type === self::TYPE_STREAMING){
            if(!str_starts_with($url, "https://twitch.tv/") and !str_starts_with($url, "https://youtube.com/")){
                throw new \AssertionError("Invalid url '$url'.");
            }
        }
        */
        if($url !== null and !str_starts_with($url, "https://") and !str_starts_with($url, "http://")){
            throw new \AssertionError("Invalid url '$url'.");
        }
        $this->url = $url;
    }

    public function getStartTimestamp(): ?int{
        return $this->start_timestamp;
    }

    public function setStartTimestamp(?int $timestamp): void{
        if($timestamp !== null and $timestamp < 0){
            throw new \AssertionError("Invalid start timestamp '$timestamp'.");
        }
        $this->start_timestamp = $timestamp;
    }

    public function getEndTimestamp(): ?int{
        return $this->end_timestamp;
    }

    public function setEndTimestamp(?int $timestamp): void{
        if($timestamp !== null and $timestamp < 0){
            throw new \AssertionError("Invalid end timestamp '$timestamp'.");
        }
        $this->end_timestamp = $timestamp;
    }

    public function getApplicationId(): ?string{
        return $this->application_id;
    }

    public function setApplicationId(?string $application_id): void{
        $this->application_id = $application_id;
    }

    public function getDetails(): ?string{
        return $this->details;
    }

    public function setDetails(?string $details): void{
        $this->details = $details;
    }

    public function getState(): ?string{
        return $this->state;
    }

    public function setState(?string $state): void{
        $this->state = $state;
    }

    public function getEmoji(): ?string{
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): void{
        $this->emoji = $emoji;
    }

    public function getPartyId(): ?string{
        return $this->party_id;
    }

    public function setPartyId(?string $party_id): void{
        $this->party_id = $party_id;
    }

    public function getPartySize(): ?int{
        return $this->party_size;
    }

    public function setPartySize(?int $party_size): void{
        if($party_size !== null and $party_size < 0){
            throw new \AssertionError("Invalid party size '$party_size'.");
        }
        $this->party_size = $party_size;
    }

    public function getPartyMaxSize(): ?int{
        return $this->party_max_size;
    }

    public function setPartyMaxSize(?int $party_max_size): void{
        if($party_max_size !== null and $party_max_size < 0){
            throw new \AssertionError("Invalid party max size '$party_max_size'.");
        }
        $this->party_max_size = $party_max_size;
    }

    public function getLargeImage(): ?string{
        return $this->large_image;
    }

    public function setLargeImage(?string $large_image): void{
        $this->large_image = $large_image;
    }

    public function getLargeText(): ?string{
        return $this->large_text;
    }

    public function setLargeText(?string $large_text): void{
        $this->large_text = $large_text;
    }

    public function getSmallImage(): ?string{
        return $this->small_image;
    }

    public function setSmallImage(?string $small_image): void{
        $this->small_image = $small_image;
    }

    public function getSmallText(): ?string{
        return $this->small_text;
    }

    public function setSmallText(?string $small_text): void{
        $this->small_text = $small_text;
    }

    /*public function getJoinSecret(): ?string{
        return $this->join_secret;
    }

    public function setJoinSecret(?string $join_secret): void{
        $this->join_secret = $join_secret;
    }

    public function getSpectateSecret(): ?string{
        return $this->spectate_secret;
    }

    public function setSpectateSecret(?string $spectate_secret): void{
        $this->spectate_secret = $spectate_secret;
    }

    public function getMatchSecret(): ?string{
        return $this->match_secret;
    }

    public function setMatchSecret(?string $match_secret): void{
        $this->match_secret = $match_secret;
    }*/

    public function getInstance(): ?bool{
        return $this->instance;
    }

    public function setInstance(?bool $instance): void{
        $this->instance = $instance;
    }

    public function getFlags(): ?int{
        return $this->flags;
    }

    public function setFlags(?int $flags): void{
        $this->flags = $flags;
    }

    //----- Serialization -----//

    public function __serialize(): array{
        return [
            $this->name,
            $this->type,
            $this->created_at,
            $this->url,
            $this->start_timestamp,
            $this->end_timestamp,
            $this->application_id,
            $this->details,
            $this->state,
            $this->emoji,
            $this->party_id,
            $this->party_size,
            $this->party_max_size,
            $this->large_image,
            $this->large_text,
            $this->small_image,
            $this->small_text,
            /*$this->join_secret,
            $this->spectate_secret,
            $this->match_secret,*/
            $this->instance,
            $this->flags
        ];
    }

    public function __unserialize(array $data): void{
        [
            $this->name,
            $this->type,
            $this->created_at,
            $this->url,
            $this->start_timestamp,
            $this->end_timestamp,
            $this->application_id,
            $this->details,
            $this->state,
            $this->emoji,
            $this->party_id,
            $this->party_size,
            $this->party_max_size,
            $this->large_image,
            $this->large_text,
            $this->small_image,
            $this->small_text,
            /*$this->join_secret,
            $this->spectate_secret,
            $this->match_secret,*/
            $this->instance,
            $this->flags
        ] = $data;
    }
}