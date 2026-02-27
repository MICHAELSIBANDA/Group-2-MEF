<?php
declare(strict_types=1);

/**
 * MEF Awards — Nomination Form (UPDATED)
 * ---------------------------------------------------------
 * ✅ Covers ALL updated categories requirements in the FORM UI:
 *   - Emerging Business (includes eligibility checkboxes + required docs inputs + age hint)
 *   - AI Champion Award (includes Ethical AI confirmation checkbox + evidence uploads)
 *   - African Development Research Award (postgrad proof + profile + abstract + supporting docs)
 *   - Mamokgethi Phakeng Prize (eligibility confirmation + degree level + field + institution + graduation year + docs)
 *   - Agricultural Innovation & Impact (eligibility confirmations + required docs + age hint)
 *
 * ⚠️ NOTE (IMPORTANT):
 * The form collects everything, but "true compliance" also needs BACKEND enforcement.
 * Your submit_nomination.php should validate:
 *   - Age limits (Emerging <= 35, Agricultural <= 45)
 *   - Required checkboxes + required files per category
 *   - Phakeng graduation year >= 2021
 */

session_start();

/* =========================
   PASSWORD-PROTECTED EXPORT
   (keep as-is or improve later)
   ========================= */
$correctPassword = "1234"; // TODO: Change this to your secure password

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

if (isset($_POST['login'])) {
  if (($_POST['password'] ?? '') === $correctPassword) {
    $_SESSION['access_granted'] = true;
  } else {
    $loginError = "Incorrect password.";
  }
}

/* =========================
   DB CONNECTION
   (db.php should ONLY connect)
   ========================= */
require __DIR__ . "/config/db.php";

function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

