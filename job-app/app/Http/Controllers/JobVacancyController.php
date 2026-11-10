<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\Resume;


class JobVacancyController extends Controller
{
    public function show(string $id) {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id) {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumes = auth()->user()->resumes;
        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id) {
        $file = $request->file('resume_file');
        $extension = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $fileName = 'resume_' . time() . '.' . $extension;

        //store in cloud
        $path = $file->storeAs('resumes', $fileName, 'public');

        $fileUrl = config('filesystem.disks.cloud.url') . '/' . $path;

        $resume = Resume::create([
            'filename' => $originalName,
            'fileUri' => $path,
            'userId' => auth()->id(),
            'contactDetails' => json_encode([
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
            ]),
            'summary' => '',
            'skills' => '',
            'experience' => '',
            'education' => '',
        ]);

        JobApplication::create([
            'status' => 'pending',
            'jobVacancyId' => $id,
            'userId' => auth()->id(),
            'resumeId' => $resume->id,
            'aiGeneratedScore' => 0,
            'aiGeneratedFeedback' => '',
        ]);

        return redirect()->route('job-applications.index', $id)->with('success', 'Your application has been submitted successfully.');
    }
}


