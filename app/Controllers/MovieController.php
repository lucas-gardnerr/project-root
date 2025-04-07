<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\ReviewModel;

class MovieController extends BaseController {

    // Index method that retrieves all movies
    public function index()
{
    // Load the models
    $movieModel = new MovieModel();
    $reviewModel = new ReviewModel();

    // Get all movies using findAll()
    $movies = $movieModel->findAll();

    // Fetch reviews for each movie directly
    foreach ($movies as &$movie) {
        // Fetch reviews for each movie using where()
        $movie['reviews'] = $reviewModel->where('movie_id', $movie['id'])->findAll();
    }

    // Get filter parameters from the request
    $genre = $this->request->getGet('genre');
    $year = $this->request->getGet('year');

    // Fetch filtered movies
    $data['movies'] = $movieModel->filterMovies($genre, $year);

    // Get the selected genre and year for the filters
    $data['selectedGenre'] = $genre;
    $data['selectedYear'] = $year;

    // If no movies are found, show a message
    if (empty($data['movies'])) {
        return view('movies/no_movies');
    }

    // Return the view with movie data
    return view('movies/index', $data);
}


    // Method to show details of a specific movie
    public function show($id) {
        $movieModel = new MovieModel();
        $reviewModel = new ReviewModel();
        
        // Get the movie details
        $data['movie'] = $movieModel->find($id);
        
        // Get the reviews for the movie
        $data['reviews'] = $reviewModel->where('movie_id', $id)->findAll();
        
        // Debug: Print the reviews data (remove in production)
        echo "<pre>";
        print_r($data['reviews']);
        echo "</pre>";
        
        return view('movies/show', $data);
    }

    // Method to add a review for a movie
    public function viewMovie($movieId)
    {
        // Load the MovieModel to fetch the movie details
        $movieModel = new MovieModel();
        $movie = $movieModel->find($movieId);
        $reviews = $this->reviewModel->getReviewsForMovie($movie['id']);
        $data['reviews'] = $reviews;
        return view('movies/index', $data);
        
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

    // Method to display the form for adding a review
    public function addReview($movieId)
    {
        // Load the MovieModel to fetch the movie details
        $movieModel = new MovieModel();
        $movie = $movieModel->find($movieId);

        if (!$movie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Movie with ID $movieId not found.");
        }

        // Pass movie data to the view for adding reviews
        return view('addReview', ['movie' => $movie]);
    }

    // Method to save a review
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

    // Search method to search for movies by title
    public function search()
    {
        // Get the search query from the form
        $title = $this->request->getPost('title');
        
        // Load the MovieModel
        $movieModel = new MovieModel();
        
        // Fetch movies based on the title (this is handled in the MovieModel's searchByTitle method)
        $movies = $movieModel->searchByTitle($title);

        // If no movies are found, you can pass a message to the view
        if (empty($movies)) {
            $message = 'No movies found for "' . esc($title) . '"';
        } else {
            $message = 'Results for "' . esc($title) . '"';
        }

        // Pass the movies and message to the view
        return view('movies/index', [
            'movies' => $movies,
            'message' => $message
        ]);
    }
}
