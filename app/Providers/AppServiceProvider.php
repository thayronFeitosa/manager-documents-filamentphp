<?php

namespace App\Providers;

use App\Services\TypeDocument\TypeDocument;
use App\Services\TypeDocument\TypeDocumentInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        TypeDocumentInterface::class => TypeDocument::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
