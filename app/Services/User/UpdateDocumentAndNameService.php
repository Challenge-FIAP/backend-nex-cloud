<?php

namespace App\Services\User;

use App\Helpers\ValidateDocument;
use App\Models\Document;
use App\Models\User;
use App\Services\RegistrationQuery\PersistDataQueryService;
use Illuminate\Http\Request;

class UpdateDocumentAndNameService
{
    // Dados enviados
    private string $uid;
    private Request $request;

    // Modelos
    private User $user;
    private Document $document;

    // Helpers
    private bool $status;
    private string $message;

    // Service
    private PersistDataQueryService $persistDataQueryService;

    public function __construct()
    {
        $this->status = true;
        $this->persistDataQueryService = new PersistDataQueryService();
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
            ->valideAndSetName();

        if (!$this->status) {
            return;
        }

        $this
            ->handleDocument();

        if (!$this->status) {
            return;
        }

        $this
            ->persistUser()
            ->persistOtherUserData();
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

    private function valideAndSetName(): void
    {
        $name = $this->request->social_name;

        if (is_null($name)) {
            $this->setError('Usuário não informado');
            return;
        }

        $this->user->social_name = $name;
    }

    private function handleDocument(): void
    {
        $validate = new ValidateDocument();
        $validadeResult = $validate->handle($this->request->document);

        if (!$validadeResult['is_valid']) {
            $this->setError('Documento inválido');
            return;
        }

        if (!is_null(Document::firstWhere('number', $validadeResult['number']))) {
            $this->setError('Documento já possui cadastro');
            return;
        }

        $this->document = Document::create([
            'number'          => $validadeResult['number'],
            'type_person'     => $validadeResult['type'],
        ]);
    }

    private function persistUser(): UpdateDocumentAndNameService
    {
        $this->user->document_id = $this->document->id;
        $this->user->save();

        return $this;
    }

    private function persistOtherUserData(): void
    {
        $this
            ->persistDataQueryService
            ->handle($this->user);
    }

    private function setError(string $message): void
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

    public function getUser(): User
    {
        return $this->user;
    }
}
