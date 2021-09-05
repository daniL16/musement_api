<?php

declare(strict_types=1);

namespace App\Model;

use Exception;

abstract class Command
{
    protected array $payload = [];

    /**
     * Create a command object from a payload.
     */
    abstract public function fromPayload(array $payload): self;

    /**
     * Check if payload has correct data.
     *
     * @throws Exception
     */
    abstract public function assertIsValidPayload(array $payload);
}
