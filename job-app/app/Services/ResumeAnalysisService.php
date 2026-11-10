<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    public function extractResumeInformation(string $fileUrl)
    {
        //extract raw text from the resume pdf file (read pdf file, and get the text)
        $rawText = $this->extractTextFromPdf($fileUrl);

        Log::debug('Successfully extracted raw text from the resume PDF file ' . strlen($rawText) . ' characters');
        //use AI model to organize the text into structured format
        //output:summary, skills, experience, education -> JSON

        //Return the JSON object

        return [
            'summary' => '',
            'skills' => '',
            'experience' => '',
            'education' => '',
        ];
    }

    private function extractTextFromPdf(string $fileUrl): string
    {
       $tempFile= tempnam(sys_get_temp_dir(), 'resume_');

       $filePath = parse_url($fileUrl, PHP_URL_PATH);
       if(!$filePath){
              throw new \Exception("Invalid file URL");
       }

       $filename = basename($filePath);

       $storagePath = "resumes/{$filename}";

       if(!storage::disk('cloud')->exists($storagePath)){
              throw new \Exception("File not found in storage");
       }

       $pdfContent = Storage::disk('cloud')->get($storagePath);
       if(!$pdfContent){
              throw new \Exception("Failed to read the PDF file from storage");
       }

       file_put_contents($tempFile, $pdfContent);

       //check if pdf to text is installed
       $pdfToTextPath = ['/opt/homebrew/bin/pdftotext','/usr/bin/pdftotext','usr/local/bin/pdftotext'];
       $pdfToTextAvailable = false;

         foreach($pdfToTextPath as $path){
                  if(file_exists($path)){
                        $pdfToTextPath = $path;
                        break;
                  }
         }

         if(!$pdfToTextAvailable){
                  throw new \Exception("pdftotext is not installed on the server");
        }

        //Extract text from the pdf file
        $instance = new Pdf($tempFile);
        $instance->setpdf($tempFile);
        $text = $instance->text();

        //clean up the temp file
        unlink($tempFile);

        return $text;
    }
}