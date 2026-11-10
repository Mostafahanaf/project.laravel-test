<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;

class JobVacancyController extends Controller
{
    protected ResumeAnalysisService $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumes = auth()->user()->resumes;
        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        // تأكد إن الوظيفة موجودة
        $jobVacancy = JobVacancy::findOrFail($id);

        if ($request->input('resume_option') === 'new_resume') {
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();
            $fileName = 'resume_' . time() . '.' . $extension;

            // بنخزن على نفس الـ disk اللي الـ service بيقرا منه
            $path = $file->storeAs('resumes', $fileName, 'public');

            // TODO: استبدلها بالـ AI service الحقيقي
            $extractedInfo = $this->resumeAnalysisService->extractResumeInformation($path);

            $resume = Resume::create([
                'filename'       => $originalName,
                'fileUri'        => $path,
                'userId'         => auth()->id(),
                'contactDetails' => json_encode([
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone,
                ]),
                'summary'    => $extractedInfo['summary'],
                'skills'     => $extractedInfo['skills'],
                'experience' => $extractedInfo['experience'],
                'education'  => $extractedInfo['education'],
            ]);
        } else {
            // بندور بس وسط الـ resumes بتاعة اليوزر نفسه
            $resume = auth()->user()
                ->resumes()
                ->findOrFail($request->input('resume_option'));
        }

        // TODO: Evaluate Job Application
        JobApplication::create([
            'status'              => 'pending',
            'jobVacancyId'        => $jobVacancy->id,
            'userId'              => auth()->id(),
            'resumeId'            => $resume->id,
            'aiGeneratedScore'    => 0,
            'aiGeneratedFeedback' => '',
        ]);

        return redirect()
            ->route('job-applications.index', $id)
            ->with('success', 'Your application has been submitted successfully.');
    }
}