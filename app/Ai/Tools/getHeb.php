<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use App\Models\Heberg;
use Stringable;

class getHeb implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Permet de rechercher des hébergements. 
        Le client peut saisir une ville, un nom, un type d’hébergement ou un prix. 
        Le système retourne un ou plusieurs hébergements avec leurs détails';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        //
        $ville = $request['ville'] ?? null;
        $nom = $request['nom'] ?? null;
        $type = $request['type'] ?? null;
        $prixMax = $request['prix_max'] ?? null;
        $query=Heberg::query();
        if($ville){
            $query->where('addresse','Like',"%$ville%");
        }
        if($nom){
            $query->where('nomHeberg','Like',"%$nom%");
        }
        if($type){
            $query->where('typeHeberg',$type);
        }
        if($prixMax){
            $query->where('prix','<=',$prixMax);
        }

        $result=$query->get();
       // dd($result);
        return  $result ;
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array{
        return [
           'ville' => $schema->string()->nullable()->description('Nom de la ville'),
            'nom' => $schema->string()->nullable()->description('Nom de l’hébergement'),
            'type' => $schema->string()->nullable()->description('Type d’hébergement (hôtel, appartement, villa...)'),
            'prix_max' => $schema->number()->nullable()->description('Prix maximum'),
        ];
    }
}
