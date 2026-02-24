<?php
declare(strict_types=1);

require __DIR__ . "/config/db.php";

function post(string $key): string {
  return trim((string)($_POST[$key] ?? ""));
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit("Invalid request method.");
}

$full_name      = post("full_name");
$email          = post("email");
$location       = post("location");
$field_of_study = post("field_of_study");
$title          = post("title");
$story          = post("story");
$quote          = post("quote");

if ($full_name === "" || $title === "" || $story === "") {
  http_response_code(400);
  exit("Missing required fields.");
}

$stmt = $pdo->prepare("
  INSERT INTO testimonies (full_name, email, location, field_of_study, title, story, quote)
  VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
  $full_name,
  $email !== "" ? $email : null,
  $location !== "" ? $location : null,
  $field_of_study !== "" ? $field_of_study : null,
  $title,
  $story,
  $quote !== "" ? $quote : null
]);

// After submit, send them back to homepage to see it
header("Location: index.php#stories");
exit;