<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\StatusReview;
use Illuminate\Http\Request;

class ManagmentReviewController extends Controller
{
    /*для сортировки и фильтрации по отзывам*/
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $paginate = $request->input('paginate',15);
        $status = $request->input('status');
        if ($sort == 'date_asc' || $sort == 'date_desc')
        {
            list($a,$b) = explode('_',$sort);
            $a = 'created_at';
        }
        elseif ($sort == 'status_asc' || $sort == 'status_desc')
        {
            list($a,$b) = explode('_',$sort);
            $a = 'status_id';
        }
        else
        {
            $a = 'id';
            $b = 'asc';
        }
        $reviews = Review::query()->with('status')
        ->when($status, function ($q) use ($status) {
            if ($status != 'all')
            {
                $q->where('status_id', $status);
            }
        })
        ->when($sort, function ($q) use($a,$b) {
            $q->orderBy($a, $b);
        })
        ->paginate($paginate);
        return view('AdminDirectory.ComponentManagment.ReviewManagment.review-managment',['reviews'=> $reviews, 'statuses'=>StatusReview::all()]);
    }

    /*для обновления статуса отзыва*/
    public function update(Request $request, $id)
    {
        $review = Review::where('id', $id)->first();
        $review->status_id = $request->input('status');
        $review->save();
        return redirect()->back();
    }
}
