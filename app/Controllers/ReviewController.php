<?php

namespace App\Controllers;

use CodeIgniter\Controller;


class ReviewController extends BaseController
{
    public function addReview()
    {
        // Optionally, load any data needed for the page here

        // Return a view to render the addReview page
        return view('addReview');
    }
    public function saveReview()
    {
        // Get the submitted form data
        $review = $this->request->getPost('review');
        $rating = $this->request->getPost('rating');
    
        // Validation (optional)
        if (empty($review) || empty($rating)) {
            return redirect()->back()->with('error', 'Please fill out all fields.');
        }
    
        // Save the review to the database (you can use a model to handle this)
        // Example: Assuming you have a model named 'ReviewModel'
    
        // Load the model
        $reviewModel = new \App\Models\ReviewModel();
    
        // Save data
        $data = [
            'review' => $review,
            'rating' => $rating,
        ];
    
        $reviewModel->save($data);
    
        // Redirect after saving the review
        return redirect()->to('/addReview')->with('success', 'Review added successfully!');
    }
}
