<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ManageMenu;
use App\Models\Page;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    public function manageMenu()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        $data['pages'] = Page::with(['details' => function ($query) use ($defaultLanguage) {
            $query->where('language_id', $defaultLanguage->id);
        }])->get();
        $data['headerMenus'] = ManageMenu::where('menu_section', 'header')->firstOrFail();
        $data['footerMenus'] = ManageMenu::where('menu_section', 'footer')->firstOrFail();
        return view('admin.frontend_management.manage-menu', $data);
    }

    public function headerMenuItemStore(Request $request)
    {
        $request->validate([
            'menu_item' => 'nullable|array',
        ]);

        try {
            $menu = ManageMenu::where('menu_section', 'header')->firstOrFail();

            $response = $menu->update([
                'menu_items' => $request->menu_item
            ]);

            if (!$response) {
                throw new \Exception('Something went something, Please try again');
            }
            return back()->with('success', 'Header menu saved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function footerMenuItemStore(Request $request)
    {
        $request->validate([
            'menu_item' => 'nullable|array',
        ]);
        try {
            $menu = ManageMenu::where('menu_section', 'footer')->firstOrFail();

            $response = $menu->update([
                'menu_items' => $request->menu_item
            ]);

            if (!$response) {
                throw new \Exception('Something went something, Please try again');
            }
            return back()->with('success', 'Footer menu saved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
