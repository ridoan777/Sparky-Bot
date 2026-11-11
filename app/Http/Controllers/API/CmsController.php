<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CMS;
use App\Models\Confidence;
use Illuminate\Http\Request;

class CmsController extends Controller
{


    public function getPageData($page, $section = null)
    {
        $cmsSections = CMS::where('page', $page)
            ->where('status', 'active')
            ->get()
            ->groupBy('section');

        if ($cmsSections->isEmpty()) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => ucfirst($page) . ' Page Data Not Found.',
                'data' => null
            ], 404);
        }

        $formatSection = function ($section, $items) {
            if ($section === 'process_section') {
                $data = [];
                $keys = ['process_one', 'process_two', 'process_three'];
                foreach ($items as $index => $item) {
                    $key = $keys[$index] ?? 'item_' . ($index + 1);
                    $data[$key] = $this->formatItem($item);
                }
                return $data;
            } elseif ($section === 'difference_section') {
                $data = [];
                foreach ($items as $index => $item) {
                    $key = 'item_' . ($index + 1);
                    $data[$key] = $this->formatItem($item);
                }
                return $data;
            } else {
                return $this->formatItem($items->first());
            }
        };

        if ($section) {
            if (!isset($cmsSections[$section])) {
                return response()->json([
                    'status' => false,
                    'code' => 404,
                    'message' => ucfirst($section) . ' Section Not Found.',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => ucfirst($section) . ' Section Data Retrieved Successfully.',
                'data' => [
                    $section => $formatSection($section, $cmsSections[$section])
                ]
            ]);
        }

        // Return all sections if no specific section is requested
        $formattedData = [];
        foreach ($cmsSections as $key => $items) {
            $formattedData[$key] = $formatSection($key, $items);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => ucfirst($page) . ' Page Data Retrieved Successfully.',
            'data' => $formattedData
        ]);
    }

    private function formatItem($item)
    {
        return [
            'title' => $item->title,
            'sub_title' => $item->sub_title,
            'image' => $item->image ? url($item->image) : null,
            'description' => $item->description ? strip_tags($item->description) : null,
            'sub_description' => $item->sub_description ? strip_tags($item->sub_description) : null,
            'main_text' => $item->main_text,
            'sub_text' => $item->sub_text,
            'button_text' => $item->button_text,
            'sub_button_text' => $item->sub_button_text,
            'link_url' => $item->link_url,
            'email'  => $item->email,
            'phone'  => $item->phone,
            'location' => $item->location,

            'gallery' => $item->galleries->map(function ($gallery) {
                return url($gallery->gallery);
            })->toArray(),
        ];
    }



    public function getNewsletterSection($page)
    {
        $newsletter = CMS::where('page', $page)
            ->where('section', 'newsletter_section')
            ->where('status', 'active')
            ->first();

        if (!$newsletter) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'Newsletter section not found for ' . ucfirst($page) . '.',
                'data' => null
            ], 404);
        }

        $data = [
            'title' => $newsletter->title,
            'sub_title' => $newsletter->sub_title,
            'image' => $newsletter->image ? url($newsletter->image) : null,
            'video' => $newsletter->video ? url($newsletter->video) : null,
            'description' => $newsletter->description ? strip_tags($newsletter->description) : null,
            'sub_description' => $newsletter->sub_description ? strip_tags($newsletter->sub_description) : null,
            'main_text' => $newsletter->main_text,
            'sub_text' => strip_tags($newsletter->sub_text),
            'button_text' => $newsletter->button_text,
            'sub_button_text' => $newsletter->sub_button_text,
            'link_url' => $newsletter->link_url,
        ];

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Newsletter Section Data Retrieved Successfully.',
            'data' => $data
        ]);
    }
}
