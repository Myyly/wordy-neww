<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\ListWord;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListWordController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // if($user->id )
        $list_words = ListWord::where('user_id', $user->id)
            ->withCount('flashcards')
            ->paginate(14);

        return view('listword.index', [
            'list_words' => $list_words
        ]);
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'title' => 'required'
        ]);
        $list_word = ListWord::create([
            'title' => $request->input('title'),
            'language' => 'ENG',
            'description' => $request->input('description'),
            'user_id' => $user->id
        ]);
        return redirect()->route(route: 'list-word')->with('success', 'Thêm lisst word thành công!');
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $list_word = ListWord::findOrFail($id);
        $list_word->title = $request->input('title');
        $list_word->description = $request->input('description');
        $list_word->save();
        return redirect()->route('index', ['list_id' => $id])->with('success', value: 'Cập nhật listword thành công!');
    }

    public function delete(Request $request)
    {

        $listWord = ListWord::find($request->input('list_id'));
        $listWord->delete();
        return redirect()->route(route: 'list-word')->with('success', 'Xoá list word word thành công!');
    }
    public function search_list(Request $request)
    {
        $keyword = $request->input('search');
        $list_words = ListWord::where('title', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->paginate(14);
        return view('listword.index', ['list_words' => $list_words]);
    }
    public function practice_index()
    {
        $flashcards = new LengthAwarePaginator(
            new Collection(), // Danh sách flashcards rỗng
            0, // Tổng số flashcards
            10 // Số flashcards mỗi trang
        );
        return view('practice.index', [
            'flashcards' => $flashcards
        ]);
    }
    public function search_all(Request $request)
    {
        $keyword = $request->input('search');
        $flashcards = Flashcard::where('word', 'LIKE', "%$keyword%")
            ->orWhere('definition', 'LIKE', "%$keyword%")
            ->paginate(10)
            ->appends(['search' => $keyword]);
        return view('practice.index', [
            'flashcards' => $flashcards
        ]);
    }
}
