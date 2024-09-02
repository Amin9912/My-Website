<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Section - Dark Theme with Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Dark background for the body */
            color: #f8f9fa; /* Light text color */
        }
        .card {
            background-color: #495057; /* Dark card background */
            border: none; /* Remove card borders */
        }
        .card-header {
            background-color: #212529; /* Darker header */
            color: #f8f9fa; /* Light text */
        }
        .gallery img {
            object-fit: cover; /* Ensure the image covers the gallery area */
            margin-bottom: 15px;
            border-radius: 5px; /* Optional: Add slight rounding to images */
            transition: transform 0.3s ease; /* Smooth scaling effect */
        }
        .gallery img:hover {
            transform: scale(1.1); /* Slight zoom on hover */
            cursor: pointer; /* Change cursor to pointer on hover */
        }
        .gallery .col-8 img {
            height: 315px; /* Height for the large image */
        }
        .gallery .col-4 img {
            height: 150px; /* Height for the smaller images */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Education Information -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Education</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">Bachelor of Science in Computer Science</h5>
                                    <p><strong>University Name:</strong> XYZ University</p>
                                    <p><strong>Year:</strong> 2017 - 2021</p>
                                    <p><strong>Description:</strong> A comprehensive program covering software development, data structures, algorithms, and more.</p>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">High School Diploma</h5>
                                    <p><strong>School Name:</strong> ABC High School</p>
                                    <p><strong>Year:</strong> 2013 - 2017</p>
                                    <p><strong>Description:</strong> Focused on science and mathematics with additional courses in computer programming.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="col-md-6">
                <div class="row gallery">
                    <div class="col-8">
                        <img src="https://via.placeholder.com/600x400.png?text=Large+Image" class="img-fluid" alt="Large University Image">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-12">
                                <img src="https://via.placeholder.com/300x200.png?text=Small+Image+1" class="img-fluid" alt="Small University Image 1">
                            </div>
                            <div class="col-12">
                                <img src="https://via.placeholder.com/300x200.png?text=Small+Image+2" class="img-fluid" alt="Small University Image 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <img src="https://via.placeholder.com/300x200.png?text=Small+Image+3" class="img-fluid" alt="Small University Image 3">
                            </div>
                            <div class="col-6">
                                <img src="https://via.placeholder.com/300x200.png?text=Small+Image+4" class="img-fluid" alt="Small University Image 4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
