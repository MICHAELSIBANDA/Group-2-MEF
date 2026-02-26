<?php
declare(strict_types=1);

$success = false;

$success = false;
$error = "";

/* LOAD DATABASE CONNECTION */
require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $full_name    = trim($_POST["full_name"] ?? "");
  $email        = trim($_POST["email"] ?? "");
  $phone_number = trim($_POST["phone_number"] ?? "");
  $institution  = trim($_POST["institution"] ?? "");
  $role         = trim($_POST["role"] ?? "");
  $message      = trim($_POST["message"] ?? "");

  try {

    $stmt = $pdo->prepare("
      INSERT INTO join_requests
      (full_name, email, phone_number, institution, role, message)
      VALUES
      (:full_name, :email, :phone_number, :institution, :role, :message)
    ");

    $stmt->execute([
      ":full_name"    => $full_name,
      ":email"        => $email,
      ":phone_number" => ($phone_number === "" ? null : $phone_number),
      ":institution"  => $institution,
      ":role"         => $role,
      ":message"      => $message
    ]);

    $success = true;

  } catch (Throwable $e) {
    $error = $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>MEF | Join the Movement</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="styles/styles.css" />

  <style>
    /* === MEF colors (layout unchanged) === */
    :root{
      --color-primary:#2d5016;
      --color-primary-light:#3a6a1c;
      --color-accent:#c8952e;
      --color-accent-light:#d4a843;
      --color-background:#faf8f5;
      --color-card:#ffffff;
      --color-secondary-bg:#f5f0e8;
      --color-foreground:#1a1a1a;
      --color-foreground-soft:rgba(26,26,26,.8);
      --color-muted:#6b6355;
      --color-border:#e5ded4;
      --color-white:#ffffff;
      --font-sans: system-ui, -apple-system, Segoe UI, Arial, sans-serif;
    }

    /* Match current MEF look & feel (keep the same layout + class names) */
    body { background: var(--color-background); color: var(--color-foreground); font-family: var(--font-sans); }

  .page-wrap{ max-width: 980px; 
      margin: 48px auto; 
      padding: 0 16px;

   }

  .page-title{margin:0 0 6px; 
  font-size:2rem; 
  font-weight:900; 
  letter-spacing:-0.02em; 
  text-align:center; 
  color: var(--color-primary); }
  
    .page-subtitle{ margin:0; color: var(--color-foreground-soft); line-height:1.6; text-align:center; }

    .card{
      background: var(--color-card);
      border:1px solid var(--color-border);
      border-radius:18px;
      padding:26px;
      box-shadow:0 14px 38px rgba(0,0,0,.07);
      margin-top:18px;
    }

    .success{
      background: rgba(45,80,22,.10);
      color: var(--color-primary);
      padding:12px 14px;
      border-radius:12px;
      margin-bottom:18px;
      font-weight:800;
      border:1px solid rgba(45,80,22,.18);
    }

    /* Section heading bar (same structure, MEF palette) */
    .form-section-title{
      margin: 22px 0 12px;
      font-size: 1.1rem;
      font-weight: 900;
      color: var(--color-primary);
      background: var(--color-secondary-bg);
      border:1px solid var(--color-border);
      padding: 10px 12px;
      border-radius: 12px;
      letter-spacing: .02em;
    }

    .section-title{ margin:18px 0 12px; font-size:1.05rem; font-weight:900; color: var(--color-primary); }
    .divider{ border:none; height:1px; background: var(--color-border); margin:18px 0; }

    .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .field{ margin-bottom:14px; }

    label{
      display:block;
      font-weight:800;
      margin-bottom:6px;
      color: var(--color-foreground);
      font-size:.95rem;
    }

    input, select, textarea{
      width:100%;
      padding:12px 14px;
      border-radius:12px;
      border:1px solid var(--color-border);
      outline:none;
      background: var(--color-white);
      color: var(--color-foreground);
      font-size:15px;
      transition: box-shadow .15s ease, border-color .15s ease, transform .06s ease;
    }

    textarea{ min-height:130px; resize:vertical; line-height:1.5; }

    input:focus, select:focus, textarea:focus{
      border-color: var(--color-accent);
      box-shadow:0 0 0 4px rgba(200,149,46,.18);
    }

    .hint{ margin-top:6px; color: var(--color-muted); font-size:.92rem; line-height:1.4; }

    .actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; align-items:center; justify-content:center; }

    .btn-solid{
      border:0;
      border-radius:12px;
      padding:12px 16px;
      cursor:pointer;
      font-weight:900;
      background: var(--color-accent);
      color: #ffffff;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      transition: transform .06s ease, background .15s ease, box-shadow .15s ease;
      box-shadow: 0 10px 24px rgba(200,149,46,.22);
    }
    .btn-solid:hover{
      background: var(--color-accent-light);
    }
    .btn-solid:active{ transform: translateY(1px); }

    .btn-ghost{
      border:1px solid var(--color-border);
      border-radius:12px;
      padding:12px 16px;
      font-weight:900;
      color: var(--color-primary);
      text-decoration:none;
      background: transparent;
      display:inline-flex;
      align-items:center;
      justify-content:center;
    }
    .btn-ghost:hover{
      border-color: var(--color-accent);
      background: rgba(200,149,46,.10);
    }

    @media (max-width:760px){
      .grid-2{ grid-template-columns:1fr; }
      .card{ padding:18px; }
      .page-title{ font-size:1.7rem; }
    }
  </style>
</head>

<body>
  <div class="page-wrap">
    <div>
      <h1 class="page-title">Join the MEF Movement</h1>
      <p class="page-subtitle">Share your details and tell us how you’d like to get involved.</p>
    </div>

    <div class="card">

    <?php if ($error !== ""): ?>
  <div class="success" style="background:#ffe5e5;color:#b00020;">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

      <?php if ($success): ?>
        <div class="success">Thank you for joining the movement! We will be in touch soon.</div>
      <?php endif; ?>

      <form method="post" action="">
        <h2 class="form-section-title">Your Details</h2>

        <div class="grid-2">
          <div class="field">
            <label for="full_name">Full Name</label>
            <input id="full_name" type="text" name="full_name" required />
          </div>

          <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required />
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="phone_number">Phone Number</label>
            <input id="phone_number" type="tel" name="phone_number" placeholder="Optional" />
            <div class="hint">We’ll only use this to contact you about MEF opportunities.</div>
          </div>

          <div class="field">
            <label for="institution">Institution / Campus</label>
            <input id="institution" type="text" name="institution" required />
          </div>
        </div>

        <div class="field">
          <label for="role">Role</label>
          <select id="role" name="role" required>
            <option value="">-- Select Role --</option>
            <option value="Student">Student</option>
            <option value="Partner">Partner</option>
            <option value="Volunteer">Volunteer</option>
            <option value="Sponsor">Sponsor</option>
          </select>
        </div>

        <div class="field">
          <label for="message">How would you like to be involved?</label>
          <textarea id="message" name="message" required></textarea>
          <div class="hint">Example: campus activations, volunteering, sponsorship, mentorship, partnerships, etc.</div>
        </div>

        <div class="actions">
          <button type="submit" class="btn-solid">Submit</button>
          <a class="btn-ghost" href="index.php">Back to Home</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
