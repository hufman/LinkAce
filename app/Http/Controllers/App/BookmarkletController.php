<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\LinkList;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BookmarkletController extends Controller
{
    // Show the link creation form based on the information provided by the Bookmarklet.
    public function getLinkAddForm(Request $request)
    {
        $newUrl = $request->input('u');
        $newTitle = $request->input('t');
        $newDescription = $request->input('d');
        $newTags = $request->input('tags');
        $newLists = $request->input('lists');

        // Redirect to the login if the user is not logged in
        if (!auth()->check()) {
            // Save details for the link in the session
            session(['bookmarklet.new_url' => $newUrl]);
            session(['bookmarklet.new_title' => $newTitle]);
            session(['bookmarklet.new_description' => $newDescription]);
            session(['bookmarklet.new_tags' => $newTags]);
            session(['bookmarklet.new_lists' => $newLists]);
            session(['bookmarklet.login_redirect' => true]);

            return redirect()->route('bookmarklet-login');
        }

        session(['bookmarklet.create' => true]);

        return view('app.bookmarklet.create', [
            'existing_link' => Link::withTrashed()->whereUrl($newUrl)->first() ?: false,
            'bookmark_url' => $newUrl,
            'bookmark_title' => $newTitle,
            'bookmark_description' => $newDescription,
            'bookmark_tags' => $this->prepareTaxonomyEntries($newTags),
            'bookmark_lists' => $this->prepareTaxonomyEntries($newLists),
            'all_tags' => Tag::visibleForUser()->get(['name', 'id']),
            'all_lists' => LinkList::visibleForUser()->get(['name', 'id']),
        ]);
    }

    // Display the confirmation screen after adding a new link.
    public function getCompleteView(): View
    {
        return view('app.bookmarklet.complete');
    }

    // Return a special version of the login form made for the Bookmarklet.
    public function getLoginForm(): View
    {
        return view('app.bookmarklet.login');
    }

    protected function prepareTaxonomyEntries(?string $items): array
    {
        if ($items) {
            $items = array_map(function ($item) {
                return [
                    'id' => $item,
                    'name' => $item,
                ];
            }, explode(',', $items));
        }

        return Arr::wrap($items);
    }
}
