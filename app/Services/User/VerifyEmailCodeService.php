<?php

namespace App\Services\User;

use App\Models\EmailConfirmation;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailCodeService extends Message
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
            ->verifyCode();


        if (!$this->status()) {
            return;
        }

        $this
            ->updateEmailConfirmation();
    }

    private function setUser(): VerifyEmailCodeService
    {
        $this
            ->user = User::firstWhere('uid', $this->uid);

        return $this;
    }

    private function verifyCode()
    {
        $verificationCode = EmailConfirmation::firstWhere('user_id', $this->user->id);

        if ($this->request->code !== $verificationCode->code) {
            $this->setError('Código inválido');
            return;
        }

        $this->confirmation = $verificationCode;
    }

    private function updateEmailConfirmation()
    {
        $this->confirmation->valid = true;
        $this->confirmation->save();
    }

    public function getUser()
    {
        return $this->user;
    }
}
