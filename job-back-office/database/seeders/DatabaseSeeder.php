<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //seed admin user
        User::firstOrCreate(
        ['email' => 'admin@example.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('12345678'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]
);

        //seed data test user
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')),true);
        $jobapplication = json_decode(file_get_contents(database_path('data/job_applications.json')),true);
        // create job categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::Create([
                'name' => $category,
            ]);
        }
        // Create Campanies
        foreach ($jobData['companies'] as $company) {
            //create company onwer
            $companyOwner = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );
            Company::firstOrCreate([
                    'name' => $company['name']],[
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'ownerid' => $companyOwner->id,
                ]
                );

                //create job vacancies
                foreach ($jobData['jobVacancies'] as $job) {
                    //get the created company
                    $company = Company::where('name', $company['name'])->firstOrFail();

                    //get the job category
                    $category = JobCategory::where('name', $job['category'])->firstOrFail();

                JobVacancy::firstOrCreate([
                    'title' => $job['title'],
                    'companyId' => $company->id,
                ],[
                    'description' => $job['description'],
                    'location' => $job['location'],
                    'salary' => $job['salary'],
                    'categoryId' => $category->id,
                ]);
            }

            //create job applications
            foreach ($jobapplication['jobApplications'] as $application) {
                //get random job vacancy
                $jobVacancy = JobVacancy::inRandomOrder()->first();

                //get random user
                $user = User::inRandomOrder()->first();

                //create application (job-seeker)
                $applicant = User::firstOrCreate(
                    ['email' => fake()->unique()->safeEmail()],
                    [
                        'name' => fake()->name(),
                        'password' => Hash::make('12345678'),
                        'role' => 'job-seeker',
                        'email_verified_at' => now(),
                    ]
                );

                //create resume
                $resume = Resume::Create([
                    'userId' => $applicant->id,
                    'filename' => $application['resume']['filename'],
                    'fileUri' => $application['resume']['fileUri'],
                    'contactDetails' => $application['resume']['contactDetails'],
                    'summary' => $application['resume']['summary'],
                    'skills' => $application['resume']['skills'],
                    'experience' => $application['resume']['experience'],
                    'education' => $application['resume']['education'],
                ]);

                //create job application
                JobApplication::create([
                    'jobVacancyId' => $jobVacancy->id,
                    'userId' => $applicant->id,
                    'resumeId' => $resume->id,
                    'status' => $application['status'],
                    'aiGeneratedScore' => $application['aiGeneratedScore'],
                    'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
                ]);

            }
        }
    }
}
