<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\StoreUserService;
use App\Services\User\UpdateDocumentAndNameService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $user = User::paginate(15);
        return UserResource::collection($user);
    }

    public function store(
        Request $request,
        StoreUserService $service
    ): UserResource | Response | Application | ResponseFactory {
        $service
            ->handle($request);

        if (!$service->status()) {
            return response(null, 400);
        }

        return new UserResource($service->getUser());
    }

    public function show($id): UserResource | JsonResponse
    {
        $usuario = User::firstWhere('uid', $id);
        if (is_null($usuario)) {
            return response()->json(
                [
                    'code'      => 400,
                    'message'   => 'Usuário inválido',
                ],
                400
            );
        }

        return new UserResource(
            $usuario,
            $usuario->document
        );
    }

    public function updateDocumentAndName(
        Request $request,
        string $id,
        UpdateDocumentAndNameService $service
    ): UserResource | JsonResponse {
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

        return new UserResource(
            $service->getUser()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
