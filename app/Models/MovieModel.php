<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies'; // The name of your database table
    protected $primaryKey = 'id'; // The primary key column
    protected $allowedFields = ['title', 'director', 'year']; // Fields you want to allow
    protected $useTimestamps = true; // Automatically manage created_at and updated_at fields

    // Fetch the reviews for a specific movie
    public function getReviews($movieId)
    {
        $reviewModel = new ReviewModel();
        return $reviewModel->where('movie_id', $movieId)->findAll();
    }
}
