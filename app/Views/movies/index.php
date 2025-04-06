<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <meta name="description" content="Movies and Reviews">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
</head>
<body>
    <h2>Movies Here</h2>

    <?php if (!empty($movies)): ?>
        <ul>
            <?php foreach ($movies as $movie): ?>
                <li>
                    <strong>Title:</strong> <?= esc($movie['title']); ?><br>
                    <strong>Director:</strong> <?= esc($movie['director']); ?><br>
                    <strong>Year:</strong> <?= esc($movie['year']); ?><br>

                    <!-- Link to add review -->
                    <a href="<?= site_url('movies/addReview/' . $movie['id']); ?>">Add a Review</a>

                    <h3>Reviews</h3>
                    <?php if (!empty($movie['reviews'])): ?>
                        <ul>
                            <?php foreach ($movie['reviews'] as $review): ?>
                                <li>
                                    <strong><?= esc($review['reviewer_name']); ?> (Rating: <?= esc($review['rating']); ?>/5):</strong><br>
                                    <?= esc($review['review_text']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reviews yet.</p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No movies found.</p>
    <?php endif; ?>

</body>
</html>
