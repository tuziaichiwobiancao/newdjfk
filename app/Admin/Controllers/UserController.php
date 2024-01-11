<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('uid')->sortable();
            $grid->column('uname');
            $grid->column('nick');
            $grid->column('money');
            $grid->column('points');
            $grid->column('upid');
            $grid->column('addtime');
            $grid->column('updatetime');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('uid');
        
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('uid');
            $show->field('uname');
            $show->field('nick');
            $show->field('money');
            $show->field('points');
            $show->field('upid');
            $show->field('addtime');
            $show->field('updatetime');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {
            $form->display('uid');
            $form->text('uname');
            $form->text('nick');
            $form->text('money');
            $form->text('points');
            $form->text('upid');
            $form->text('addtime');
            $form->text('updatetime');
        });
    }
}
