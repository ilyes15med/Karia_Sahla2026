<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class getHebByType implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return "Récupère les informations de tous hébergement à partir de son type. 
        Utilisez cet outil lorsque l'utilisateur fournit le type d’un hébergement 
        et souhaite obtenir ses détails (prix, description, localisation, etc.).";
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        //
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'value' => $schema->string()->required(),
        ];
    }
}
