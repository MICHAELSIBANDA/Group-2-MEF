<?php
// Handle form submission
$submitted = false;

$categories = [
    'AI',
    'Agriculture',
    'Entrepreneurship',
    'Education'
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nominator_name = htmlspecialchars($_POST['nominator_name']);
    $nominator_surname = htmlspecialchars($_POST['nominator_surname']);
    $nominee_name = htmlspecialchars($_POST['nominee_name']);
    $award_category = htmlspecialchars($_POST['award_category']);
    $reason = htmlspecialchars($_POST['reason']);

    // TODO: Save to DB or send email

    $submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Convocation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/convocation.css">
</head>

<body class="convocation-page">

<div class="container">

    <!-- Header -->
    <header class="page-header">
        <div class="trophy">🏆</div>
        <h1>Convocation</h1>
        <p>Recognizing excellence, dedication, and the human spirit.</p>
    </header>

    <div class="form-wrapper">

        <div class="form-header">
            <span>🏅</span>
            <h2>Submit a Nomination</h2>
        </div>

        <?php if ($submitted): ?>
            <div class="success-message">
                ✅ Nomination Sent Successfully!
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="grid-2">
                <div class="form-group">
                    <label>Your First Name</label>
                    <input required type="text" name="nominator_name" placeholder="e.g. John">
                </div>

                <div class="form-group">
                    <label>Your Surname</label>
                    <input required type="text" name="nominator_surname" placeholder="e.g. Doe">
                </div>
            </div>

            <div class="form-group">
                <label>Who are you nominating?</label>
                <input required type="text" name="nominee_name" placeholder="Full name of nominee">
            </div>

            <div class="form-group">
                <label>Award Category</label>
                <select name="award_category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>">
                            <?= $category ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Reason for Nomination</label>
                <textarea rows="4" name="reason" placeholder="Tell us why they deserve this award..."></textarea>
            </div>

            <button type="submit" class="submit-btn">
                Submit Nomination
           </button>

        </form>

    </div>

</div>

</body>
</html>