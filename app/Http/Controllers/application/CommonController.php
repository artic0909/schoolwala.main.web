<?php

namespace App\Http\Controllers\application;

use App\Models\Classes;
use App\Models\Story;
use App\Models\Faculty;
use App\Models\FAQ;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class CommonController extends AppController
{
    /**
     * Get all classes.
     */
    public function getClasses()
    {
        $classes = Classes::all();
        return $this->sendResponse($classes, 'Classes retrieved successfully.');
    }

    /**
     * Get Stories.
     */
    public function getStories()
    {
        $stories = Story::with('storyTag')->get();
        return $this->sendResponse($stories, 'Stories retrieved successfully.');
    }

    /**
     * Get Faculties.
     */
    public function getFaculties()
    {
        $faculties = Faculty::all();
        return $this->sendResponse($faculties, 'Faculties retrieved successfully.');
    }

    /**
     * Get FAQs.
     */
    public function getFAQs()
    {
        $faqs = FAQ::all();
        return $this->sendResponse($faqs, 'FAQs retrieved successfully.');
    }

    /**
     * Get About Us content.
     */
    public function getAboutUs()
    {
        $aboutUs = AboutUs::all();
        return $this->sendResponse($aboutUs, 'About Us content retrieved successfully.');
    }

}
