<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Recharge;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class RechargeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Recharge(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('uid');
            $grid->column('orderno');
            $grid->column('money');
            $grid->column('sign');
            $grid->column('status');
            $grid->column('addtime');
            $grid->column('paytime');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Recharge(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('orderno');
            $show->field('money');
            $show->field('sign');
            $show->field('status');
            $show->field('addtime');
            $show->field('paytime');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Recharge(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('orderno');
            $form->text('money');
            $form->text('sign');
            $form->text('status');
            $form->text('addtime');
            $form->text('paytime');
        });
    }
}
