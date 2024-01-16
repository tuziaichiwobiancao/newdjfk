<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Button;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ButtonController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Button(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('tips');
            $grid->column('keyword');
            $grid->column('func');
            $grid->column('content');
            $grid->column('parse');
            $grid->column('disable');
            $grid->column('button');
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
        return Show::make($id, new Button(), function (Show $show) {
            $show->field('id');
            $show->field('tips');
            $show->field('keyword');
            $show->field('func');
            $show->field('content');
            $show->field('parse');
            $show->field('disable');
            $show->field('button');
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
        return Form::make(new Button(), function (Form $form) {
            $form->display('id');
            $form->text('tips');
            $form->text('keyword');
            $form->text('func');
            $form->textarea('content');
            $form->text('parse');
            $form->text('disable');
            $form->textarea('button');
            $form->text('addtime');
        });
    }
}
