<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\ListWord;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $flashcards = Flashcard::with('wordList')->paginate(10);

        return view('flashcard.index', [
            'flashcards' => $flashcards
        ]);
    }
    public function showByList($list_id)
    {
        $flashcards = Flashcard::where('list_id', $list_id)->paginate(10);
        $list_word = ListWord::findOrFail($list_id);
        return view(
            'flashcard.index',
            [
                'flashcards' => $flashcards,
                'list_word' => $list_word
            ]
        );
    }
    public function detail(string $id)
    {
        $flashcard = Flashcard::find($id);
        return view('flashcard.detail', ['flashcard' => $flashcard]);
    }
    public function edit(Request $request, string $id)
    {
        $request->validate([
            'word' => 'required',
            'definition' => 'required',
            'word_type' => 'required',
        ]);
        $flashcard = Flashcard::findOrFail($id);
        $flashcard->word = $request->input('word');
        $flashcard->definition = $request->input('definition');
        $flashcard->word_type = $request->input('word_type');
        $flashcard->pronunciation = $request->input('pronunciaton');
        $flashcard->example = $request->input('example');
        $flashcard->save();
        return redirect()->route('index', ['list_id' => $flashcard->list_id])->with('success', value: 'Cập nhật listword thành công!');
    }
    public function show(string $id)
    {
        $flashcard = Flashcard::find($id);
        return view('flashcard.edit', ['flashcard' => $flashcard]);
    }

    public function delete($id)
    {
        $flashcard = Flashcard::find($id);
        $flashcard->delete();
        return redirect()->route('index', ['list_id' => $flashcard->list_id])->with('success', value: 'Xoá flashcard thành công!');
    }
    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $list_id = $request->input('list_id');
        $flashcards = Flashcard::where('list_id', $list_id)
            ->whereRaw("(word LIKE ? OR definition LIKE ?)", ["%$keyword%", "%$keyword%"])
            ->paginate(10)
            ->appends(['search' => $keyword, 'list_id' => $list_id]);
        $list_word = ListWord::findOrFail($list_id);
        return view('flashcard.index', [
            'flashcards' => $flashcards,
            'list_word' => $list_word
        ]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'word' => 'required',
            'definition' => 'required',
            'word_type' => 'required',
        ]);
        $flashcard = Flashcard::create([
            'word' => $request->input('word'),
            'definition' => $request->input('definition'),
            'pronunciation' => $request->input('pronunciation'),
            'word_type' => $request->input('word_type'),
            'list_id' => $request->input('id_list'),
            'example' => $request->input('example')
        ]);
        return redirect()->route('index', ['list_id' => $flashcard->list_id])->with('success', value: 'Thêm flashcard thành công!');
    }
    public function adds(Request $request){
        $words = $request->input('word');
        $definitions = $request->input('definition');
        $pronunciations = $request->input('pronunciation');
        $word_types = $request->input('word_type');
        $list_id = $request->input('id_list_words');
        $examples1 = $request->input('example1');
        $examples2 = $request->input('example2');
    
        $count = count($words);
        $created = 0;
        $errors = [];
    
        for ($i = 0; $i < $count; $i++) {
            // Kiểm tra nếu hàng có ít nhất 1 dữ liệu được nhập
            $hasInput = !empty($words[$i]) || !empty($definitions[$i]) || !empty($pronunciations[$i]) || !empty($word_types[$i]) || !empty($examples1[$i]) || !empty($examples2[$i]);
            if ($hasInput) {
                if (empty($words[$i]) || empty($definitions[$i])) {
                    $errors[] = "Dòng " . ($i + 1) . " thiếu 'Word' hoặc 'Definition'";
                } else {
                    Flashcard::create([
                        'word' => $words[$i],
                        'definition' => $definitions[$i],
                        'word_type' => $word_types[$i],
                        'pronunciation' => $pronunciations[$i] ?? null,
                        'example' => trim(($examples1[$i] ?? '') . "\n" . ($examples2[$i] ?? '')),
                        'list_id' => $list_id,
                    ]);
                    $created++;
                }
            }
        }
    
        if (!empty($errors)) {
            return back()->with('modal_error', implode('<br>', $errors))->withInput();    
        }
    
        if ($created > 0) {
            return redirect()->route('index', ['list_id' => $list_id])->with('success', 'Thêm flashcard thành công!');
        } else {
            return back()->with('modal_error', 'Vui lòng nhập ít nhất một từ hợp lệ!')->withInput();        }
    }
}
