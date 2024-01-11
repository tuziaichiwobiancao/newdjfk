<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Prime;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PrimeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Prime(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('uid');
            $grid->column('order');
            $grid->column('username');
            $grid->column('month');
            $grid->column('status');
            $grid->column('addtime');
        
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
        return Show::make($id, new Prime(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('order');
            $show->field('username');
            $show->field('month');
            $show->field('status');
            $show->field('addtime');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Prime(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('order');
            $form->text('username');
            $form->text('month');
            $form->text('status');
            $form->text('addtime');
        });
    }
}
