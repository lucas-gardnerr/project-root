<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\ReviewModel;

class MovieController extends BaseController {

    // Index method that retrieves all movies
    public function index() 
    {
        $movieModel = new MovieModel();
        $data['movies'] = $movieModel->findAll();

        if (empty($data['movies'])) {
            return view('movies/no_movies');
        }

        // Get the reviews for each movie
        foreach ($data['movies'] as &$movie) {
            $movie['reviews'] = $movieModel->getReviews($movie['id']);
        }

        return view('movies/index', $data);
    }


    // Method to show details of a specific movie
    public function show($id) {
        $movieModel = new MovieModel();
        $reviewModel = new ReviewModel();
        
        // Get the movie and its reviews by ID
        $data['movie'] = $movieModel->find($id);
        $data['reviews'] = $reviewModel->where('movie_id', $id)->findAll();
        
        return view('movies/show', $data); // Return the movie details page
    }

    // Method to add a review for a movie
    public function viewMovie($movieId)
    {
        // Load the MovieModel to fetch the movie details
        $movieModel = new MovieModel();
        $movie = $movieModel->find($movieId);

        if (!$movie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Movie with ID $movieId not found.");
        }

        // Optionally, load reviews for the movie
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->where('movie_id', $movieId)->findAll();

        // Pass movie data and reviews to the view
        return view('movieDetail', [
            'movie' => $movie,
            'reviews' => $reviews
        ]);
    }

    public function addReview($movieId)
    {
        // Optional: Fetch movie details to display on the add review page
        $movieModel = new MovieModel();
        $movie = $movieModel->find($movieId);

        if (!$movie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Movie with ID $movieId not found.");
        }

        // Display the add review page with movie info
        return view('addReview', ['movie' => $movie]);
    }

    public function saveReview($movieId)
    {
        // Get review data from POST request
        $review = $this->request->getPost('review');
        $rating = $this->request->getPost('rating');

        // Validate the review and rating
        if (empty($review) || empty($rating)) {
            return redirect()->back()->with('error', 'Please fill out all fields.');
        }

        // Save the review in the database
        $reviewModel = new ReviewModel();
        $data = [
            'movie_id' => $movieId, // Associate the review with the movie
            'review' => $review,
            'rating' => $rating,
        ];
        $reviewModel->save($data);

        // Redirect back to the movie details page with a success message
        return redirect()->to("/movie/viewMovie/$movieId")->with('success', 'Review added successfully!');
    }
}
