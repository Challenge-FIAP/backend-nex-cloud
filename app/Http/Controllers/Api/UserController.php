<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\StoreUserService;
use App\Services\User\UpdateDocumentAndNameService;
use App\Services\User\UpdateEmailAndPhone;
use App\Services\User\UpdatePasswordService;
use App\Services\User\VerifyEmailCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $user = User::paginate(15);
        return UserResource::collection(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function store(
        Request $request,
        StoreUserService $service
    ) {
        $service
            ->handle($request);

        if (!$service->status()) {
            return response(null, 400);
        }

        $user = $service->getUser();

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function show($id)
    {
        $user = User::firstWhere('uid', $id);
        if (is_null($user)) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => 'Usuário inválido',
                ],
                400
            );
        }

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function updateDocumentAndName(
        Request $request,
        string $id,
        UpdateDocumentAndNameService $service
    ) {
        $service
            ->handle($request, $id);

        if (!$service->status()) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => $service->getMessage(),
                ],
                400
            );
        }

        $user = $service->getUser();

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function updateEmailAndPhone(
        Request $request,
        string $id,
        UpdateEmailAndPhone $service
    ) {
        $service
            ->handle($request, $id);

        if (!$service->status()) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => $service->getMessage(),
                ],
                400
            );
        }

        $user = $service->getUser();

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function verifyCode(
        Request $request,
        string $id,
        VerifyEmailCodeService $service
    ) {
        $service
            ->handle($request, $id);

        if (!$service->status()) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => $service->getMessage(),
                ],
                400
            );
        }

        $user = $service->getUser();

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }

    public function updatePassword(
        Request $request,
        string $id,
        UpdatePasswordService $service
    ) {
        $service
            ->handle($request, $id);

        if (!$service->status()) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => $service->getMessage(),
                ],
                400
            );
        }

        $user = $service->getUser();

        return new UserResource(
            $user,
            $user->document ?? null,
            $user->address ?? null,
            $user->credit ?? null,
            $user->phone ?? null
        );
    }
}
