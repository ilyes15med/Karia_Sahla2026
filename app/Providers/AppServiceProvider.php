<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   
    public function boot()
    {
    View::composer('*', function ($view) {

        $nombre_Heb_enCours = DB::table('Hebergs')
            ->where('status', 'en cours')
            ->count();

        $nombre_Heb_valide = DB::table('Hebergs')
            ->where('status', 'valide')
            ->count();

        $nombre_Heb_refuse = DB::table('Hebergs')
            ->where('status', 'refuse')
            ->count();

        $view->with([
            'nombre_Heb_enCours' => $nombre_Heb_enCours,
            'nombre_Heb_valide' => $nombre_Heb_valide,
            'nombre_Heb_refuse' => $nombre_Heb_refuse,
        ]);
    });
}
}
