<?php

namespace App\Services\TypeDocument;

use App\Models\TypeDocument as ModelsTypeDocument;

class TypeDocument implements TypeDocumentInterface
{
    public function exists(string $name, int $userId): bool
    {
        return ModelsTypeDocument::where('name', $name)
            ->where('user_id', $userId)
            ->exists();
    }

    public function isUpdate(string $name, int $userId, int $idTypeDocument): bool
    {
        return ModelsTypeDocument::where('name', $name)
            ->where('user_id', $userId)
            ->where('id', '!=', $idTypeDocument)
            ->exists();
    }
}
