<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <meta name="description" content="Movies and Reviews">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Body Styling */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: #121212;
            color: #ddd;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 50px 0;
            font-size: 36px;
            font-weight: bold;
            color: #fff;
        }

        /* Home Button */
        .home-button {
            display: block;
            text-align: center;
            margin: 20px 0;
            padding: 12px 30px;
            border: none;
            background-color: #FF9F1C;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #e68a00;
        }

        /* Search Form */
        form input, form select, form button {
            font-size: 16px;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #444;
        }

        form button {
            background-color: #FF9F1C;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #e68a00;
        }

        /* Movie Grid Layout */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
            margin: 0 20px;
        }

        .movie-card {
            background: #1c1c1c;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .movie-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        }

        .movie-poster {
            width: 100%;
            height: 280px;
            background-color: #333;
            overflow: hidden;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-info {
            padding: 16px;
            text-align: center;
        }

        .movie-title {
            font-size: 18px;
            font-weight: bold;
            color: #FF9F1C;
            margin-bottom: 8px;
        }

        .rating-stars {
            color: #ffb400;
            font-size: 16px;
            display: flex;
            justify-content: center;
            margin-bottom: 8px;
        }

        .movie-hover-info {
            padding: 10px;
            max-height: 200px;
            overflow-y: auto;
            font-size: 14px;
            color: #aaa;
        }

        .movie-reviews h4 {
            margin-bottom: 10px;
            font-size: 16px;
            color: #FF9F1C;
        }

        .movie-reviews ul {
            font-size: 14px;
            padding-left: 16px;
            color: #ddd;
            max-height: 100px;
            overflow-y: auto;
        }

        .movie-reviews li {
            margin-bottom: 10px;
        }

        .movie-reviews p {
            color: #bbb;
        }

        .modal-content {
            position: relative;
            background: #121212;
            padding: 20px;
            width: 80%;
            height: 80%;
            color: #fff;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Button and Form Spacing */
        form, .home-button, .movie-card {
            margin-bottom: 30px;
        }

        .view-on-map-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF9F1C;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .view-on-map-btn:hover {
            background-color: #e68a00;
        }
    </style>
</head>
<body>

    <!-- Home Button -->
    <a href="<?= base_url('/') ?>" class="home-button">Home</a>

    <!-- Search Form -->
    <form action="<?= base_url('movies') ?>" method="get" style="text-align:center;">
        <input type="text" name="title" placeholder="Search for a movie..." value="<?= isset($title) ? esc($title) : '' ?>" style="width: 300px;">
        <button type="submit">Search</button>
    </form>

    <!-- Filters for Genre and Year -->
    <form action="<?= base_url('movies') ?>" method="get" style="text-align:center;">
        <select name="genre">
            <option value="">All Genres</option>
            <?php
                $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Romance', 'Sci-Fi', 'Fantasy', 'Thriller', 'Adventure'];
                foreach ($genres as $genre) {
                    echo "<option value=\"$genre\" " . (isset($selectedGenre) && $selectedGenre == $genre ? 'selected' : '') . ">$genre</option>";
                }
            ?>
        </select>

        <select name="year">
            <option value="">All Years</option>
            <?php
                $currentYear = date('Y');
                for ($year = 1990; $year <= $currentYear; $year++) {
                    echo "<option value=\"$year\" " . (isset($selectedYear) && $selectedYear == $year ? 'selected' : '') . ">$year</option>";
                }
            ?>
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Movie Grid -->
    <h2>Movies Here</h2>
    <div class="movie-grid">
        <?php if (!empty($movies)): ?>
            <?php foreach ($movies as $movie): ?>
                <div class="movie-card" onclick="window.location.href='<?= site_url('movies/viewMovie/' . $movie['id']) ?>'">
                    <div class="movie-poster">
                        <img src="<?= esc($movie['poster_url']) ?>" alt="<?= esc($movie['title']) ?>">
                    </div>

                    <div class="movie-info">
                        <div class="movie-title"><?= esc($movie['title']) ?></div>
                        <div id="avg-<?= $movie['id'] ?>" class="rating-stars">Loading...</div>
                    </div>

                    <div class="movie-hover-info">
                        <p>
                            <strong>Director:</strong> <?= esc($movie['director']); ?><br>
                            <strong>Year:</strong> <?= esc($movie['year']); ?><br>
                            <strong>Genre:</strong> <?= esc($movie['genre']); ?>
                        </p>
                        <p><strong>Description:</strong><br> <?= esc($movie['description']); ?></p>
                    </div>

                    <div class="movie-reviews">
    <h4>Reviews</h4>
    <?php if (!empty($reviews)): ?>
        <ul>
            <?php foreach ($reviews as $review): ?>
                <li>
                    <strong><?= esc($review['reviewer_name']); ?> (<?= esc($review['rating']); ?>/5):</strong><br>
                    <?= esc($review['review_text']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>

                    <div class="movie-actions">
                        <a href="<?= site_url('movies/addReview/' . $movie['id']); ?>" class="view-on-map-btn">Add a Review</a>
                        <?php if (!empty($movie['latitude']) && !empty($movie['longitude'])): ?>
                            <a href="https://www.google.com/maps?q=<?= esc($movie['latitude']) ?>,<?= esc($movie['longitude']) ?>" target="_blank" class="view-on-map-btn">
                                View on Google Maps
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No movies found.</p>
        <?php endif; ?>
    </div>

    <!-- Modal for Google Map -->
    <div id="mapModal" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeMap()">×</span>
            <h3>Movie Shops Map</h3>
            <div id="map"></div>
        </div>
    </div>

    <script>
        // Initialize Map
        let map;
        function initMap() {
            const shops = [
                { name: "Movie Shop 1", lat: 37.7749, lng: -122.4194 },
                { name: "Movie Shop 2", lat: 34.0522, lng: -118.2437 },
                { name: "Movie Shop 3", lat: 40.7128, lng: -74.0060 }
            ];

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: { lat: 37.7749, lng: -122.4194 }
            });

            shops.forEach(shop => {
                new google.maps.Marker({
                    position: { lat: shop.lat, lng: shop.lng },
                    map: map,
                    title: shop.name
                });
            });
        }

        // Show Map Modal
        document.getElementById("showMapButton").onclick = function() {
            document.getElementById("mapModal").style.display = "flex";
            initMap();
        };

        // Close Map Modal
        function closeMap() {
            document.getElementById("mapModal").style.display = "none";
        }
    </script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>

</body>
</html>
