<?php
declare(strict_types=1);

/**
 * submit_nomination.php (UPDATED - FULL COMPLIANCE + CLEAN UX)
 * ------------------------------------------------------------------
 * ✅ Saves nominee + nominator + nomination
 * ✅ Saves category-specific details_json into nomination_details
 * ✅ Uploads files into /uploads/nominations/{nomination_id}/
 * ✅ Records file metadata in nomination_documents
 *
 * ✅ UX IMPROVEMENT:
 * - No more plain "die()" page
 * - Uses session flash error and redirects back to form.php
 *
 * ✅ ENFORCES REQUIREMENTS:
 * - Universal required ID copy
 * - Age limits (Emerging <= 35, Agricultural <= 45)
 * - Required checkboxes + required text + required uploads per category
 * - Phakeng graduation year >= 2021
 * - "Page limits" for PDF uploads (best-effort)
 * - "Page limits" for textareas via WORD LIMITS (approx)
 */

session_start();
require __DIR__ . "/config/db.php";

/* =========================================================
   Flash error + redirect (IMPORTANT UX)
   ========================================================= */
function fail(string $msg): void {
  $_SESSION["form_error"] = $msg;
  // You can also store old values here if you want later (optional)
  header("Location: form.php");
  exit;
}

function post(string $key): string {
  return trim((string)($_POST[$key] ?? ""));
}

function checkbox(string $key): int {
  return isset($_POST[$key]) ? 1 : 0;
}

function getCategoryKeyFromName(string $name): ?string {
  $n = strtolower($name);
  if (str_contains($n, "emerging") && str_contains($n, "business")) return "EMERGING_BUSINESS";
  if (str_contains($n, "ai") && str_contains($n, "champion")) return "AI_CHAMPION";
  if (str_contains($n, "african") && str_contains($n, "research")) return "AFRICAN_DEV_RESEARCH";
  if (str_contains($n, "phakeng")) return "PHAKENG_PRIZE";
  if (str_contains($n, "agricultural")) return "AGRICULTURAL_IMPACT";
  return null;
}

function ensureDir(string $path): void {
  if (!is_dir($path)) {
    if (!mkdir($path, 0775, true) && !is_dir($path)) {
      throw new RuntimeException("Failed to create upload folder.");
    }
  }
}

function safeName(string $original): string {
  $base = preg_replace('/[^a-zA-Z0-9._-]/', '_', $original);
  $base = trim((string)$base, "_");
  return $base !== "" ? $base : "file";
}

/**
 * Best-effort PDF page counting.
 * Not perfect for all PDFs, but works for most typical ones.
 */
function pdfPageCount(string $path): ?int {
  if (!is_file($path)) return null;
  // only attempt on reasonable sizes
  $size = filesize($path);
  if ($size === false || $size > 15 * 1024 * 1024) return null; // skip huge PDFs

  $data = @file_get_contents($path);
  if ($data === false) return null;

  // Count "/Type /Page" occurrences (avoid "/Pages")
  $count = preg_match_all('/\/Type\s*\/Page\b(?!s)/', $data, $m);
  if ($count === false) return null;
  return $count;
}

/**
 * Approximate "page limit" for TEXT using word counts.
 * (Because you cannot reliably measure pages in a textarea.)
 * - 2 pages ~ 1200 words
 * - 3 pages ~ 1800 words
 * - 5 pages ~ 3000 words
 */
function enforceWordLimit(string $value, int $maxWords, string $message): void {
  $words = preg_split('/\s+/', trim($value));
  $words = array_filter($words, fn($w) => $w !== "");
  if (count($words) > $maxWords) fail($message);
}

