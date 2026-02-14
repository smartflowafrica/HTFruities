<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\ParfaitOption;
use Illuminate\Http\Request;

class ParfaitOptionController extends Controller
{
    /**
     * Show the Parfait Options CRUD page
     */
    public function index()
    {
        $bases = ParfaitOption::where('type', 'base')->orderBy('sort_order', 'asc')->get();
        $fruits = ParfaitOption::where('type', 'fruit')->orderBy('sort_order', 'asc')->get();
        $toppings = ParfaitOption::where('type', 'topping')->orderBy('sort_order', 'asc')->get();
        $drizzles = ParfaitOption::where('type', 'drizzle')->orderBy('sort_order', 'asc')->get();

        return view('backend.pages.appearance.parfait.index', compact('bases', 'fruits', 'toppings', 'drizzles'));
    }

    /**
     * Store a new option
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:base,fruit,topping,drizzle',
            'price' => 'nullable|numeric|min:0',
        ]);

        $option = new ParfaitOption();
        $option->name = $request->name;
        $option->type = $request->type;
        $option->price = $request->price ?? 0;
        $option->description = $request->description;
        $option->is_active = $request->has('is_active') ? 1 : 0;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/parfait', 'public');
            $option->image = $path;
        }
        
        $option->save();
        
        flash(localize('Option added successfully'))->success();
        return back();
    }

    /**
     * Update an option
     */
    public function update(Request $request)
    {
        $option = ParfaitOption::findOrFail($request->id);
        
        $option->name = $request->name;
        $option->price = $request->price ?? 0;
        $option->description = $request->description;
        $option->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/parfait', 'public');
            $option->image = $path;
        }

        $option->save();

        flash(localize('Option updated successfully'))->success();
        return back();
    }

    /**
     * Delete an option
     */
    public function delete($id)
    {
        $option = ParfaitOption::findOrFail($id);
        $option->delete();
        
        flash(localize('Option deleted successfully'))->success();
        return back();
    }
}
