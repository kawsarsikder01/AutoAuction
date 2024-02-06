<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\Language;
use App\Models\PageDetail;
use App\Models\Page;
use App\Models\Vehicle;
use App\Models\VehicleDetails;
use App\Traits\Frontend;
use Illuminate\Http\Request;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Facades\App\Console\Commands\AuctionTimeCheck;

class FrontendController extends Controller
{
    use Frontend;

    public function page($slug = '/')
    {
        $selectedTheme = basicControl()->theme;
        $pageDetails = PageDetail::with('page')
            ->whereHas('page', function ($query) use ($slug, $selectedTheme) {
                $query->where(['slug' => $slug, 'template_name' => $selectedTheme]);
            })
            ->firstOrFail();
        $page = Page::where('slug', $slug)->first();
        $pageSeo = [
            'page_title' => optional($pageDetails->page)->page_title
        ];
        $sectionsData = $this->getSectionsData($pageDetails->sections, $pageDetails->content, $selectedTheme);


        return view("themes.{$selectedTheme}.page", compact('sectionsData', 'pageSeo', 'page', 'pageDetails'));
    }

    public function plan()
    {
        $pageSeo = Page::where('name', 'plan')->select('page_title', 'breadcrumb_image', 'breadcrumb_image_driver')->first();
        $plans = Plan::get();
        return view(template().'plans.plan', compact('plans', 'pageSeo'));
    }

    public function auction()
    {
        $pageSeo = Page::where('name', 'auction')->select('page_title', 'breadcrumb_image', 'breadcrumb_image_driver')->first();
        $todayDate = Carbon::now()->toDateString();

        $vehicles = Vehicle::with('user', 'details')
            ->whereHas('details', function ($query) use ($todayDate) {
                $query->whereDate('auction_ending_date', '> ', $todayDate)->where('sold_status', 0);
            })
            ->whereHas('user', function ($query) {
                $query->with(['plan' => function ($query) {
                    $query->orderBy('promoted_listing', 'DESC');
                }]);
            })
            ->where('status', 1)
            ->paginate(basicControl()->paginate);
        $data['maxAmount'] = VehicleDetails::get()->max('price');
        $data['minAmount'] = VehicleDetails::get()->min('price');
        $data['carBrand'] = CarBrand::where('status', 1)->get();
        $data['CarCategory'] = CarCategory::where('status', 1)->get();
        return view(template().'auction.auction', compact('vehicles', 'pageSeo'), $data);
    }

    public function blogs()
    {
        $pageSeo = Page::where('name', 'blog')->select('page_title', 'breadcrumb_image', 'breadcrumb_image_driver')->first();
        $blogs = Blog::with('category', 'details')->orderBy('id', 'desc')
            ->paginate(basicControl()->paginate);
        $categorys = BlogCategory::where('status', 1)->get();
        return view(template() . 'blog.blogs', compact('blogs', 'categorys', 'pageSeo'));
    }

    public function categoryBlogs($category, $id)
    {
        $pageSeo = Page::where('name', 'blog')->select('page_title', 'breadcrumb_image', 'breadcrumb_image_driver')->first();
        $blogs = Blog::with('category', 'details')->where('category_id', $id)->paginate(3);
        $categorys = BlogCategory::where('status', 1)->get();
        return view(template() . 'blog.blogs', compact('blogs', 'categorys', 'pageSeo'));
    }
}
