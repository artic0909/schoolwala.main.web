<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Classes;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return view('admin.importer.form', compact('classes'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        
        $handle = fopen($file->getRealPath(), "r");
        
        $header = fgetcsv($handle, 1000, ",");
        
        // We expect columns like: chapter_name, video_title, video_type, video_link, video_description
        // Adjust indices if needed or use associative array mapping
        
        $count = 0;
        $missingChapters = [];
        
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data = array_combine($header, $row);
            
            if (!$data) {
                continue; // Skip malformed rows
            }
            
            // Clean keys (trim whitespace)
            $cleanData = [];
            foreach ($data as $key => $value) {
                $cleanData[trim(strtolower($key))] = trim($value);
            }
            
            // Required at least chapter_name and video_title
            if (!isset($cleanData['chapter_name']) || !isset($cleanData['video_title'])) {
                continue; 
            }
            
            $chapterName = $cleanData['chapter_name'];
            $videoTitle = $cleanData['video_title'];
            $videoType = $cleanData['video_type'] ?? 'free';
            $videoLink = $cleanData['video_link'] ?? '';
            $videoDesc = $cleanData['video_description'] ?? '';
            
            // Find Chapter
            $chapter = Chapter::where('class_id', $request->class_id)
                              ->where('subject_id', $request->subject_id)
                              ->where('name', $chapterName)
                              ->first();
            
            if ($chapter) {
                Video::create([
                    'class_id' => $request->class_id,
                    'subject_id' => $request->subject_id,
                    'chapter_id' => $chapter->id,
                    'video_title' => $videoTitle,
                    'slug' => Str::slug($videoTitle) . '-' . uniqid(),
                    'video_type' => strtolower($videoType) == 'paid' ? 'paid' : 'free',
                    'video_link' => $videoLink,
                    'video_description' => $videoDesc,
                    'note_link' => null,
                    'video_thumbnail' => null,
                ]);
                $count++;
            } else {
                $missingChapters[] = $chapterName;
            }
        }
        
        fclose($handle);
        
        $msg = "Successfully imported $count videos.";
        if (count($missingChapters) > 0) {
            $msg .= " However, chapters not found for: " . implode(", ", array_unique($missingChapters));
        }

        return redirect()->back()->with('success', $msg);
    }
}
