<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Message;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MessageController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Message(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('message');
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
        return Show::make($id, new Message(), function (Show $show) {
            $show->field('id');
            $show->field('message');
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
        return Form::make(new Message(), function (Form $form) {
            $form->display('id');
            $form->text('message');
            $form->text('addtime');
        });
    }
}
