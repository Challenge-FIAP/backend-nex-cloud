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
use Illuminate\Http\JsonResponse;
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
                206
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
                206
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
                206
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
                206
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
                206
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

    public function destroy($id): JsonResponse
    {
        $user = User::firstWhere('uid', $id);

        if (is_null($user)) {
            return response()->json([
                'status' => 400,
                'message'   => 'Usuário ' . $id . ' não encontrado.'
            ], 206);
        }

        $user->delete();

        return response()->json([
            'status' => 200,
            'message'   => 'User ' . $id . ' deletado com sucesso.'
        ]);
    }
}
