<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>MEF | Awards Categories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles/styles.css" />

  <style>
    body {
      background: var(--color-background);
      color: var(--color-foreground);
    }

    .page-wrap {
      max-width: 1100px;
      margin: 60px auto;
      padding: 0 20px;
    }

    .page-topbar{
      display:flex;
      align-items:center;
      justify-content:flex-start;
      margin-bottom: 18px;
    }
    .page-topbar .btn{
      border-radius: 999px;
    }

    .page-title {
      font-size: 2.6rem;
      font-weight: 900;
      text-align: center;
      color: var(--color-primary);
      margin-bottom: 12px;
      letter-spacing: -0.03em;
    }

    .page-subtitle {
      text-align: center;
      max-width: 720px;
      margin: 0 auto 40px;
      color: var(--color-foreground-soft);
      line-height: 1.7;
    }

    .awards-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }

    .award-card {
      background: var(--color-card);
      border: 1px solid var(--color-border);
      border-radius: 20px;
      padding: 22px;
      box-shadow: var(--shadow-md);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform .2s ease, box-shadow .2s ease;
      cursor: pointer; /* ✅ clickable card */
      outline: none;
    }

    .award-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.08);
    }

    .award-card:focus-visible{
      box-shadow: 0 0 0 4px rgba(45, 80, 22, 0.15), var(--shadow-md);
    }

    .award-title {
      font-family: var(--font-serif);
      font-size: 1.25rem;
      font-weight: 800;
      margin-bottom: 10px;
      color: var(--color-primary);
    }

    .award-desc {
      font-size: 0.95rem;
      line-height: 1.6;
      color: var(--color-foreground-soft);
      margin-bottom: 18px;
    }

    .award-actions {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* ==========================
       ✅ Modal (Popup) Styles
       ========================== */
    .mef-modal {
      position: fixed;
      inset: 0;
      display: none;
      z-index: 9999;
    }
    .mef-modal.is-open { display: block; }

    .mef-modal__backdrop {
      position: absolute;
      inset: 0;
      background: rgba(17, 24, 39, 0.55);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    .mef-modal__panel {
      position: relative;
      max-width: 860px;
      margin: 70px auto;
      padding: 0;
      border-radius: 18px;
      background: var(--color-card);
      border: 1px solid var(--color-border);
      box-shadow: 0 30px 80px rgba(0,0,0,0.25);
      overflow: hidden;
    }

    .mef-modal__header {
      padding: 18px 20px;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 14px;
      border-bottom: 1px solid var(--color-border);
      background: linear-gradient(180deg, rgba(45,80,22,0.06), rgba(45,80,22,0));
    }

    .mef-modal__title {
      margin: 0;
      font-size: 1.25rem;
      font-weight: 900;
      color: var(--color-primary);
      letter-spacing: -0.01em;
    }

    .mef-modal__close {
      border: 1px solid var(--color-border);
      background: var(--color-card);
      border-radius: 12px;
      width: 40px;
      height: 40px;
      font-size: 22px;
      line-height: 1;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .mef-modal__body {
      padding: 18px 20px 22px;
      color: var(--color-foreground);
    }

    .mef-modal__section {
      margin: 14px 0 0;
      padding: 14px 14px;
      border: 1px solid var(--color-border);
      border-radius: 14px;
      background: rgba(255,255,255,0.65);
    }

    .mef-modal__h {
      margin: 0 0 10px;
      font-size: 0.95rem;
      font-weight: 900;
      color: var(--color-primary);
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }

    .mef-modal__list {
      margin: 0;
      padding-left: 18px;
      color: var(--color-foreground-soft);
      line-height: 1.7;
      font-size: 0.97rem;
    }

    .mef-modal__footer {
      padding: 16px 20px 20px;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      border-top: 1px solid var(--color-border);
      background: rgba(250,248,245,0.6);
    }

    @media (max-width: 980px) {
      .awards-grid { grid-template-columns: repeat(2, 1fr); }
      .mef-modal__panel { margin: 40px 16px; }
    }
    @media (max-width: 640px) {
      .awards-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="page-wrap">

  <div class="page-topbar">
    <button type="button" class="btn btn--outline" onclick="history.back()">
      ← Back
    </button>
  </div>

  <h1 class="page-title">Awards Categories</h1>
  <p class="page-subtitle">
    Explore MEF’s structured awards and nominate individuals who demonstrate excellence, innovation, leadership and measurable impact.
  </p>

  <div class="awards-grid">

    <!-- Emerging Business -->
    <div class="award-card" tabindex="0" role="button" data-details="emerging" aria-label="View Emerging Business details">
      <div>
        <div class="award-title">Emerging Business</div>
        <div class="award-desc">
          Recognising young founders building legally registered, early-stage businesses with innovation and measurable traction.
        </div>
      </div>
      <div class="award-actions">
        <a href="form.php?category=emerging" class="btn btn--accent">Nominate</a>
        <button type="button" class="btn btn--outline js-details" data-details="emerging">View Details</button>
      </div>
    </div>

    <!-- African Development Research -->
    <div class="award-card" tabindex="0" role="button" data-details="research" aria-label="View African Development Research details">
      <div>
        <div class="award-title">African Development Research</div>
        <div class="award-desc">
          Honouring postgraduate research addressing significant African challenges with clear development relevance and impact.
        </div>
      </div>
      <div class="award-actions">
        <a href="form.php?category=research" class="btn btn--accent">Nominate</a>
        <button type="button" class="btn btn--outline js-details" data-details="research">View Details</button>
      </div>
    </div>

    <!-- AI Champion -->
    <div class="award-card" tabindex="0" role="button" data-details="ai" aria-label="View AI Champion details">
      <div>
        <div class="award-title">AI Champion</div>
        <div class="award-desc">
          Celebrating meaningful AI contributions across the African continent — innovation, ethics and transformative application.
        </div>
      </div>
      <div class="award-actions">
        <a href="form.php?category=ai" class="btn btn--accent">Nominate</a>
        <button type="button" class="btn btn--outline js-details" data-details="ai">View Details</button>
      </div>
    </div>

    <!-- Mamokgethi Phakeng Prize -->
    <div class="award-card" tabindex="0" role="button" data-details="mamokgethi" aria-label="View Mamokgethi Phakeng Prize details">
      <div>
        <div class="award-title">Mamokgethi Phakeng Prize</div>
        <div class="award-desc">
          Recognising Black African South African women advancing excellence in the mathematical sciences.
        </div>
      </div>
      <div class="award-actions">
        <a href="form.php?category=mamokgethi" class="btn btn--accent">Nominate</a>
        <button type="button" class="btn btn--outline js-details" data-details="mamokgethi">View Details</button>
      </div>
    </div>

    <!-- Agricultural Innovation -->
    <div class="award-card" tabindex="0" role="button" data-details="agri" aria-label="View Agricultural Innovation & Impact details">
      <div>
        <div class="award-title">Agricultural Innovation & Impact</div>
        <div class="award-desc">
          Spotlighting young leaders driving measurable innovation, sustainability and impact within agriculture.
        </div>
      </div>
      <div class="award-actions">
        <a href="form.php?category=agri" class="btn btn--accent">Nominate</a>
        <button type="button" class="btn btn--outline js-details" data-details="agri">View Details</button>
      </div>
    </div>

  </div>
</div>

<!-- ✅ Modal Markup -->
<div class="mef-modal" id="mefModal" aria-hidden="true">
  <div class="mef-modal__backdrop" data-close="true"></div>

  <div class="mef-modal__panel" role="dialog" aria-modal="true" aria-labelledby="mefModalTitle">
    <div class="mef-modal__header">
      <h3 class="mef-modal__title" id="mefModalTitle">Category Details</h3>
      <button class="mef-modal__close" type="button" aria-label="Close" id="mefModalClose">&times;</button>
    </div>

    <div class="mef-modal__body" id="mefModalBody"></div>

    <div class="mef-modal__footer">
      <button type="button" class="btn btn--outline" id="mefModalClose2">Close</button>
    </div>
  </div>
</div>

<script>
  // ✅ Details content (from MEF UPDATED CATEGORIES.docx)
  const CATEGORY_DETAILS = {
    emerging: {
      title: "Emerging Business",
      eligibility: [
        "- The nominee must be 35 years of age or younger at the time of nomination.",
        "- The nominee must have completed a post-school qualification from an accredited university or TVET college.",
        "- The nominee must be a South African citizen.",
        "- The nominee must be a founder or co-founder of the business.",
        "- The business must be legally registered and operating within South Africa.",
        "- The business must be in its early-stage phase.",
        "- The nominee must demonstrate evidence of active operations (e.g., product development, pilot projects, initial customers, early revenue, or proof of concept)."
      ],
      documentation: [
        "- Certified copy of identity document.",
        "- Proof of tertiary qualification.",
        "- CIPC registration documents of the business.",
        "- Financial statements + proof of tax compliance (if business is older than 2 years).",
        "- Photo or video evidence.",
        "- Business overview (maximum 5 pages) outlining: problem being solved & target market, current stage of development, evidence of traction/early results, and organisational structure.",
        "- Any additional supporting documents (pitch decks, media coverage, partnership letters, impact reports, etc.)."
      ]
    },

    research: {
      title: "African Development Research Award",
      eligibility: [
        "- The nominee must have completed or be completing a master’s, doctoral, or postdoctoral qualification from a recognized African higher education institution.",
        "- The research must clearly address a significant challenge faced by Africa (local, national, regional, or continental).",
        "- The research must show clear relevance to development outcomes (policy influence, innovation, community engagement, sustainability, economic advancement, or social improvement)."
      ],
      documentation: [
        "- Proof of postgraduate qualification.",
        "- Certified copy of ID or passport.",
        "- Nominee profile and motivation (maximum 2 pages).",
        "- Research abstract/executive summary (maximum 3 pages) outlining: the problem & African context; core findings/innovation; relevance to development/societal improvement.",
        "- Additional supporting materials (policy briefs, publications, implementation evidence, media coverage, and/or letters)."
      ]
    },

    ai: {
      title: "AI Champion Award",
      eligibility: [
        "- The nominee must be actively involved in artificial intelligence or digital innovation work.",
        "- The nominee may be a developer, researcher, entrepreneur, educator, practitioner, or advocate.",
        "- The nominee’s work must demonstrate measurable impact, meaningful innovation, or clear potential for transformative application.",
        "- The nominee’s contribution must reflect responsible and ethical engagement with AI technologies.",
        "- Open to individuals across the African continent.",
        "- No strict educational threshold — emphasis is on contribution and impact."
      ],
      documentation: [
        "- Copy of ID or passport.",
        "- Detailed nominee profile (maximum 3 pages) outlining: nature of AI work, problem being addressed, how AI is applied, and measurable outcomes/impact.",
        "- Evidence of AI-related work (e.g., links to platforms/tools/products, technical documentation/project summaries, research abstracts/thesis summaries, training programme outlines, policy contributions/governance documents, media coverage/awards).",
        "- Where applicable: letters of endorsement, implementation reports, or partnership confirmations demonstrating real-world application.",
        "- For deployed AI systems: demonstrable evidence (screenshots, access links, short demo videos, or public repositories)."
      ]
    },

    mamokgethi: {
      title: "Mamokgethi Phakeng Prize",
      eligibility: [
        "- The nominee must be a Black African South African woman.",
        "- The nominee must have completed a Master’s or PhD in the mathematical sciences (pure mathematics, mathematics education, applied mathematics, statistics, data science, or related fields).",
        "- Qualification must have been completed at a recognized African university.",
        "- The nominee must have graduated in or after 2021."
      ],
      documentation: [
        "- Certified copy of ID.",
        "- Proof of qualification.",
        "- Research abstract or research summary (maximum 2 pages).",
        "- Nominee profile and motivation (maximum 2 pages).",
        "- Additional material (optional): publications, awards, conference presentations."
      ]
    },

    agri: {
      title: "Agricultural Innovation & Impact Award",
      eligibility: [
        "- The nominee must be 45 years of age or younger at the time of nomination.",
        "- The nominee must have completed a post-school qualification from an accredited university or TVET college.",
        "- The nominee must be engaged in an agricultural or agribusiness activity within Africa.",
        "- The nominee must demonstrate clear evidence of innovation, leadership, or measurable impact within the agricultural sector.",
        "- Open to nominees across the African continent."
      ],
      documentation: [
        "- Certified copy of ID or passport.",
        "- Written description (maximum 5 pages) outlining: nature of operation, location, type of activity, organogram, duration of involvement, and scale of operations.",
        "- Written impact statement (maximum 2 pages) detailing measurable contribution to food security, employment, community development, innovation, or sustainability.",
        "- Clear and recent video/photo evidence showing actual farming activity, facilities, crops/livestock, technology application, or processing operations.",
        "- Any other supporting documents (community partner letters, supply contracts, production records, research outputs, media coverage, environmental certifications)."
      ]
    }
  };

  const modal = document.getElementById("mefModal");
  const modalTitle = document.getElementById("mefModalTitle");
  const modalBody = document.getElementById("mefModalBody");
  const closeBtn = document.getElementById("mefModalClose");
  const closeBtn2 = document.getElementById("mefModalClose2");

  let lastFocusEl = null;

  function esc(str){
    return String(str).replace(/[&<>"']/g, m => ({
      "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
    }[m]));
  }

  function buildList(items){
    return `<ul class="mef-modal__list">${items.map(i => `<li>${esc(i)}</li>`).join("")}</ul>`;
  }

  function openDetails(key, focusEl){
    const data = CATEGORY_DETAILS[key];
    if(!data) return;

    lastFocusEl = focusEl || document.activeElement;

    modalTitle.textContent = data.title;

    modalBody.innerHTML = `
      <div class="mef-modal__section">
        <div class="mef-modal__h">Eligibility requirements</div>
        ${buildList(data.eligibility)}
      </div>

      <div class="mef-modal__section">
        <div class="mef-modal__h">Required submission documentation</div>
        ${buildList(data.documentation)}
      </div>
    `;

    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");

    // focus close for accessibility
    closeBtn.focus();
    document.body.style.overflow = "hidden";
  }

  function closeModal(){
    modal.classList.remove("is-open");
    modal.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";

    if(lastFocusEl && typeof lastFocusEl.focus === "function"){
      lastFocusEl.focus();
    }
  }

  // click handlers
  document.addEventListener("click", (e) => {
    // close
    if(e.target?.dataset?.close === "true") closeModal();

    // button
    const btn = e.target.closest(".js-details");
    if(btn){
      e.preventDefault();
      openDetails(btn.dataset.details, btn);
      return;
    }

    // card click (BUT ignore if clicking on Nominate link/button area)
    const card = e.target.closest(".award-card");
    if(card){
      const isNominate = e.target.closest("a[href^='form.php']");
      if(isNominate) return; // let nomination navigate
      openDetails(card.dataset.details, card);
    }
  });

  // keyboard open on card (Enter/Space)
  document.addEventListener("keydown", (e) => {
    if(e.key === "Escape" && modal.classList.contains("is-open")){
      closeModal();
      return;
    }

    const activeCard = document.activeElement?.classList?.contains("award-card") ? document.activeElement : null;
    if(activeCard && (e.key === "Enter" || e.key === " ")){
      e.preventDefault();
      openDetails(activeCard.dataset.details, activeCard);
    }
  });

  closeBtn.addEventListener("click", closeModal);
  closeBtn2.addEventListener("click", closeModal);
</script>

</body>
</html>