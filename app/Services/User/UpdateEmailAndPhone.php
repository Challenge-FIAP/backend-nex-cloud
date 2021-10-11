<?php

namespace App\Services\User;

use App\Models\EmailConfirmation;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class UpdateEmailAndPhone extends Message
{
    private Request $request;
    private string $uid;

    private User $user;
    private Phone $phone;
    private EmailConfirmation $emailConfirmation;

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
            ->setUser();

        if (!$this->status()) {
            return;
        }

        $this
            ->valideAndSetEmail();


        if (!$this->status()) {
            return;
        }

        $this
            ->valideAndSetPhone();

        if (!$this->status()) {
            return;
        }

        $this
            ->persistUser()
            ->makeValidationCode()
            ->sendmail();
    }

    private function setUser(): void
    {
        $user = User::firstWhere('uid', $this->uid);

        if (is_null($user)) {
            $this->setError('Usuário tá inválido, cara, arruma esse UID aí, pô');
            return;
        }

        $this->user = $user;
    }

    private function valideAndSetEmail(): void
    {
        $email = $this->request->email;

        if (is_null($email)) {
            $this->setError('E-mail não informado');
            return;
        }

        $this->user->email = $email;
    }

    private function valideAndSetPhone(): void
    {
        $phone = preg_replace('/[^0-9]/', '', $this->request->phone);

        $this->phone = Phone::create([
            'ddi'       => substr($phone, 0, 2),
            'ddd'       => substr($phone, 2, 2),
            'number'    => substr($phone, 4, 9),
        ]);
    }

    private function persistUser(): UpdateEmailAndPhone
    {
        $this->user->phone_id = $this->phone->id;
        $this->user->save();

        return $this;
    }

    private function makeValidationCode(): UpdateEmailAndPhone
    {
        $this->emailConfirmation = EmailConfirmation::create([
            'user_id'  => $this->user->id,
            //'code'  => substr(rand(1, 1000000000), 0, 5),
            'code'  => 12345
        ]);

        return $this;
    }

    private function sendMail(): void
    {
        //
    }

    public function getUser()
    {
        return $this->user;
    }
}
