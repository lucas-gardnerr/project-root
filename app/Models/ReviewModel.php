<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews'; // Table name
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['movie_id', 'review', 'rating']; // Allowed fields for insert/update
    protected $useTimestamps = true; // If you have timestamp fields like created_at/updated_at
}