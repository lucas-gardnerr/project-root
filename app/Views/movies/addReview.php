<!-- app/Views/addReview.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review for <?= esc($movie['title']) ?></title>
</head>
<body>
    <h1>Add Your Review for <?= esc($movie['title']) ?></h1>
    <form action="/movie/saveReview/<?= esc($movie['id']) ?>" method="post">
        <label for="review">Your Review:</label>
        <textarea name="review" id="review" required></textarea>

        <label for="rating">Rating:</label>
        <select name="rating" id="rating" required>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>

        <button type="submit">Submit Review</button>
    </form>
</body>
</html>