/* =========================
   Fetch categories from DB
   ========================= */
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
       ========================================================== */
    :root{
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

    /* Buttons */
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

    /* ==============================
   Category-specific blocks (FIX)
   ============================== */
.category-block{
  display:none;                 /* JS controls visibility */
  margin-top: 12px;
  padding: 18px;
  border-radius: 16px;
  border: 1px solid var(--mef-border);
  background: color-mix(in srgb, var(--mef-card) 88%, var(--mef-cream));
  box-shadow: 0 8px 18px rgba(0,0,0,.06);
}

.category-header{
  display:flex;
  align-items:center;
  gap:10px;
  margin: 0 0 12px;
  padding: 10px 12px;
  border-radius: 12px;
  background: var(--mef-cream);
  border: 1px solid var(--mef-border);
  color: var(--mef-primary);
  font-weight: 900;
}

.category-header::before{
  content:"";
  width: 10px;
  height: 10px;
  border-radius: 999px;
  background: var(--mef-accent);
  box-shadow: 0 0 0 3px color-mix(in srgb, var(--mef-accent) 25%, transparent);
}

/* Checkbox lines */
.checkline{
  display:flex;
  gap:10px;
  align-items:flex-start;
  padding: 10px 12px;
  background: #fff;
  border: 1px solid var(--mef-border);
  border-radius: 12px;
}

.checkline input[type="checkbox"]{
  width:auto;
  margin-top: 3px;
  transform: scale(1.05);
}

.checkline span{
  font-weight: 800;
  line-height: 1.35;
}

/* Tighter textarea inside category blocks */
.category-block textarea{
  min-height: 110px;
}
  </style>
</head>

<body>
<div class="page-wrap">

  <div>
    <h1 class="page-title">MEF Awards — Nomination Form</h1>
    <p class="page-subtitle">Nominate a student who represents academic excellence, resilience, and impact.</p>
  </div>

  <?php if ($sent): ?>
  <div class="success">Nomination submitted successfully.</div>
<?php endif; ?>

<?php if (!empty($_SESSION["form_error"])): ?>
  <div style="
    background:#fee2e2;
    border:1px solid #fecaca;
    color:#991b1b;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:18px;
    font-weight:800;">
    <?= e($_SESSION["form_error"]) ?>
  </div>
  <?php unset($_SESSION["form_error"]); ?>
<?php endif; ?>

    <!-- IMPORTANT: enctype is required for uploads -->
    <form method="POST" action="submit_nomination.php" enctype="multipart/form-data">

      <!-- =========================
           AWARD CATEGORY
           ========================= -->
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

      <!-- =========================
           NOMINEE INFO
           (DOB here enables age checks in backend)
           ========================= -->
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

      <!-- Social links (optional, saved to nominee table) -->
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

      <!-- =========================
           NOMINATOR INFO
           ========================= -->
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

      <!-- =========================
           NOMINATION DETAILS
           ========================= -->
      <h2 class="form-section-title">Nomination Details</h2>

      <div class="field">
        <label for="qualification">General Motivation (required)</label>
        <textarea id="qualification" name="qualification" required
          placeholder="Explain why the nominee deserves this award..."></textarea>
        <div class="hint">This is the general motivation. You will also fill category-specific info below.</div>
      </div>

      <hr class="divider" />

      <!-- =========================
           REQUIRED DOCUMENTS (UNIVERSAL)
           - ID/Passport copy is required for all categories
           ========================= -->
      <h2 class="form-section-title">Required Documents</h2>

      <div class="field">
        <label for="id_copy">Certified ID / Passport Copy (required)</label>
        <input id="id_copy" type="file" name="id_copy" accept=".pdf,.jpg,.jpeg,.png" required>
        <div class="hint">Upload a clear certified copy (PDF/JPG/PNG).</div>
      </div>

      <div class="field">
        <label for="supporting_docs">Additional Supporting Documents (optional)</label>
        <input id="supporting_docs" type="file" name="supporting_docs[]" multiple
               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx">
        <div class="hint">Optional: letters, media coverage, publications, pitch decks, reports, etc.</div>
      </div>

      <hr class="divider" />

      <!-- =========================
           CATEGORY SPECIFIC INFORMATION
           (these blocks are shown/hidden by JS based on category name)
  <h2 class="form-section-title">Category Specific Information</h2>

<!-- Emerging Business -->
<div class="category-block" id="cat-emerging">
  <div class="category-header">Emerging Business</div>

  <div class="hint" style="margin-bottom:12px;">
    Note: Nominee must be 35 years or younger (verified from Date of Birth).
  </div>

  <div class="grid-2">
    <div class="field">
      <label class="checkline">
        <input type="checkbox" name="eb_sa_citizen" value="1">
        <span>I confirm the nominee is a South African citizen</span>
      </label>
    </div>
    <div class="field">
      <label class="checkline">
        <input type="checkbox" name="eb_founder" value="1">
        <span>I confirm the nominee is a founder/co-founder</span>
      </label>
    </div>
  </div>

  <div class="grid-2">
    <div class="field">
      <label class="checkline">
        <input type="checkbox" name="eb_registered_sa" value="1">
        <span>Business is registered & operating in South Africa</span>
      </label>
    </div>
    <div class="field">
      <label class="checkline">
        <input type="checkbox" name="eb_early_stage" value="1">
        <span>Business is early-stage</span>
      </label>
    </div>
  </div>

  <div class="field">
    <label for="eb_traction">Evidence of operations/traction (required)</label>
    <textarea id="eb_traction" name="eb_traction" placeholder="Customers, revenue, pilot, proof-of-concept, etc."></textarea>
  </div>

  <div class="grid-2">
    <div class="field">
      <label for="eb_qualification_proof">Proof of tertiary qualification (required)</label>
      <input id="eb_qualification_proof" type="file" name="eb_qualification_proof" accept=".pdf,.jpg,.jpeg,.png">
    </div>
    <div class="field">
      <label for="eb_cipc_docs">CIPC registration documents (required)</label>
      <input id="eb_cipc_docs" type="file" name="eb_cipc_docs" accept=".pdf,.jpg,.jpeg,.png">
    </div>
  </div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="eb_over_2_years" value="1">
      <span>Business is older than 2 years (requires financials + tax compliance)</span>
    </label>
  </div>

  <div class="field">
    <label for="eb_financial_tax">Financial statements + tax compliance (only if &gt; 2 years)</label>
    <input id="eb_financial_tax" type="file" name="eb_financial_tax" accept=".pdf,.jpg,.jpeg,.png">
  </div>

  <div class="field">
    <label for="eb_business_overview">Business overview (max 5 pages) (required)</label>
    <input id="eb_business_overview" type="file" name="eb_business_overview" accept=".pdf">
    <div class="hint">Include problem, target market, stage, traction, org structure. (PDF)</div>
  </div>

  <div class="field">
    <label for="eb_media">Photo/Video evidence (required)</label>
    <input id="eb_media" type="file" name="eb_media[]" multiple accept=".jpg,.jpeg,.png,.mp4,.mov,.webm">
  </div>
</div>

<!-- AI Champion -->
<div class="category-block" id="cat-ai">
  <div class="category-header">AI Champion Award</div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="ai_ethics_confirm" value="1" required>
      <span>I confirm the nominee’s contribution reflects responsible and ethical engagement with AI technologies</span>
    </label>
  </div>

  <div class="field">
    <label for="ai_profile">Detailed nominee profile (max 3 pages) (required)</label>
    <textarea id="ai_profile" name="ai_profile" placeholder="AI work undertaken, problem, how AI is applied, outcomes/impact..."></textarea>
  </div>

  <div class="field">
    <label for="ai_links">Links (optional)</label>
    <input id="ai_links" type="text" name="ai_links" placeholder="GitHub / product / platform links (comma-separated)">
  </div>

  <div class="field">
    <label for="ai_evidence">Evidence of AI-related work (required)</label>
    <input id="ai_evidence" type="file" name="ai_evidence[]" multiple
           accept=".pdf,.jpg,.jpeg,.png,.mp4,.mov,.webm">
    <div class="hint">Docs, screenshots, demo videos, reports, endorsements, etc.</div>
  </div>
</div>

<!-- African Development Research -->
<div class="category-block" id="cat-research">
  <div class="category-header">African Development Research Award</div>

  <div class="field">
    <label for="adr_postgrad_proof">Proof of postgraduate qualification (required)</label>
    <input id="adr_postgrad_proof" type="file" name="adr_postgrad_proof" accept=".pdf,.jpg,.jpeg,.png">
  </div>

  <div class="field">
    <label for="adr_profile">Nominee profile & motivation (max 2 pages) (required)</label>
    <textarea id="adr_profile" name="adr_profile"></textarea>
  </div>

  <div class="field">
    <label for="adr_abstract">Research abstract/executive summary (max 3 pages) (required)</label>
    <textarea id="adr_abstract" name="adr_abstract"
      placeholder="Problem & African context, core findings/innovation, relevance to development..."></textarea>
  </div>

  <div class="field">
    <label for="adr_support">Additional supporting materials (optional)</label>
    <input id="adr_support" type="file" name="adr_support[]" multiple
           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
  </div>
</div>

<!-- Mamokgethi Phakeng Prize -->
<div class="category-block" id="cat-phakeng">
  <div class="category-header">Mamokgethi Phakeng Prize</div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="mp_confirm_eligibility" value="1" required>
      <span>I confirm the nominee meets the eligibility requirements for this prize</span>
    </label>
    <div class="hint">We store your confirmation and capture non-sensitive academic details below.</div>
  </div>

  <div class="grid-2">
    <div class="field">
      <label for="mp_degree_level">Degree level (required)</label>
      <select id="mp_degree_level" name="mp_degree_level" required>
        <option value="">-- Select --</option>
        <option value="Masters">Masters (MSc)</option>
        <option value="PhD">PhD</option>
      </select>
    </div>
    <div class="field">
      <label for="mp_graduation_year">Graduation year (required)</label>
      <input id="mp_graduation_year" type="number" name="mp_graduation_year" min="1900" max="2100" required placeholder="e.g. 2022">
      <div class="hint">Must be 2021 or later.</div>
    </div>
  </div>

  <div class="grid-2">
    <div class="field">
      <label for="mp_field">Field (required)</label>
      <input id="mp_field" type="text" name="mp_field" required placeholder="e.g. Mathematics, Statistics, Data Science">
    </div>
    <div class="field">
      <label for="mp_institution">Institution (African university) (required)</label>
      <input id="mp_institution" type="text" name="mp_institution" required placeholder="e.g. University of Pretoria">
    </div>
  </div>

  <div class="field">
    <label for="mp_qualification_proof">Proof of qualification (required)</label>
    <input id="mp_qualification_proof" type="file" name="mp_qualification_proof" accept=".pdf,.jpg,.jpeg,.png">
  </div>

  <div class="field">
    <label for="mp_abstract">Research abstract/summary (max 2 pages) (required)</label>
    <textarea id="mp_abstract" name="mp_abstract"></textarea>
  </div>

  <div class="field">
    <label for="mp_profile">Nominee profile & motivation (max 2 pages) (required)</label>
    <textarea id="mp_profile" name="mp_profile"></textarea>
  </div>

  <div class="field">
    <label for="mp_extra">Additional materials (optional)</label>
    <input id="mp_extra" type="file" name="mp_extra[]" multiple
           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
  </div>
</div>

<!-- Agricultural Innovation & Impact -->
<div class="category-block" id="cat-agri">
  <div class="category-header">Agricultural Innovation & Impact Award</div>

  <div class="hint" style="margin-bottom:12px;">
    Note: Nominee must be 45 years or younger (verified from Date of Birth).
  </div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="agri_qualification_confirm" value="1" required>
      <span>I confirm the nominee has completed a post-school qualification</span>
    </label>
  </div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="agri_in_africa_confirm" value="1" required>
      <span>I confirm the nominee is engaged in agriculture/agribusiness in Africa</span>
    </label>
  </div>

  <div class="field">
    <label class="checkline">
      <input type="checkbox" name="agri_innovation_impact_confirm" value="1" required>
      <span>I confirm the nominee demonstrates innovation/leadership/impact in agriculture</span>
    </label>
  </div>

  <div class="field">
    <label for="agri_description">Written description (max 5 pages) (required)</label>
    <input id="agri_description" type="file" name="agri_description" accept=".pdf">
  </div>

  <div class="field">
    <label for="agri_impact">Impact statement (max 2 pages) (required)</label>
    <input id="agri_impact" type="file" name="agri_impact" accept=".pdf">
  </div>

  <div class="field">
    <label for="agri_media">Photo/Video evidence (required)</label>
    <input id="agri_media" type="file" name="agri_media[]" multiple accept=".jpg,.jpeg,.png,.mp4,.mov,.webm">
  </div>

  <div class="field">
    <label for="agri_support">Other supporting docs (optional)</label>
    <input id="agri_support" type="file" name="agri_support[]" multiple
           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
  </div>
</div>

<!-- =========================
     CATEGORY SHOW/HIDE SCRIPT
     IMPORTANT: disables hidden fields so required doesn't break
     ========================= -->
<script>
  (function(){
    const select = document.getElementById('award_category_id');

    const blocks = {
      emerging: document.getElementById('cat-emerging'),
      ai: document.getElementById('cat-ai'),
      research: document.getElementById('cat-research'),
      phakeng: document.getElementById('cat-phakeng'),
      agri: document.getElementById('cat-agri'),
    };

    function setBlockEnabled(block, enabled){
      if (!block) return;
      const fields = block.querySelectorAll('input, select, textarea, button');
      fields.forEach(el => {
        el.disabled = !enabled;
      });
    }

    function hideAll(){
      Object.values(blocks).forEach(b => {
        if (!b) return;
        b.style.display = 'none';
        setBlockEnabled(b, false);
      });
    }

    function pickBlockByName(categoryName){
      const n = (categoryName || '').toLowerCase();
      if (n.includes('emerging') && n.includes('business')) return 'emerging';
      if (n.includes('ai') && n.includes('champion')) return 'ai';
      if (n.includes('african') && n.includes('research')) return 'research';
      if (n.includes('phakeng')) return 'phakeng';
      if (n.includes('agricultural')) return 'agri';
      return null;
    }

    function showSelected(){
      hideAll();
      const option = select.options[select.selectedIndex];
      const key = pickBlockByName(option ? option.text : '');
      if (key && blocks[key]) {
        blocks[key].style.display = 'block';
        setBlockEnabled(blocks[key], true);
      }
    }

    select.addEventListener('change', showSelected);
    window.addEventListener('load', showSelected);
  })();
</script>

      <!-- =========================
           SUBMIT ACTIONS
           ========================= -->
      <div class="actions">
        <button type="submit" class="btn btn--accent">Submit Nomination</button>
        <a class="btn btn--outline" href="index.php">Back to Home</a>
      </div>

    </form>
  </div>

  <!-- =========================
       REPORT / EXPORT (password protected)
       ========================= -->
  <div class="card" style="margin-top: 50px;">
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
          <input type="password" name="password" placeholder="Enter password" required>
          <div class="actions" style="margin-top:14px;">
            <button type="submit" name="login" class="btn btn--accent">Unlock</button>
          </div>

          <?php if (isset($loginError)): ?>
            <div style="color:#dc2626; font-size:14px; margin-top:8px; font-weight:600;">
              <?= e($loginError) ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    <?php endif; ?>
  </div>

</div>
</body>
</html>