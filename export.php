<?php
declare(strict_types=1);

// export.php - MEF Awards nominations CSV export (aligned with your DB)

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli("localhost", "root", "", "mef_awards");
$conn->set_charset("utf8mb4");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=mef_nominations_report.csv');

$output = fopen("php://output", "w");

// CSV column headers (aligned with your schema)
fputcsv($output, [
  'Nomination ID',
  'Category',
  'Nominee Full Name',
  'Nominee ID Number',
  'Nominee Email',
  'Nominee Phone',
  'Nominee DOB',
  'Nominee Gender',
  'Facebook',
  'Instagram',
  'X/Twitter',
  'Nominator Full Name',
  'Nominator Email',
  'Nominator Phone',
  'Qualification/Motivation',
  'Status',
  'Submitted At'
]);

$sql = "
  SELECT
    n.nomination_id,
    ac.category_name,
    no.full_name  AS nominee_full_name,
    no.id_number  AS nominee_id_number,
    no.email      AS nominee_email,
    no.phone_number AS nominee_phone,
    no.dob        AS nominee_dob,
    no.gender     AS nominee_gender,
    no.facebook_link,
    no.instagram_link,
    no.x_link,
    na.full_name  AS nominator_full_name,
    na.email      AS nominator_email,
    na.phone_number AS nominator_phone,
    n.qualification,
    n.status,
    n.submission_datetime
  FROM nomination n
  JOIN award_category ac ON ac.award_category_id = n.award_category_id
  JOIN nominee no        ON no.nominee_id = n.nominee_id
  JOIN nominator na      ON na.nominator_id = n.nominator_id
  ORDER BY n.submission_datetime DESC
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['nomination_id'],
    $row['category_name'],
    $row['nominee_full_name'],
    $row['nominee_id_number'],
    $row['nominee_email'],
    $row['nominee_phone'],
    $row['nominee_dob'],
    $row['nominee_gender'],
    $row['facebook_link'],
    $row['instagram_link'],
    $row['x_link'],
    $row['nominator_full_name'],
    $row['nominator_email'],
    $row['nominator_phone'],
    $row['qualification'],
    $row['status'],
    $row['submission_datetime'],
  ]);
}

fclose($output);
$conn->close();
exit;