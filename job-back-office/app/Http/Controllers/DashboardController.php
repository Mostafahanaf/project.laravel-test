<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }
        return view('dashboard.index' , compact(['analytics']));
    }

    private function adminDashboard(){

        //last 30 days active users (job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        //total jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        //total Applictions (not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        //most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
        ->orderByDesc('totalCount')
        ->whereNull('deleted_at')
        ->limit(5)
        ->get();

        //Conversion rates
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
        ->having('totalCount', '>' , 0)
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get()
        ->map(function ($job){
            if($job->viewCount > 0) {
                $job->conversionRate = round( $job->totalCount / $job->viewCount * 100, 2);
            } else {
                $job->conversionRate = 0;
            }
            return $job;
        });

        $analytics =[
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

        return $analytics;
    }



private function companyOwnerDashboard()
{
    // Get all companies owned by the authenticated user
    $companies = auth()->user()->company;

    // Get all job vacancies belonging to these companies
    $jobVacancies = $companies->flatMap(function ($company) {
        return $company->jobVacancies;
    });

    $jobVacancyIds = $jobVacancies->pluck('id');

    // Active job seekers who applied to these jobs in the last 30 days
    $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
        ->where('role', 'job-seeker')
        ->whereHas('jobApplications', function ($query) use ($jobVacancyIds) {
            $query->whereIn('jobVacancyId', $jobVacancyIds);
        })
        ->count();

    // Total jobs belonging to the owner's companies
    $totalJobs = $jobVacancies->count();

    // Total applications for these jobs
    $totalApplications = JobApplication::whereIn('jobVacancyId',$jobVacancyIds)->count();

    //most apllied jobs of the company
    $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
    ->whereIn('id', $jobVacancyIds)
    ->orderByDesc('totalCount')
    ->limit(5)
    ->get();

    // conversion Rates of the company

    $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
    ->whereIn('id', $jobVacancyIds)
    ->having('totalCount', '>' , 0)
    ->orderByDesc('totalCount')
    ->limit(5)
    ->get()
    ->map(function ($job){
            if($job->viewCount > 0) {
                $job->conversionRate = round( $job->totalCount / $job->viewCount * 100, 2);
            } else {
                $job->conversionRate = 0;
            }
            return $job;
        });


    $analytics = [
        'activeUsers' => $activeUsers,
        'totalJobs' => $totalJobs,
        'totalApplications' => $totalApplications,
        'mostAppliedJobs' =>$mostAppliedJobs,
        'conversionRates' => $conversionRates,
    ];
    return $analytics;
}


}
