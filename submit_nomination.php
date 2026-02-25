<?php
declare(strict_types=1);

require __DIR__ . "/config/db.php";

function fail(string $msg) {
  die($msg);
}

function post(string $key): string {
  return trim($_POST[$key] ?? "");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  fail("Invalid request.");
}

/* ======================
   GET FORM DATA
====================== */

$award_category_id = (int)post("award_category_id");

$nominee_full_name = post("nominee_full_name");
$nominee_id_number = post("nominee_id_number");
$nominee_dob = post("nominee_dob");
$nominee_gender = post("nominee_gender");
$nominee_email = post("nominee_email");
$nominee_phone = post("nominee_phone_number");

$nominator_full_name = post("nominator_full_name");
$nominator_email = post("nominator_email");
$nominator_phone = post("nominator_phone_number");

$qualification = post("qualification");

/* ======================
   BASIC VALIDATION
====================== */

if (
  !$award_category_id ||
  !$nominee_full_name ||
  !$nominee_id_number ||
  !$nominee_dob ||
  !$nominee_gender ||
  !$nominee_email ||
  !$nominator_full_name ||
  !$nominator_email ||
  !$qualification
) {
  fail("Missing required fields.");
}

try {

  $pdo->beginTransaction();

  /* ======================
     NOMINEE (insert/update)
  ======================= */

  $checkNominee = $pdo->prepare("
    SELECT nominee_id FROM nominee WHERE id_number = ?
  ");
  $checkNominee->execute([$nominee_id_number]);
  $existing = $checkNominee->fetch();

  if ($existing) {
    $nominee_id = (int)$existing["nominee_id"];

    $updateNominee = $pdo->prepare("
      UPDATE nominee
      SET full_name=?, dob=?, gender=?, email=?, phone_number=?
      WHERE nominee_id=?
    ");

    $updateNominee->execute([
      $nominee_full_name,
      $nominee_dob,
      $nominee_gender,
      $nominee_email,
      $nominee_phone ?: null,
      $nominee_id
    ]);

  } else {

    $insertNominee = $pdo->prepare("
      INSERT INTO nominee
      (full_name,id_number,dob,gender,email,phone_number)
      VALUES (?,?,?,?,?,?)
    ");

    $insertNominee->execute([
      $nominee_full_name,
      $nominee_id_number,
      $nominee_dob,
      $nominee_gender,
      $nominee_email,
      $nominee_phone ?: null
    ]);

    $nominee_id = (int)$pdo->lastInsertId();
  }

  /* ======================
     NOMINATOR
  ======================= */

  $insertNominator = $pdo->prepare("
    INSERT INTO nominator
    (full_name,email,phone_number)
    VALUES (?,?,?)
  ");

  $insertNominator->execute([
    $nominator_full_name,
    $nominator_email,
    $nominator_phone ?: null
  ]);

  $nominator_id = (int)$pdo->lastInsertId();

  /* ======================
     NOMINATION
  ======================= */

  $insertNomination = $pdo->prepare("
    INSERT INTO nomination
    (nominee_id,nominator_id,award_category_id,qualification)
    VALUES (?,?,?,?)
  ");

  $insertNomination->execute([
    $nominee_id,
    $nominator_id,
    $award_category_id,
    $qualification
  ]);

  $pdo->commit();

  header("Location: form.php?sent=1");
  exit;

} catch (Throwable $e) {

  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }

  fail("Error saving nomination.");
}