<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($movie['title']) ?> - Details</title>
</head>
<body>
    <h1><?= esc($movie['title']) ?></h1>
    <p><?= esc($movie['description']) ?></p>
    
    <h2>Reviews</h2>
    <?php if (!empty($reviews)): ?>
        <ul>
            <?php foreach ($reviews as $review): ?>
                <li><strong><?= esc($review['rating']) ?> Stars</strong>: <?= esc($review['review']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No reviews yet. Be the first to review!</p>
    <?php endif; ?>
    
    <a href="/movie/addReview/<?= esc($movie['id']) ?>">Add Your Review</a>
</body>
</html>
