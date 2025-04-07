<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ReviewModel;

class MovieModel extends Model
{
    protected $table = 'movies'; // The name of your database table
    protected $primaryKey = 'id'; // The primary key column
    protected $allowedFields = ['title', 'director', 'year', 'genre', 'description', 'poster_url']; // Add other fields too
    protected $useTimestamps = true; // Automatically manage created_at and updated_at fields

    // Fetch the reviews for a specific movie
    public function filterMovies($genre = null, $year = null)
    {
        // Apply genre filter
        if ($genre) {
            $this->where('genre', $genre);
        }

        // Apply year filter
        if ($year) {
            $this->where('year', $year);
        }

        // Return the filtered movies
        return $this->findAll();
    }


    // Method to get reviews for a movie
    public function getReviews($movieId)
    {
        $reviewModel = new \App\Models\ReviewModel();
        return $reviewModel->where('movie_id', $movieId)->findAll();
    }

    // Search movies by title (partial match)
    public function searchByTitle($title)
    {
        return $this->like('title', $title)->findAll();
    }
    
    
} 
