<?php
// testimony.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Share Your Testimony | MEF</title>

  <!-- Use your main theme -->
  <link rel="stylesheet" href="styles/styles.css" />

  
  <style>
    /* small page-only styles so page remains unchanged, but FORM matches join.php layout */

    /* === MEF colors (same as join.php) === */
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

    .page-wrap{ max-width: 900px; margin: 50px auto; padding: 0 16px; }
    .panel{
      background:#fff; border-radius: 18px; padding: 26px;
      box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }
    .panel h1{ margin:0 0 10px; }
    .panel p{ margin:0 0 22px; opacity:.85; }

    /* ===== FORM LAYOUT (MATCH join.php) ===== */
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

    textarea{ min-height:140px; resize:vertical; line-height:1.5; }

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
    .btn-solid:hover{ background: var(--color-accent-light); }
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

    .page-title{
  margin:0 0 6px;
  font-size:2rem;
  font-weight:900;
  letter-spacing:-0.02em;
  text-align:center;              /* center it */
  color: var(--color-primary);    /* MEF green */
}

    @media(max-width:760px){
      .grid-2{ grid-template-columns:1fr; }
      .panel{ padding:18px; }
    }
  </style>

</head>
<body>

  <div class="page-wrap">
    <div class="panel">
      <h1 class="page-title">Share Your Testimony</h1>
      <p>Your story can inspire another student to keep going. Submit it below and it will appear on the MEF website.</p>

      <form action="submit_testimony.php" method="POST">
        <h2 class="form-section-title">Your Details</h2>

        <div class="grid-2">
          <div class="field">
            <label for="full_name">Full Name</label>
            <input id="full_name" name="full_name" type="text" required />
          </div>

          <div class="field">
            <label for="email">Email (optional)</label>
            <input id="email" name="email" type="email" />
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="location">Location (optional)</label>
            <input id="location" name="location" type="text" placeholder="e.g. Pretoria" />
          </div>

          <div class="field">
            <label for="field_of_study">Field of study (optional)</label>
            <input id="field_of_study" name="field_of_study" type="text" placeholder="e.g. Computer Science" />
          </div>
        </div>

        <h2 class="form-section-title">Your Story</h2>

        <div class="field">
          <label for="title">Title</label>
          <input id="title" name="title" type="text" required placeholder="Short title of your journey" />
        </div>

        <div class="field">
          <label for="story">Your story</label>
          <textarea id="story" name="story" required placeholder="Write your testimony..."></textarea>
          <div class="hint">Share what you’ve overcome, what you learned, and how MEF has impacted you.</div>
        </div>

        <div class="field">
          <label for="quote">Short quote (optional)</label>
          <input id="quote" name="quote" type="text" placeholder="e.g. Education changed my life." />
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