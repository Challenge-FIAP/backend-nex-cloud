<?php

namespace App\Services\User;

abstract class Message
{
    protected bool $status = true;
    protected string $message;

    protected function setError(string $message): void
    {
        $this->status = false;
        $this->message = $message;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
