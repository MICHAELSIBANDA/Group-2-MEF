<?php
declare(strict_types=1);

session_start();

$correctPassword = "1234"; // Change this to your secure password

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['login'])) {
    if ($_POST['password'] === $correctPassword) {
        $_SESSION['access_granted'] = true;
    } else {
        $loginError = "Incorrect password.";
    }
}

require __DIR__ . "/config/db.php";

function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

$categories = $pdo->query("
  SELECT award_category_id, category_name
  FROM award_category
  ORDER BY category_name
")->fetchAll();

$sent = isset($_GET["sent"]) && $_GET["sent"] === "1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>MEF Awards | Nomination Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="styles/styles.css" />

  <style>
    body { background: #f5f7fb; color: #111827; }
    .page-wrap{ max-width: 980px; margin: 48px auto; padding: 0 16px; }
    .page-title{ margin:0 0 6px; font-size:2rem; font-weight:800; letter-spacing:-0.02em; text-align: center;}
    .page-subtitle{ margin:0; color:#4b5563; line-height:1.6; text-align: center; }
    .card{
      background:#fff; border:1px solid #e5e7eb; border-radius:18px;
      padding:26px; box-shadow:0 12px 30px rgba(0,0,0,.08); margin-top:18px;
    }
    .success{
      background:#e6f4ea; color:#1e4620; padding:12px 14px; border-radius:12px;
      margin-bottom:18px; font-weight:600; border:1px solid rgba(30,70,32,.15);
    }
    .section-title{ margin:18px 0 12px; font-size:1.05rem; font-weight:800; }
    .divider{ border:none; height:1px; background:#e5e7eb; margin:18px 0; }
    .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .field{ margin-bottom:14px; }
    label{ display:block; font-weight:700; margin-bottom:6px; color:#111827; font-size:.95rem; }
    input, select, textarea{
      width:100%; padding:12px 14px; border-radius:12px; border:1px solid #e5e7eb;
      outline:none; background:#fff; color:#111827; font-size:15px;
      transition: box-shadow .15s ease, border-color .15s ease;
    }
    textarea{ min-height:130px; resize:vertical; line-height:1.5; }
    input:focus, select:focus, textarea:focus{ border-color:#111827; box-shadow:0 0 0 4px rgba(17,24,39,.08); }
    .hint{ margin-top:6px; color:#6b7280; font-size:.92rem; line-height:1.4; }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; align-items:center; justify-content: center;}
    .btn-solid{
      border:0; border-radius:12px; padding:12px 16px; cursor:pointer; font-weight:800;
      background:#111827; color:#fff; text-decoration:none; display:inline-flex; align-items:center; justify-content:center;
      transition: transform .06s ease, background .15s ease;
    }
    .btn-solid:hover{ background:#0b1220; }
    .btn-solid:active{ transform: translateY(1px); }
    .btn-ghost{
      border:1px solid #111827; border-radius:12px; padding:12px 16px; font-weight:800;
      color:#111827; text-decoration:none; background:transparent; display:inline-flex; align-items:center; justify-content:center;
    }
    .btn-ghost:hover{ background: rgba(17,24,39,.06); }
    @media (max-width:760px){ .grid-2{ grid-template-columns:1fr; } .card{ padding:18px; } .page-title{ font-size:1.7rem; } }

    .form-section-title{
  margin: 22px 0 12px;
  font-size: 1.1rem;
  font-weight: 900;
  color:#111827;
  background:#f3f4f6;
  border:1px solid #e5e7eb;
  padding: 10px 12px;
  border-radius: 12px;
  letter-spacing: .02em;
}
  </style>
</head>
<body>

<div class="page-wrap">
  <div>
    <h1 class="page-title">MEF Awards — Nomination Form</h1>
    <p class="page-subtitle">Nominate a student who represents academic excellence, resilience, and impact.</p>
  </div>

  <div class="card">
    <?php if ($sent): ?>
      <div class="success">Nomination submitted successfully.</div>
    <?php endif; ?>

    <form method="POST" action="submit_nomination.php">

      <h2 class="form-section-title">Award Category</h2>
      <div class="field">
        <label for="award_category_id">Select category</label>
        <select id="award_category_id" name="award_category_id" required>
          <option value="">-- Choose category --</option>
          <?php foreach ($categories as $c): ?>
            <option value="<?= (int)$c["award_category_id"] ?>"><?= e($c["category_name"]) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <hr class="divider" />

      <h2 class="form-section-title">Nominee Information</h2>

      <div class="grid-2">
        <div class="field">
          <label for="nominee_full_name">Full name</label>
          <input id="nominee_full_name" type="text" name="nominee_full_name" required>
        </div>
        <div class="field">
          <label for="nominee_id_number">ID number</label>
          <input id="nominee_id_number" type="text" name="nominee_id_number" required>
        </div>
      </div>

      <div class="grid-2">
        <div class="field">
          <label for="nominee_dob">Date of birth</label>
          <input id="nominee_dob" type="date" name="nominee_dob" required>
        </div>
        <div class="field">
          <label for="nominee_gender">Gender</label>
          <select id="nominee_gender" name="nominee_gender" required>
            <option value="">-- Select --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            <option value="Prefer not to say">Prefer not to say</option>
          </select>
        </div>
      </div>

      <div class="grid-2">
        <div class="field">
          <label for="nominee_email">Email</label>
          <input id="nominee_email" type="email" name="nominee_email" required>
        </div>
        <div class="field">
          <label for="nominee_phone_number">Phone (optional)</label>
          <input id="nominee_phone_number" type="text" name="nominee_phone_number">
        </div>
      </div>

      <!-- Social links (NEW) -->
      <div class="grid-2">
        <div class="field">
          <label for="facebook_link">Facebook link (optional)</label>
          <input id="facebook_link" type="url" name="facebook_link" placeholder="https://facebook.com/...">
        </div>
        <div class="field">
          <label for="instagram_link">Instagram link (optional)</label>
          <input id="instagram_link" type="url" name="instagram_link" placeholder="https://instagram.com/...">
        </div>
      </div>

      <div class="field">
        <label for="x_link">X/Twitter link (optional)</label>
        <input id="x_link" type="url" name="x_link" placeholder="https://x.com/...">
      </div>

      <hr class="divider" />

      <h2 class="form-section-title">Nominator Information</h2>

      <div class="grid-2">
        <div class="field">
          <label for="nominator_full_name">Your full name</label>
          <input id="nominator_full_name" type="text" name="nominator_full_name" required>
        </div>
        <div class="field">
          <label for="nominator_email">Your email</label>
          <input id="nominator_email" type="email" name="nominator_email" required>
        </div>
      </div>

      <div class="field">
        <label for="nominator_phone_number">Your phone (optional)</label>
        <input id="nominator_phone_number" type="text" name="nominator_phone_number">
      </div>

      <hr class="divider" />

      <h2 class="form-section-title">Nomination Details</h2>

      <div class="field">
        <label for="qualification">Qualification / Motivation</label>
        <textarea id="qualification" name="qualification" required placeholder="Explain why this student deserves the award..."></textarea>
        <div class="hint">Include achievements, impact, and why it matches the category.</div>
      </div>

      <div class="actions">
        <button type="submit" class="btn-solid">Submit Nomination</button>
        <a class="btn-ghost" href="index.php">Back to Home</a>
      </div>

    </form>
  </div>
  <div class="card" style="margin-top: 50px;">
    <!-- PASSWORD PROTECTED DOWNLOAD -->
    <?php if (isset($_SESSION['access_granted'])): ?>
      <h2 class="form-section-title" style="display: flex; justify-content: center;">Download Nomination</h2>
      <div class="actions">
        <a href="export.php" class="btn-solid">Download Nomination</a>
        <form method="post" style="display:inline;">
          <button type="submit" name="logout" class="btn-ghost">Logout</button>
        </form>
      </div>
    <?php else: ?>
      <h2 class="form-section-title" style="display:flex; justify-content: center;">Access Report</h2>
      <div class="field">
        <form method="post">
          <input 
            type="password" 
            name="password" 
            placeholder="Enter password" 
            required
          >
          <div class="actions" style="margin-top:14px;">
            <button type="submit" name="login" class="btn-solid">Unlock</button>
          </div>
          <?php if (isset($loginError)): ?>
            <div style="color:#dc2626; font-size:14px; margin-top:8px; font-weight:600;">
              <?php echo e($loginError); ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>