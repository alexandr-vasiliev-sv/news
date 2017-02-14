<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->with(['user'])->paginate();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $this->categoryRepository->create([
            'name' => $request->get('name'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        $this->authorize('update', $category);

        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id
        ]);
        $category = $this->categoryRepository->find($id);

        if ($category !== null) {
            $this->authorize('update', $category);

            $this->categoryRepository->update($request->only('name'), $id);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);

        if ($category !== null) {
            $this->authorize('update', $category);

            if ($category->news()->count() === 0) { // todo удалить проверку если другие требования
                $this->categoryRepository->delete($id);
            }
        }

        return redirect()->back();
    }
}
