<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Newsletter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.newsletter');
    }

    /**
     * Подписка на новостную рассылку.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:newsletters|max:128',
        ]);

        $newsletter_id = DB::table('newsletters')->insertGetId([
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'newsletter_id' => $newsletter_id,
        ]);
    }
}
