<?php

namespace App\Services\TypeDocument;

use App\Models\TypeDocument;

interface TypeDocumentInterface
{
    public function exists(string $name, int $userId): bool;
    public function isUpdate(string $name, int $userId, int $idTypeDocument): bool;

}
