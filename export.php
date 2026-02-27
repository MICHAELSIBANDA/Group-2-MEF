<?php
declare(strict_types=1);

/**
 * export.php — MEF Awards nominations CSV export
 * ---------------------------------------------------------
 * ✅ Exports nominations + nominee + nominator + category
 * ✅ Includes category_key + details_json (nomination_details)
 * ✅ Includes documents list (nomination_documents)
 *
 * NOTE:
 * - Uses PDO (same as your db.php)
 * - Requires your form.php login gate (password) to protect access
 */

session_start();

// Extra safety: block direct access unless unlocked in form.php
if (!isset($_SESSION['access_granted'])) {
  http_response_code(403);
  die("Access denied.");
}

require __DIR__ . "/config/db.php";

// prevent GROUP_CONCAT truncation
$pdo->exec("SET SESSION group_concat_max_len = 100000");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=mef_nominations_report.csv');

$out = fopen("php://output", "w");

// CSV headers
fputcsv($out, [
  'Nomination ID',
  'Category',
  'Category Key',
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
  'Submitted At',
  'Details JSON',
  'Documents (doc_type => file_path)'
]);

$sql = "
  SELECT
    n.nomination_id,
    ac.category_name,
    nd.category_key,
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
    n.submission_datetime,
    nd.details_json,
    GROUP_CONCAT(CONCAT(d.doc_type, ' => ', d.file_path) SEPARATOR ' | ') AS documents_list
  FROM nomination n
  JOIN award_category ac ON ac.award_category_id = n.award_category_id
  JOIN nominee no        ON no.nominee_id = n.nominee_id
  JOIN nominator na      ON na.nominator_id = n.nominator_id
  LEFT JOIN nomination_details nd ON nd.nomination_id = n.nomination_id
  LEFT JOIN nomination_documents d ON d.nomination_id = n.nomination_id
  GROUP BY
    n.nomination_id,
    ac.category_name,
    nd.category_key,
    no.full_name,
    no.id_number,
    no.email,
    no.phone_number,
    no.dob,
    no.gender,
    no.facebook_link,
    no.instagram_link,
    no.x_link,
    na.full_name,
    na.email,
    na.phone_number,
    n.qualification,
    n.status,
    n.submission_datetime,
    nd.details_json
  ORDER BY n.submission_datetime DESC
";

$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  fputcsv($out, [
    $row['nomination_id'],
    $row['category_name'],
    $row['category_key'] ?? '',
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
    $row['details_json'] ?? '',
    $row['documents_list'] ?? ''
  ]);
}

fclose($out);
exit;