<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Process;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class InspectLaravelApp implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Inspect the Laravel application and return useful information about its environment, routes, packages, and framework configuration.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $action = $request['action'];

        return match ($action) {
            'about' => $this->about(),
            'routes' => $this->routes(),
            'packages' => $this->packages(),
            'default' => 'Unknown action',
        };
    }

    public function about(): string
    {
        return Process::run('php artisan about')->output();
    }

    public function packages(): string
    {
        return Process::run('composer show --direct')->output();
    }

    public function routes(): string
    {
        return Process::run('php artisan route:list --except-vendor')->output();
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'action' => $schema->string()->enum(['about', 'routes', 'packages'])->required(),
        ];
    }
}
