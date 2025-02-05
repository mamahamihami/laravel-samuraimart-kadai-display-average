<?php

namespace App\Admin\Controllers;

use App\Models\ShoppingCart;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShoppingCartController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ShoppingCart';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShoppingCart());

        $grid->column('identifier', __('ID'))->sortable();
        $grid->column('instance', __('User ID'))->sortable();
        // カラムにtotalRow()付与で合計を表示できる
        $grid->column('price_total', __('Price total'))->totalRow();
        $grid->column('qty', __('Qty'))->totalRow();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        
        //  $filter->disableIdFilter()IDフィルターを使えない
        // カラムに対してフィルタリングの追加
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('identifier', 'ID');
            $filter->equal('instance', 'User ID');
            $filter->between('created_at', '登録日')->datetime();
        });

        // 新規作成不要　disableCreateButton()で操作できない　
        // 表示・編集・削除不要　actions()で操作できない
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }
}
