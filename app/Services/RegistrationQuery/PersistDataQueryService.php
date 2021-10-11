<?php

namespace App\Services\RegistrationQuery;

use App\Models\Address;
use App\Models\Credit;
use App\Models\User;
use stdClass;

class PersistDataQueryService
{
    private User $user;

    private stdClass $responseData;
    private Address $address;
    private Credit $credit;

    public function handle(User $user): void
    {
        $this
            ->user = $user;

        $this
            ->proceed();
    }

    private function proceed()
    {
        $this
            ->makeRequest()
            ->makeAdress()
            ->makeScore()
            ->setDataOnUser()
            ->persist();
    }

    private function makeRequest(): PersistDataQueryService
    {
        $this
            ->responseData = new stdClass();

        // Registration
        $this->responseData->name = "Tedoixa Tedoixa Heas";
        $this->responseData->birth_date = "2021-10-6";
        $this->responseData->mother_name = "Luigi Houko Heas";
        $this->responseData->marital_status = "Casado";
        $this->responseData->education_level = "Não Informado";

        // Address
        $this->responseData->publicPlace = "R. José Rabello Leite";
        $this->responseData->number = "20";
        $this->responseData->complement = null;
        $this->responseData->district = "Santa Rosa";
        $this->responseData->city = "Cuiaba";
        $this->responseData->state = "MT";
        $this->responseData->zipCode = "78040265";

        // Credit
        $this->responseData->numeric_score = "99";
        $this->responseData->alphabetical_score = "E";
        $this->responseData->presumed_income = "DE R$ 3.001 ATE 4.000";

        return $this;
    }

    private function makeAdress(): PersistDataQueryService
    {
        $this->address = Address::create([
            'publicPlace'           => $this->responseData->publicPlace ?? null,
            'number'                => $this->responseData->number ?? null,
            'complement'            => $this->responseData->complement ?? null,
            'district'              => $this->responseData->district ?? null,
            'city'                  => $this->responseData->city ?? null,
            'state'                 => $this->responseData->state ?? null,
            'zipCode'               => $this->responseData->zipCode ?? null
        ]);

        return $this;
    }

    private function makeScore(): PersistDataQueryService
    {
        $this->credit = Credit::create([
            'numeric_score'         => $this->responseData->numeric_score ?? null,
            'alphabetical_score'    => $this->responseData->alphabetical_score ?? null,
            'presumed_income'       => $this->responseData->presumed_income ?? null
        ]);

        return $this;
    }

    private function setDataOnUser(): PersistDataQueryService
    {
        $this->user->name = $this->responseData->name;
        $this->user->birth_date = $this->responseData->birth_date;
        $this->user->mother_name = $this->responseData->mother_name;
        $this->user->marital_status = $this->responseData->marital_status;
        $this->user->education_level = $this->responseData->education_level;

        $this->user->credit_id = $this->credit->id;
        $this->user->address_id = $this->address->id;

        return $this;
    }

    private function persist(): void
    {
        $this
            ->user
            ->save();
    }
}



