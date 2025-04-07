<!-- app/Views/addReview.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review for <?= esc($movie['title']) ?></title>
</head>
<body>
    <!-- Heading -->
    <h1>Add Your Review for <?= esc($movie['title']) ?></h1>

    <!-- Display Success or Error Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Review Form -->
    <form action="<?= site_url('movie/saveReview/' . $movie['id']) ?>" method="POST">
        <!-- Rating Input -->
        <label for="rating">Rating (1 to 5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>

        <!-- Review Text -->
        <label for="review">Review:</label>
        <textarea name="review" id="review" rows="5" required></textarea><br><br>

        <button type="submit">Submit Review</button>
    </form>

    <br>

    <!-- Back to Movie Details Link -->
    <a href="<?= base_url('movie/viewMovie/' . $movie['id']) ?>">Back to Movie Details</a>
</body>
</html> 
