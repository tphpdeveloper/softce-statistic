<?php

namespace Softce\Statistic\Http\Controllers;

use Illuminate\Http\Request;
use Mage2\Ecommerce\Models\Database\Product;
use Mage2\Ecommerce\Models\Database\StatisticAddByProduct;
use Mage2\Ecommerce\Models\Database\Visitor;
use Mage2\Ecommerce\DataGrid\Facade as DataGrid;
use DB;
use Session;

class StatisticController extends AdminController
{
    public function show(Request $request)
    {

        dd(Session::getId() );

        $visitors = Visitor::where('url', 'LIKE', 'product/%')
            ->groupBy([ 'create', 'slug' ])
            ->select(DB::raw('SUBSTR(url, LENGTH("product/") + 1) AS slug'), DB::raw('DATE(`created_at`) AS `create`'), DB::raw('COUNT(url) as visited'))
            ->orderBy('create' , 'DESC')
            ->get();


        $added_bayeds = StatisticAddByProduct::select('slug', DB::raw('SUM(added) as added'), DB::raw('SUM(bayed) as bayed'), DB::raw('DATE(`created_at`) AS `create`'))
            ->groupBy([ 'create', 'slug' ])
            ->orderBy('create', 'DESC')
            ->get();

        //merged 2 models in 1
        $new_collect = collect([]);
        $results = $new_collect->merge($visitors->all())->merge($added_bayeds->all());

        //sorted data from now date to previous
        $sorted = $results->sortByDesc(function ($product, $key) {
            return $product['create'];
        });

        //get slug product
        $slug = $sorted->mapWithKeys(function ($item) {
            return [$item['slug'] => $item];
        });
        $products = Product::whereIn( 'slug', array_keys($slug->all()) )->get();


        $new_structure = [];
        foreach($sorted as $item){

            if($item->visited) {
                $new_structure[$item->create][$item->slug]['visited'] = $item->visited;
            }
            if($item->added) {
                $new_structure[$item->create][$item->slug]['added'] = $item->added;
            }
            if($item->bayed) {
                $new_structure[$item->create][$item->slug]['bayed'] = $item->bayed;
            }
            $new_structure[$item->create][$item->slug]['create'] = $item->create;
            $new_structure[$item->create][$item->slug]['slug'] = $item->slug;

        }





        $dataGrid = DataGrid::model( collect($new_structure) )
            ->linkColumn('', ['label' => 'id'], function ($model) {

            })

            ->column('id', ['sortable' => true])
            ->linkColumn('image', ['label' => 'Изображение'], function ($model) {
                return '<img class="product_list_image" src="' . $model->image->smallUrl . '" alt="' . $model->name . '" />';
            })
            ->column('name', ['label' => 'Имя'])
            ->linkColumn('category', ['label' => 'Категория'], function ($model) {
                if (count($category = $model->categories)) {
                    return $category->first()->name;
                }
            })
            ->linkColumn('o', ['label' => 'Порядок отображения'], function ($model) {
                return '<input type="number" min="0" step="1" class="js_change_order" name="o" value="' . $model->o . '" data-product_id="' . $model->id . '" style="width: 50px;"/>';
            });


        return view('mage2-ecommerce::admin.product.index')->with('dataGrid', $dataGrid);
    }
}
