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
    /* small page-only styles so form looks clean even if styles.css doesn’t have form layouts */
    .page-wrap{ max-width: 900px; margin: 50px auto; padding: 0 16px; }
    .panel{
      background:#fff; border-radius: 18px; padding: 26px;
      box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }
    .panel h1{ margin:0 0 10px; }
    .panel p{ margin:0 0 22px; opacity:.85; }
    .grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .grid-1{ display:grid; grid-template-columns:1fr; gap:16px; }
    label{ font-weight:600; display:block; margin-bottom:6px; }
    input, textarea{
      width:100%; padding:12px 14px; border-radius:12px; border:1px solid #ddd;
      outline:none;
    }
    textarea{ min-height:140px; resize:vertical; }
    input:focus, textarea:focus{ border-color:#111; box-shadow:0 0 0 4px rgba(0,0,0,.08); }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:16px; }
    .btn-local{
      display:inline-block; padding:12px 16px; border-radius:12px; border:0;
      cursor:pointer; font-weight:700;
    }
    .btn-primary{ background:#111; color:#fff; }
    .btn-outline{ background:transparent; border:1px solid #111; color:#111; text-decoration:none; }
    @media(max-width:760px){ .grid{ grid-template-columns:1fr; } }
  </style>
</head>
<body>

  <div class="page-wrap">
    <div class="panel">
      <h1>Share Your Testimony</h1>
      <p>Your story can inspire another student to keep going. Submit it below and it will appear on the MEF website.</p>

      <form action="submit_testimony.php" method="POST">
        <div class="grid">
          <div>
            <label for="full_name">Full name</label>
            <input id="full_name" name="full_name" type="text" required />
          </div>

          <div>
            <label for="email">Email (optional)</label>
            <input id="email" name="email" type="email" />
          </div>

          <div>
            <label for="location">Location (optional)</label>
            <input id="location" name="location" type="text" placeholder="e.g. Pretoria" />
          </div>

          <div>
            <label for="field_of_study">Field of study (optional)</label>
            <input id="field_of_study" name="field_of_study" type="text" placeholder="e.g. Computer Science" />
          </div>
        </div>

        <div class="grid-1" style="margin-top:16px;">
          <div>
            <label for="title">Title</label>
            <input id="title" name="title" type="text" required placeholder="Short title of your journey" />
          </div>

          <div>
            <label for="story">Your story</label>
            <textarea id="story" name="story" required placeholder="Write your testimony..."></textarea>
          </div>

          <div>
            <label for="quote">Short quote (optional)</label>
            <input id="quote" name="quote" type="text" placeholder="e.g. Education changed my life." />
          </div>
        </div>

        <div class="actions">
          <button type="submit" class="btn-local btn-primary">Submit Testimony</button>
          <a class="btn-local btn-outline" href="index.php">Back to Home</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>