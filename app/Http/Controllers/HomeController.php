<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //show home page
    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('cat_name', 'ASC')->take(8)->get();

        $featured_jobs = DB::table('job')
        ->select('job.*', 'jobtype.jobtype_name')
        ->join('jobtype', 'job.jobtype_id', '=', 'jobtype.jobtype_id')
        ->where('job.status', 1)
        ->where('job.isFeatured', 1)
        ->orderBy('job.created_at', 'DESC')
        ->take(6)
        ->get();

        $latest_jobs = DB::table('job')
        ->select('job.*', 'jobtype.jobtype_name')
        ->join('jobtype', 'job.jobtype_id', '=', 'jobtype.jobtype_id')
        ->where('job.status', 1)
        ->orderBy('job.created_at', 'DESC')
        ->take(6)
        ->get();

        return view('front.home', [
            'categories' => $categories,
            'featured_jobs' => $featured_jobs,
            'latest_jobs' => $latest_jobs,
        ]);
    }
}
