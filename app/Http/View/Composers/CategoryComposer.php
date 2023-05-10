<?php
 
namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Admin\Aisle;
use App\Models\Admin\Category;

class CategoryComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('aisles', Aisle::all());
        $view->with('categories', Category::all());
    }
}