<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use App\Models\Heberg;
use Stringable;

class getHebByVille implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return "Récupère les informations d’un hébergement à partir de son ville. 
    Utilisez cet outil lorsque l'utilisateur fournit le ville d’un hébergement 
    et souhaite obtenir ses détails (prix, description, localisation, etc.).";
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        //
        $villeheb=$request['ville'];
        $hebergement=Heberg::where('addresse','like',"%$villeheb%")->first();
        if (!$hebergement) {
            return "Aucun hébergement trouvé dans cette ville";
        }
       

        return "
            Nom: {$hebergement->nomHeberg}
            type: {$hebergement->typeHeberg}
            Prix: {$hebergement->prix}
            Description: {$hebergement->Description}
            services:{$hebergement->service}
            nombre totale de chambre actuelle :{$hebergement->nombre_chambre}
            addresse :{$hebergement->addresse}
        ";

    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'ville'=>$schema->string()->required(),

        ];
    }
}
