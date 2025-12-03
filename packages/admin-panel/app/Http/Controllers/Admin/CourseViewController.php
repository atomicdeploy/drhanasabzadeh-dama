<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseViewController extends Controller
{
    /**
     * Display course viewing matrix.
     */
    public function courseViewing(Request $request)
    {
        $query = Course::with(['category', 'teacher']);

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('id', $request->course_id);
        }

        $courses = Course::select('id', 'title')->get();

        // Get course viewing data (placeholder - needs course_views table)
        $viewingData = [];
        if ($request->filled('course_id')) {
            // TODO: Implement actual viewing data query
            // This would typically join with a course_views or progress table
            $viewingData = DB::table('course_progress')
                ->where('course_id', $request->course_id)
                ->select(
                    'user_id',
                    DB::raw('MAX(progress_percent) as progress'),
                    DB::raw('MAX(last_viewed_at) as last_viewed')
                )
                ->groupBy('user_id')
                ->paginate(20);
        }

        return view('admin.courseview.viewing', compact('courses', 'viewingData'));
    }

    /**
     * Display progress chart.
     */
    public function chart(Request $request)
    {
        $courses = Course::select('id', 'title')->get();
        
        $chartData = [];
        $selectedCourse = null;
        $stats = null;

        if ($request->filled('course_id')) {
            $selectedCourse = Course::find($request->course_id);
            
            // TODO: Get actual progress data from database
            // This is placeholder data structure
            $chartData = [
                'labels' => ['0-10%', '10-20%', '20-30%', '30-40%', '40-50%', '50-60%', '60-70%', '70-80%', '80-90%', '90-100%'],
                'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0], // Placeholder
            ];

            // Calculate stats
            $stats = [
                'total_users' => 0, // TODO: Get from course_progress table
                'average_progress' => 0,
            ];
        }

        return view('admin.courseview.chart', compact('courses', 'chartData', 'selectedCourse', 'stats'));
    }

    /**
     * Display abandoned courses report.
     */
    public function abandonedCourses(Request $request)
    {
        $courses = Course::select('id', 'title')->get();

        $abandonedData = [];
        if ($request->filled('course_id')) {
            // TODO: Implement actual abandoned courses query
            // Users who haven't accessed course in X days but have < 100% progress
            $abandonedData = DB::table('course_progress')
                ->where('course_id', $request->course_id)
                ->where('progress_percent', '<', 100)
                ->where('last_viewed_at', '<', now()->subDays(30))
                ->join('users', 'course_progress.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.mobile',
                    'course_progress.progress_percent',
                    'course_progress.last_viewed_at'
                )
                ->paginate(20);
        }

        return view('admin.courseview.abandoned', compact('courses', 'abandonedData'));
    }
}
