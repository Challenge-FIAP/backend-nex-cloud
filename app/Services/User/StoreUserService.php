<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;

class StoreUserService extends Message
{
    private Request $request;

    private User $user;
    private string $date;
    private string $uID;

    public function handle(Request $request): void
    {
        $this->request = $request;

        $this
            ->proceed();
    }

    private function proceed(): void
    {
        $this
            ->setDate();

        // Early return
        if (!$this->status) {
            return;
        }

        $this
            ->makeUid()
            ->persistUser();
    }

    private function setDate(): void
    {
        $apiDate = $this->request->date;

        if (!$apiDate) {
            $this->status = false;
            return;
        }

        $this->date = $apiDate;
    }

    private function makeUid(): StoreUserService
    {
        $uID = substr(md5(rand(1, 1000000000)), 0, 10);
        $uID .= '-';
        $uID .= substr(md5(rand(1, 1000000000)), 0, 10);
        $uID .= '-';
        $uID .= substr(md5(rand(1, 1000000000)), 0, 10);

        $this->uID = $uID;

        return $this;
    }

    private function persistUser(): StoreUserService
    {
        $this->user = User::create([
            'uid'                   => $this->uID,
            'date_accept_terms'     => $this->date,
        ]);
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
