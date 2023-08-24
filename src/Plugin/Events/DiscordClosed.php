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

/**
 * DiscordBot has disconnected, and we are no longer in contact with discord.
 * @see DiscordConnected Emitted when DiscordBot connects.
 */
final class DiscordClosed extends DiscordBotEvent{}