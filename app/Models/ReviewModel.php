<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';  // Your table name
    protected $primaryKey = 'id';  // Primary key column
    protected $allowedFields = ['review', 'rating'];  // Fields that can be inserted/updated
    protected $useTimestamps = true;  // Automatically handle created_at and updated_at fields
}

