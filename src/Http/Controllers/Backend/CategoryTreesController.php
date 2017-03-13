<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Motor\Backend\Models\Category;
use Motor\Backend\Http\Requests\Backend\CategoryTreeRequest;
use Motor\Backend\Services\CategoryService;
use Motor\Backend\Grids\CategoryTreeGrid;
use Motor\Backend\Forms\Backend\CategoryTreeForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Core\Filter\Renderers\WhereRenderer;

class CategoryTreesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new CategoryTreeGrid(Category::class);

        $service = CategoryService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('parent_id'))->setDefaultValue(null)->setAllowNull(true);

        $grid->filter = $filter;
        $paginator    = $service->getPaginator();

        return view('motor-backend::backend.category_trees.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(CategoryTreeForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.category_trees.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('motor-backend::backend.category_trees.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryTreeRequest $request)
    {
        $form = $this->form(CategoryTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        CategoryService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/category_trees.created'));

        return redirect('backend/category_trees');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $record)
    {
        $form = $this->form(CategoryTreeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.category_trees.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('motor-backend::backend.category_trees.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryTreeRequest $request, Category $record)
    {
        $form = $this->form(CategoryTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        CategoryService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/category_trees.updated'));

        return redirect('backend/category_trees');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $record)
    {
        CategoryService::delete($record);

        flash()->success(trans('motor-backend::backend/category_trees.deleted'));

        return redirect('backend/category_trees');
    }
}