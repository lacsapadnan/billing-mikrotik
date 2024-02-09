<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function edit(string $title)
    {
        $page = Page::whereTitle($title)->first();

        return view('admin.page.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
        $page->update(['content' => $validated['content']]);

        return redirect()->back()->with('success', 'Content updated');
    }
}
