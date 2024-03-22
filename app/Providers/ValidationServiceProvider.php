<?php

namespace App\Providers;

use App\Rules\ValidateTranslationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Validator::extend('translations', ValidateTranslationRule::class);
    }
}
