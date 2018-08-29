<?php
namespace Softce\Statistic;

use Illuminate\Support\ServiceProvider;
use DB;

class StatisticServiceProvider
{

    public function boot(){
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/web.php');
        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'promua');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');

        $promua = DB::table('admin_menus')->where('name', 'Prom UA')->first();
        if(is_null($promua)){
            DB::table('admin_menus')->insert([
                'admin_menu_id' => 3,
                'name' => 'Статистика',
                'icon' => 'fa-chart-bar',
                'route' => 'admin.statistic',
                'o' => 2
            ]);
        }
    }

    public function register(){
        //
    }

}