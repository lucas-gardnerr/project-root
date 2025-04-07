<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($movie['title']) ?> - Details</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .movie-detail { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        .poster { height: 250px; background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 60px; margin-bottom: 20px; }
        .review { border-top: 1px solid #ccc; padding-top: 10px; margin-top: 10px; }
        .add-review-link { margin-top: 20px; }
    </style>
</head>
<body>

    <!-- Movie Title and Description -->
    <div class="movie-detail">
        <h1><?= esc($movie['title']) ?></h1>
        <p><?= esc($movie['description']) ?></p>
    </div>

    <!-- Reviews Section -->
    <div class="movie-reviews">
        <h3>Reviews</h3>
        <?php if (!empty($reviews)): ?>
            <ul>
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <strong><?= esc($review['reviewer_name']) ?> (Rating: <?= esc($review['rating']) ?>):</strong><br>
                        <?= esc($review['review_text']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>

    <!-- Link to Add Review -->
    <div class="add-review-link">
        <a href="<?= site_url('movie/addReview/' . $movie['id']) ?>">Add Your Review</a>
    </div>

</body>
</html>
