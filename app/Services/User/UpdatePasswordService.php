<?php

namespace App\Services\User;

use App\Models\EmailConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordService extends Message
{
    private Request $request;
    private string $uid;

    private User $user;
    private EmailConfirmation $confirmation;

    public function handle(
        Request $request,
        string $id
    ): void {
        $this
            ->request = $request;

        $this
            ->uid = $id;


        $this->proceed();
    }

    private function proceed(): void
    {
        $this
            ->setUser()
            ->savePassword();
    }

    private function setUser()
    {
        $this
            ->user = User::firstWhere('uid', $this->uid);

        return $this;
    }

    private function savePassword()
    {
        $this->user->password = Hash::make($this->request->password);
        $this->user->save();
    }

    public function getUser()
    {
        return $this->user;
    }
}
