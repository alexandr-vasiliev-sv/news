<?php

namespace App\Http\Controllers;

use App\Entities\News;
use App\Repositories\ {
    CategoryRepository, NewsRepository, TagRepository, Criteria\SearchNewsByTags
};
use Illuminate\Http\Request;
use DB;

class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    public function __construct(
        NewsRepository $newsRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        $this->newsRepository = $newsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @var Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $newsCollection = $this->newsRepository
            ->with(['user', 'category', 'tags'])
            ->pushCriteria(new SearchNewsByTags($request->get('tag')))
            ->paginate();

        $tags = $this->tagRepository->all(['id', 'name']);

        return view('news.index', [
            'newsCollection' => $newsCollection,
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all(['id', 'name']);

        $tags = $this->tagRepository->all(['id', 'name']);

        return view('news.create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
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
            'title' => 'required|unique:news',
            'text' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $newsData = $request->only('title', 'text', 'category_id');
        $newsData['user_id'] = $request->user()->id;

        DB::beginTransaction();
        try {
            $news = $this->newsRepository->create($newsData);
            $this->addTagsToNews($news, $request->get('tags', []), $request->get('new_tags'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->with(['comments.user', 'tags'])->find($id);

        if ($news === null) {
            return redirect()->route('news.index');
        }

        $comments = $news->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('news.show', [
            'news' => $news,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = $this->newsRepository->find($id);

        if ($news === null) {
            return redirect()->route('news.index');
        }

        $this->authorize('update', $news);

        $newsTags = $news->tags()->pluck('name', 'id');
        $categories = $this->categoryRepository->all();
        $tags = $this->tagRepository->all(['id', 'name']);

        return view('news.edit', [
            'news' => $news,
            'categories' => $categories,
            'tags' => $tags,
            'newsTags' => $newsTags,
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
        $news = $this->newsRepository->find($id);

        if ($news === null) {
            return redirect()->route('news.index');
        }

        $this->authorize('update', $news);

        DB::beginTransaction();
        try {
            $this->newsRepository->update($request->only('title', 'text'), $news->id);
            $this->addTagsToNews($news, $request->get('tags', []), $request->get('new_tags'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('news.show', $news->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = $this->newsRepository->find($id);

        if ($news === null) {
            return redirect()->route('news.index');
        }

        $this->authorize('delete', $news);

        \DB::transaction(function () use ($news) {
            $news->comments()->delete();
            $news->tags()->sync([]);
            $news->delete();
        });

        return redirect()->route('news.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addComment(Request $request, $id)
    {
        $this->validate($request, [
            'text' => 'required'
        ]);
        $news = $this->newsRepository->find($id);

        if ($news === null) {
            return redirect()->route('news.index');
        }

        $news->comments()->create([
            'text' => $request->get('text'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back();
    }

    /**
     * @param News $news
     * @param array $tags
     * @param null $newTagsString
     */
    protected function addTagsToNews(News $news, array $tags, $newTagsString = null)
    {
        $news->tags()->sync($tags);
        if ($newTagsString !== null) {
            $tags = array_unique(explode(';', $newTagsString));
            foreach ($tags as $tag) { // add new tags
                if ($tag) {
                    $news->tags()->create(['name' => $tag]); // if user typed existing tag as a new, we skip it for now
                }
            }
        }
    }
}