function requireSingleFile(string $inputName, string $message): void {
  if (!isset($_FILES[$inputName]) || (($_FILES[$inputName]["error"] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE)) {
    fail($message);
  }
}

function isMultiUploadPresent(array $files): bool {
  if (!isset($files["name"]) || !is_array($files["name"])) return false;
  foreach ($files["name"] as $name) {
    if ((string)$name !== "") return true;
  }
  return false;
}

function requireMultiFile(string $inputName, string $message): void {
  if (!isset($_FILES[$inputName]) || !isMultiUploadPresent($_FILES[$inputName])) {
    fail($message);
  }
}

function calculateAge(string $dobYmd): int {
  $dob = DateTime::createFromFormat("Y-m-d", $dobYmd);
  if (!$dob) fail("Invalid Date of Birth.");
  $today = new DateTime("today");
  return (int)$dob->diff($today)->y;
}

/* =========================================================
   Upload saving
   ========================================================= */
function saveUpload(PDO $pdo, int $nominationId, string $docType, array $file, string $destDir, ?int $maxPdfPages = null): void {
  if (($file["error"] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return;

  if (($file["error"] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    throw new RuntimeException("Upload error for {$docType}.");
  }

  $size = (int)($file["size"] ?? 0);
  if ($size <= 0) throw new RuntimeException("Empty file for {$docType}.");
  if ($size > 25 * 1024 * 1024) throw new RuntimeException("File too large for {$docType} (max 25MB).");

  $tmp  = (string)$file["tmp_name"];
  $orig = (string)$file["name"];
  $safe = safeName($orig);

  $ext = strtolower(pathinfo($safe, PATHINFO_EXTENSION));
  $allowed = ["pdf","jpg","jpeg","png","doc","docx","ppt","pptx","mp4","mov","webm"];
  if (!in_array($ext, $allowed, true)) {
    throw new RuntimeException("Invalid file type for {$docType}: .{$ext}");
  }

  $newName = $docType . "_" . date("Ymd_His") . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $destPath = rtrim($destDir, "/") . "/" . $newName;

  if (!move_uploaded_file($tmp, $destPath)) {
    throw new RuntimeException("Failed to save file for {$docType}.");
  }

  // PDF page limit check (best effort) — do it AFTER saving so we can read file
  if ($maxPdfPages !== null && $ext === "pdf") {
    $pages = pdfPageCount($destPath);
    if ($pages !== null && $pages > $maxPdfPages) {
      @unlink($destPath);
      fail("{$docType}: PDF exceeds {$maxPdfPages} pages (detected {$pages}). Please upload a shorter PDF.");
    }
  }

  $mime = null;
  if (function_exists("mime_content_type")) {
    $mime = @mime_content_type($destPath) ?: null;
  }

  $stmt = $pdo->prepare("
    INSERT INTO nomination_documents
      (nomination_id, doc_type, file_path, original_name, mime_type, file_size)
    VALUES (?,?,?,?,?,?)
  ");
  $stmt->execute([
    $nominationId,
    $docType,
    $destPath,
    $orig,
    $mime,
    $size
  ]);
}

function saveUploadsMulti(PDO $pdo, int $nominationId, string $docType, array $files, string $destDir): void {
  if (!isset($files["name"]) || !is_array($files["name"])) return;

  $count = count($files["name"]);
  for ($i = 0; $i < $count; $i++) {
    $one = [
      "name" => $files["name"][$i] ?? "",
      "type" => $files["type"][$i] ?? "",
      "tmp_name" => $files["tmp_name"][$i] ?? "",
      "error" => $files["error"][$i] ?? UPLOAD_ERR_NO_FILE,
      "size" => $files["size"][$i] ?? 0,
    ];
    // skip empty slots
    if (($one["error"] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) continue;

    saveUpload($pdo, $nominationId, $docType, $one, $destDir);
  }
}

/* =========================================================
   Request method
   ========================================================= */
if ($_SERVER["REQUEST_METHOD"] !== "POST") fail("Invalid request.");

/* =========================================================
   GET FORM DATA
   ========================================================= */
$award_category_id = (int)post("award_category_id");

$nominee_full_name = post("nominee_full_name");
$nominee_id_number  = post("nominee_id_number");
$nominee_dob        = post("nominee_dob");
$nominee_gender     = post("nominee_gender");
$nominee_email      = post("nominee_email");
$nominee_phone      = post("nominee_phone_number");

$facebook_link  = post("facebook_link");
$instagram_link = post("instagram_link");
$x_link         = post("x_link");

$nominator_full_name = post("nominator_full_name");
$nominator_email     = post("nominator_email");
$nominator_phone     = post("nominator_phone_number");

$qualification = post("qualification");

/* =========================================================
   BASIC VALIDATION (universal)
   ========================================================= */
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

// universal required doc
requireSingleFile("id_copy", "Certified ID / Passport copy is required.");

/* =========================================================
   MAIN FLOW
   ========================================================= */
try {
  $pdo->beginTransaction();

  // Get category name
  $catStmt = $pdo->prepare("SELECT category_name FROM award_category WHERE award_category_id=?");
  $catStmt->execute([$award_category_id]);
  $catRow = $catStmt->fetch(PDO::FETCH_ASSOC);
  if (!$catRow) fail("Invalid category selected.");

  $category_name = (string)$catRow["category_name"];
  $category_key  = getCategoryKeyFromName($category_name) ?? "GENERAL";

  $age = calculateAge($nominee_dob);

  /* =========================================================
     CATEGORY-SPECIFIC ENFORCEMENT
     ========================================================= */

  if ($category_key === "EMERGING_BUSINESS") {
    if ($age > 35) fail("Emerging Business: nominee must be 35 years or younger.");

    if (!checkbox("eb_sa_citizen")) fail("Emerging Business: confirm South African citizen.");
    if (!checkbox("eb_founder")) fail("Emerging Business: confirm founder/co-founder.");
    if (!checkbox("eb_registered_sa")) fail("Emerging Business: confirm business registered & operating in South Africa.");
    if (!checkbox("eb_early_stage")) fail("Emerging Business: confirm business is early-stage.");
    if (post("eb_traction") === "") fail("Emerging Business: evidence of operations/traction is required.");

    requireSingleFile("eb_qualification_proof", "Emerging Business: proof of tertiary qualification is required.");
    requireSingleFile("eb_cipc_docs", "Emerging Business: CIPC registration documents are required.");
    requireSingleFile("eb_business_overview", "Emerging Business: business overview PDF is required.");
    requireMultiFile("eb_media", "Emerging Business: photo/video evidence is required.");

    if (checkbox("eb_over_2_years")) {
      requireSingleFile("eb_financial_tax", "Emerging Business: financial statements + tax compliance are required (business > 2 years).");
    }
  }

  if ($category_key === "AI_CHAMPION") {
    if (!checkbox("ai_ethics_confirm")) fail("AI Champion: confirm responsible and ethical AI engagement.");
    if (post("ai_profile") === "") fail("AI Champion: detailed nominee profile is required.");
    // Enforce "max 3 pages" via word limit (approx)
    enforceWordLimit(post("ai_profile"), 1800, "AI Champion: profile exceeds the maximum length (approx 3 pages). Please shorten it.");
    requireMultiFile("ai_evidence", "AI Champion: evidence files are required.");
  }

  if ($category_key === "AFRICAN_DEV_RESEARCH") {
    requireSingleFile("adr_postgrad_proof", "African Development Research: proof of postgraduate qualification is required.");
    if (post("adr_profile") === "") fail("African Development Research: nominee profile & motivation is required.");
    if (post("adr_abstract") === "") fail("African Development Research: research abstract/executive summary is required.");

    // "max 2 pages" & "max 3 pages" via word limits (approx)
    enforceWordLimit(post("adr_profile"), 1200, "African Development Research: profile exceeds the maximum length (approx 2 pages).");
    enforceWordLimit(post("adr_abstract"), 1800, "African Development Research: abstract exceeds the maximum length (approx 3 pages).");
  }

  if ($category_key === "PHAKENG_PRIZE") {
    if (!checkbox("mp_confirm_eligibility")) fail("Phakeng Prize: you must confirm eligibility.");

    $mp_degree_level    = post("mp_degree_level");
    $mp_graduation_year = post("mp_graduation_year");
    $mp_field           = post("mp_field");
    $mp_institution     = post("mp_institution");

    if ($mp_degree_level === "") fail("Phakeng Prize: degree level is required.");
    if ($mp_field === "") fail("Phakeng Prize: field is required.");
    if ($mp_institution === "") fail("Phakeng Prize: institution is required.");

    if ($mp_graduation_year === "" || !ctype_digit($mp_graduation_year)) {
      fail("Phakeng Prize: graduation year must be a valid number.");
    }
    if ((int)$mp_graduation_year < 2021) {
      fail("Phakeng Prize: graduation year must be 2021 or later.");
    }

    requireSingleFile("mp_qualification_proof", "Phakeng Prize: proof of qualification is required.");
    if (post("mp_abstract") === "") fail("Phakeng Prize: research abstract/summary is required.");
    if (post("mp_profile") === "") fail("Phakeng Prize: nominee profile & motivation is required.");

    // Enforce "max 2 pages" via word limits (approx)
    enforceWordLimit(post("mp_abstract"), 1200, "Phakeng Prize: abstract exceeds the maximum length (approx 2 pages).");
    enforceWordLimit(post("mp_profile"), 1200, "Phakeng Prize: profile exceeds the maximum length (approx 2 pages).");
  }

  if ($category_key === "AGRICULTURAL_IMPACT") {
    if ($age > 45) fail("Agricultural Award: nominee must be 45 years or younger.");

    if (!checkbox("agri_qualification_confirm")) fail("Agricultural Award: confirm post-school qualification completed.");
    if (!checkbox("agri_in_africa_confirm")) fail("Agricultural Award: confirm engagement in agriculture/agribusiness in Africa.");
    if (!checkbox("agri_innovation_impact_confirm")) fail("Agricultural Award: confirm innovation/leadership/impact.");

    requireSingleFile("agri_description", "Agricultural Award: written description PDF is required.");
    requireSingleFile("agri_impact", "Agricultural Award: impact statement PDF is required.");
    requireMultiFile("agri_media", "Agricultural Award: photo/video evidence is required.");
  }

  /* =========================================================
     NOMINEE insert/update
     ========================================================= */
  $checkNominee = $pdo->prepare("SELECT nominee_id FROM nominee WHERE id_number = ?");
  $checkNominee->execute([$nominee_id_number]);
  $existing = $checkNominee->fetch(PDO::FETCH_ASSOC);

  if ($existing) {
    $nominee_id = (int)$existing["nominee_id"];
    $updateNominee = $pdo->prepare("
      UPDATE nominee
      SET full_name=?, dob=?, gender=?, email=?, phone_number=?,
          facebook_link=?, instagram_link=?, x_link=?
      WHERE nominee_id=?
    ");
    $updateNominee->execute([
      $nominee_full_name,
      $nominee_dob,
      $nominee_gender,
      $nominee_email,
      $nominee_phone ?: null,
      $facebook_link ?: null,
      $instagram_link ?: null,
      $x_link ?: null,
      $nominee_id
    ]);
  } else {
    $insertNominee = $pdo->prepare("
      INSERT INTO nominee
        (full_name,id_number,dob,gender,email,phone_number,facebook_link,instagram_link,x_link)
      VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $insertNominee->execute([
      $nominee_full_name,
      $nominee_id_number,
      $nominee_dob,
      $nominee_gender,
      $nominee_email,
      $nominee_phone ?: null,
      $facebook_link ?: null,
      $instagram_link ?: null,
      $x_link ?: null
    ]);
    $nominee_id = (int)$pdo->lastInsertId();
  }

  /* =========================================================
     NOMINATOR
     ========================================================= */
  $insertNominator = $pdo->prepare("
    INSERT INTO nominator (full_name,email,phone_number)
    VALUES (?,?,?)
  ");
  $insertNominator->execute([
    $nominator_full_name,
    $nominator_email,
    $nominator_phone ?: null
  ]);
  $nominator_id = (int)$pdo->lastInsertId();

  /* =========================================================
     NOMINATION
     ========================================================= */
  $insertNomination = $pdo->prepare("
    INSERT INTO nomination (nominee_id,nominator_id,award_category_id,qualification)
    VALUES (?,?,?,?)
  ");
  $insertNomination->execute([
    $nominee_id,
    $nominator_id,
    $award_category_id,
    $qualification
  ]);
  $nomination_id = (int)$pdo->lastInsertId();

  /* =========================================================
     DETAILS JSON
     ========================================================= */
  $details = ["category_name" => $category_name, "age" => $age];

  if ($category_key === "EMERGING_BUSINESS") {
    $details += [
      "sa_citizen" => checkbox("eb_sa_citizen"),
      "founder" => checkbox("eb_founder"),
      "registered_sa" => checkbox("eb_registered_sa"),
      "early_stage" => checkbox("eb_early_stage"),
      "traction" => post("eb_traction"),
      "business_over_2_years" => checkbox("eb_over_2_years"),
    ];
  } elseif ($category_key === "AI_CHAMPION") {
    $details += [
      "ethical_ai_confirm" => checkbox("ai_ethics_confirm"),
      "profile" => post("ai_profile"),
      "links" => post("ai_links"),
    ];
  } elseif ($category_key === "AFRICAN_DEV_RESEARCH") {
    $details += [
      "profile_motivation" => post("adr_profile"),
      "abstract" => post("adr_abstract"),
    ];
  } elseif ($category_key === "PHAKENG_PRIZE") {
    $details += [
      "confirm_eligibility" => checkbox("mp_confirm_eligibility"),
      "degree_level" => post("mp_degree_level"),
      "graduation_year" => (int)post("mp_graduation_year"),
      "field" => post("mp_field"),
      "institution" => post("mp_institution"),
      "abstract" => post("mp_abstract"),
      "profile_motivation" => post("mp_profile"),
    ];
  } elseif ($category_key === "AGRICULTURAL_IMPACT") {
    $details += [
      "qualification_confirm" => checkbox("agri_qualification_confirm"),
      "in_africa_confirm" => checkbox("agri_in_africa_confirm"),
      "innovation_impact_confirm" => checkbox("agri_innovation_impact_confirm"),
    ];
  }

  $insertDetails = $pdo->prepare("
    INSERT INTO nomination_details (nomination_id, category_key, details_json)
    VALUES (?,?,?)
  ");
  $insertDetails->execute([
    $nomination_id,
    $category_key,
    json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
  ]);

  /* =========================================================
     FILE UPLOADS
     ========================================================= */
  $uploadBase = __DIR__ . "/uploads/nominations/" . $nomination_id;
  ensureDir($uploadBase);

  // Universal ID
  saveUpload($pdo, $nomination_id, "ID_COPY", $_FILES["id_copy"], $uploadBase);

  // General optional supporting docs
  if (isset($_FILES["supporting_docs"])) {
    saveUploadsMulti($pdo, $nomination_id, "SUPPORTING_DOC", $_FILES["supporting_docs"], $uploadBase);
  }

  // Category-specific docs (+ PDF page caps where applicable)
  if ($category_key === "EMERGING_BUSINESS") {
    saveUpload($pdo, $nomination_id, "QUALIFICATION_PROOF", $_FILES["eb_qualification_proof"], $uploadBase);
    saveUpload($pdo, $nomination_id, "CIPC_DOCS", $_FILES["eb_cipc_docs"], $uploadBase);

    if (checkbox("eb_over_2_years")) {
      saveUpload($pdo, $nomination_id, "FINANCIAL_TAX", $_FILES["eb_financial_tax"], $uploadBase);
    }

    // max 5 pages
    saveUpload($pdo, $nomination_id, "BUSINESS_OVERVIEW", $_FILES["eb_business_overview"], $uploadBase, 5);

    saveUploadsMulti($pdo, $nomination_id, "PHOTO_VIDEO_EVIDENCE", $_FILES["eb_media"], $uploadBase);
  }

  if ($category_key === "AI_CHAMPION") {
    saveUploadsMulti($pdo, $nomination_id, "AI_EVIDENCE", $_FILES["ai_evidence"], $uploadBase);
  }

  if ($category_key === "AFRICAN_DEV_RESEARCH") {
    saveUpload($pdo, $nomination_id, "POSTGRAD_PROOF", $_FILES["adr_postgrad_proof"], $uploadBase);
    if (isset($_FILES["adr_support"])) {
      saveUploadsMulti($pdo, $nomination_id, "RESEARCH_SUPPORT", $_FILES["adr_support"], $uploadBase);
    }
  }

  if ($category_key === "PHAKENG_PRIZE") {
    saveUpload($pdo, $nomination_id, "QUALIFICATION_PROOF", $_FILES["mp_qualification_proof"], $uploadBase);
    if (isset($_FILES["mp_extra"])) {
      saveUploadsMulti($pdo, $nomination_id, "PHAKENG_EXTRA", $_FILES["mp_extra"], $uploadBase);
    }
  }

  if ($category_key === "AGRICULTURAL_IMPACT") {
    // max 5 pages
    saveUpload($pdo, $nomination_id, "AGRI_DESCRIPTION", $_FILES["agri_description"], $uploadBase, 5);
    // max 2 pages
    saveUpload($pdo, $nomination_id, "AGRI_IMPACT_STATEMENT", $_FILES["agri_impact"], $uploadBase, 2);

    saveUploadsMulti($pdo, $nomination_id, "AGRI_MEDIA", $_FILES["agri_media"], $uploadBase);

    if (isset($_FILES["agri_support"])) {
      saveUploadsMulti($pdo, $nomination_id, "AGRI_SUPPORT", $_FILES["agri_support"], $uploadBase);
    }
  }

  $pdo->commit();

  // clear any old error
  unset($_SESSION["form_error"]);

  header("Location: form.php?sent=1");
  exit;

} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  // Optional: log $e->getMessage() to a file later
  fail("Something went wrong while saving the nomination. Please try again.");
}