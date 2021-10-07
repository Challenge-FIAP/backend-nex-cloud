<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserService
{
    private string $uid;
    private Request $request;

    private User $user;

    private bool $status;
    private string $message;

    public function __construct()
    {
        $this->status = true;
    }

    public function handle(Request $request, string $uid)
    {
        $this->request = $request;
        $this->uid = $uid;

        $this
            ->proceed();
    }


    private function proceed(): void
    {
        $this
            ->setUser();

        if (!$this->status) {
            return;
        }

        $this
            ->updateUserData();
    }

    private function setUser(): void
    {
        $user = User::firstWhere('uid', $this->uid);

        if (is_null($user)) {
            $this->status = false;
            $this->message = "Usuário tá inválido, cara, arruma esse UID aí, pô";

            return;
        }

        $this->user = $user;
    }

    private function updateUserData(): void
    {
        $this->user->social_name = $this->request->social_name ?? null;
        $this->user->phone = $this->request->phone ?? null;
        $this->user->document = $this->request->document ?? null;

        $this->user->save();
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
