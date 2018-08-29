<?php
namespace Softce\Statistic;

use Illuminate\Support\ServiceProvider;
use DB;
use Softce\Statistic\Http\Middleware\Statistic;

class StatisticServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerMiddleware();
        $this->registerResources();
    }

    public function register(){
        //
    }


    protected function registerMiddleware()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('statistic', Statistic::class);

    }

    protected function registerResources()
    {

        $this->loadRoutesFrom(dirname(__DIR__).'/src/routes/web.php');
        $this->loadViewsFrom(dirname(__DIR__) . '/src/views', 'statistic');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/src/database/migrations');

        $statistic = DB::table('admin_menus')->where('name', 'Статистика товаров')->first();
        if(is_null($statistic)){
            DB::table('admin_menus')->insert([
                'admin_menu_id' => 1,
                'name' => 'Статистика товаров',
                'icon' => 'fa-bar-chart',
                'route' => 'admin.statistic',
                'o' => 0
            ]);
        }
    }

}