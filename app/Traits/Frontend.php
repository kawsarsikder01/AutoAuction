<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\ContentDetails;
use App\Models\Vehicle;
use Carbon\Carbon;

trait Frontend
{
    protected function getSectionsData($sections, $content, $selectedTheme)
    {
        $contentData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($sections) {
                $query->whereIn('name', $sections);
            })
            ->get();

        foreach ($sections as $section) {
            $singleContent = $contentData->where('content.name', $section)->where('content.type', 'single')->first() ?? [];
            if ($section == 'blog') {
                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' =>Blog::with('details')->where('status',1)->latest()->limit(3)->get()
                ];
            }elseif($section == 'featured_inventory'){
                $todayDate = Carbon::now()->toDateString();
                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' =>Vehicle::with('user','details','biddingHistory','plan')
                        ->whereHas('details', function ($query) use ($todayDate) {
                            $query->whereDate('auction_ending_date', '>', $todayDate)->where('sold_status',0);
                        })
                        ->whereHas('plan',function($query){
                            $query->where('promoted_listing',1);
                        })
                        ->where('status',1)
                        ->latest()
                        ->inRandomOrder()
                        ->get()
                ];
            }else {
                $multipleContents = $contentData->where('content.name', $section)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                    return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
                });

                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' => $multipleContents
                ];
            }

            $replacement = view("themes.light.sections.{$section}", $data)->toHtml();

            $content = str_replace('<div class="custom-block" contenteditable="false"><div class="custom-block-content">[[' . $section . ']]</div>', $replacement, $content);
            $content = str_replace('<span class="delete-block">×</span>', '', $content);
            $content = str_replace('<span class="up-block">↑</span>', '', $content);
            $content = str_replace('<span class="down-block">↓</span></div>', '', $content);
            $content = str_replace('<p><br></p>', '', $content);
        }

        return $content;
    }
}
