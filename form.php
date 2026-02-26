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
    /* ==========================================================
       MEF Awards Form – Match main MEF design language
       (Uses your existing CSS variables from styles/styles.css)
       ========================================================== */

    :root{
      /* Safe fallbacks if variables are missing */
      --mef-primary: var(--color-primary, #2d5016);
      --mef-accent:  var(--color-accent,  #c8952e);
      --mef-bg:      var(--color-background, #faf8f5);
      --mef-card:    var(--color-card, #ffffff);
      --mef-border:  var(--color-border, #e5ded4);
      --mef-text:    var(--color-foreground, #1a1a1a);
      --mef-muted:   var(--color-muted, #6b6355);
      --mef-cream:   var(--color-cream, #f0ebe3);
      --mef-font:    var(--font-sans, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif);
    }

    body{
      background: var(--mef-bg);
      color: var(--mef-text);
      font-family: var(--mef-font);
    }

    .page-wrap{
      max-width: 980px;
      margin: 56px auto;
      padding: 0 16px;
    }

    .page-title{
      margin: 0 0 6px;
      font-size: clamp(1.7rem, 2.6vw, 2.2rem);
      font-weight: 900;
      letter-spacing: -0.02em;
      text-align: center;
      color: var(--mef-primary);
    }

    .page-subtitle{
      margin: 0;
      color: rgba(26,26,26,.75);
      line-height: 1.6;
      text-align: center;
      max-width: 62ch;
      margin-inline: auto;
    }

    /* Card feel similar to MEF sections */
    .card{
      background: color-mix(in srgb, var(--mef-card) 92%, transparent);
      border: 1px solid var(--mef-border);
      border-radius: 18px;
      padding: 26px;
      box-shadow: 0 10px 28px rgba(0,0,0,.08);
      margin-top: 18px;
    }

    .success{
      background: color-mix(in srgb, var(--mef-primary) 10%, white);
      color: color-mix(in srgb, var(--mef-primary) 90%, black);
      padding: 12px 14px;
      border-radius: 12px;
      margin-bottom: 18px;
      font-weight: 700;
      border: 1px solid color-mix(in srgb, var(--mef-primary) 18%, transparent);
    }

    .divider{
      border: none;
      height: 1px;
      background: var(--mef-border);
      margin: 18px 0;
    }

    .grid-2{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .field{ margin-bottom: 14px; }

    label{
      display: block;
      font-weight: 800;
      margin-bottom: 6px;
      color: var(--mef-text);
      font-size: .95rem;
    }

    input, select, textarea{
      width: 100%;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--mef-border);
      outline: none;
      background: #fff;
      color: var(--mef-text);
      font-size: 15px;
      transition: box-shadow .15s ease, border-color .15s ease, transform .06s ease;
    }

    textarea{ min-height: 130px; resize: vertical; line-height: 1.5; }

    input:focus, select:focus, textarea:focus{
      border-color: color-mix(in srgb, var(--mef-primary) 65%, var(--mef-border));
      box-shadow: 0 0 0 4px color-mix(in srgb, var(--mef-primary) 18%, transparent);
    }

    .hint{
      margin-top: 6px;
      color: var(--mef-muted);
      font-size: .92rem;
      line-height: 1.4;
    }

    .form-section-title{
      margin: 22px 0 12px;
      font-size: 1.05rem;
      font-weight: 900;
      color: var(--mef-primary);
      background: var(--mef-cream);
      border: 1px solid var(--mef-border);
      padding: 10px 12px;
      border-radius: 12px;
      letter-spacing: .02em;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .form-section-title::before{
      content: "";
      width: 10px;
      height: 10px;
      border-radius: 999px;
      background: var(--mef-accent);
      box-shadow: 0 0 0 3px color-mix(in srgb, var(--mef-accent) 25%, transparent);
      flex: 0 0 auto;
    }

    /* Buttons — align with MEF (works even if your global .btn styles change) */
    .actions{
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 20px;
      align-items: center;
      justify-content: center;
    }

    .btn{
      border-radius: 12px;
      padding: 12px 16px;
      font-weight: 900;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      border: 1px solid transparent;
      transition: transform .06s ease, background .15s ease, border-color .15s ease, box-shadow .15s ease;
      line-height: 1;
      min-height: 44px;
    }
    .btn:active{ transform: translateY(1px); }

    .btn--accent{
      background: var(--mef-accent);
      color: #111;
      border-color: color-mix(in srgb, var(--mef-accent) 60%, black);
      box-shadow: 0 10px 18px rgba(0,0,0,.10);
    }
    .btn--accent:hover{
      background: color-mix(in srgb, var(--mef-accent) 92%, black);
    }

    .btn--outline{
      background: transparent;
      color: var(--mef-primary);
      border-color: color-mix(in srgb, var(--mef-primary) 35%, var(--mef-border));
    }
    .btn--outline:hover{
      background: color-mix(in srgb, var(--mef-primary) 6%, transparent);
    }

    @media (max-width: 760px){
      .grid-2{ grid-template-columns: 1fr; }
      .card{ padding: 18px; }
      .page-wrap{ margin: 40px auto; }
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
        <button type="submit" class="btn btn--accent">Submit Nomination</button>
        <a class="btn btn--outline" href="index.php">Back to Home</a>
      </div>

    </form>
  </div>
  <div class="card" style="margin-top: 50px;">
    <!-- PASSWORD PROTECTED DOWNLOAD -->
    <?php if (isset($_SESSION['access_granted'])): ?>
      <h2 class="form-section-title" style="display: flex; justify-content: center;">Download Nomination</h2>
      <div class="actions">
        <a href="export.php" class="btn btn--accent">Download Nomination</a>
        <form method="post" style="display:inline;">
          <button type="submit" name="logout" class="btn btn--outline">Logout</button>
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
            <button type="submit" name="login" class="btn btn--accent">Unlock</button>
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