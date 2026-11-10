<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    public function extractResumeInformation(string $storagePath): array
    {
        $rawText = $this->extractTextFromPdf($storagePath);

        Log::debug('Extracted ' . strlen($rawText) . ' characters from the resume PDF');

        // TODO: ابعت $rawText لموديل AI يرجّعه JSON منظم
        return [
            'summary'    => '',
            'skills'     => '',
            'experience' => '',
            'education'  => '',
        ];
    }

    private function extractTextFromPdf(string $storagePath): string
    {
        $disk = Storage::disk('public'); // نفس الـ disk اللي في الـ controller

        if (!$disk->exists($storagePath)) {
            throw new \Exception('File not found in storage: ' . $storagePath);
        }

        $binPath = $this->findPdfToText();

        $tempFile = tempnam(sys_get_temp_dir(), 'resume_');

        try {
            file_put_contents($tempFile, $disk->get($storagePath));

            return (new Pdf($binPath))
                ->setPdf($tempFile)
                ->text();
        } finally {
            @unlink($tempFile);
        }
    }

    private function findPdfToText(): string
    {
        // ممكن تحدد المسار في .env (مهم لو بتشتغل على Windows)
        $candidates = array_filter([
            env('PDFTOTEXT_PATH'),
            '/opt/homebrew/bin/pdftotext',
            '/usr/bin/pdftotext',
            '/usr/local/bin/pdftotext',
        ]);

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        throw new \Exception('pdftotext is not installed on the server');
    }
}