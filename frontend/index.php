<?php include 'header.php'; ?>

<!-- HERO / HOME -->
<section id="home" class="hero">
    <div class="container hero-content">
        <h1>Make Education Fashionable</h1>
        <p>
            Celebrating education. Inspiring futures.
            Making academic achievement something to be proud of.
            Turning learning into a lifestyle, and education into a statement of style.
        </p>

        <div class="hero-actions">
            <a href="#stories" class="btn">Join The Movement</a>
            <a href="#about" class="btn btn-outline">Learn More</a>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="content">
    <div class="container">
        <div class="card">
            <h2>About the Movement</h2>
              <p>
                  <strong>Make Education Fashionable (MEF)</strong> is a South African social movement that rebrands academic excellence and restores pride in education. 
                  It uses the glamour of fashion and the influence of celebrity culture to transform graduation, literacy, and learning into powerful status symbols.
                  MEF exists to shift the youth's perception of education from something hidden, downplayed, or labelled as “boring” into something aspirational,
                  celebrated, and confidently displayed. Its vision is to build a generation where academic regalia is as trendy as designer streetwear,
                  and where intellectual achievement is honoured and celebrated on the red carpet.
              </p>
        </div>
    </div>
</section>

<!-- STORIES / TESTIMONIALS SECTION -->
<?php
$stories = [
    [
        "name" => "Naledi Mokoena",
        "title" => "From Township Dreamer to Tech Professional",
        "short" => "Location: Soshanguve, South Africa\nField of Study: Informatics",
        "full" => "Naledi grew up sharing textbooks and studying without reliable internet access.
          She built websites for local businesses and later developed a student budgeting app.
          Today she works as a Junior Software Developer in Johannesburg.

          “Your background does not define your future. Education upgrades your life.”"
    ],
    [
        "name" => "Ayesha Daniels",
        "title" => "The Shy Student Who Became a Leader",
        "short" => "Location: Cape Town\nField of Study: Business Management",
        "full" => "After failing her first presentation, Ayesha joined a debate club and practiced weekly.
          Today she confidently manages teams as a Project Coordinator.

          “Growth starts where comfort ends.”"
    ],
    [
        "name" => "Thabo Nkosi",
        "title" => "The Comeback Graduate",
        "short" => "Location: Gauteng\nField of Study: Marketing",
        "full" => "After failing two modules, Thabo rewrote exams while working part-time.
          He now owns a digital marketing agency.

          “Delay is not defeat. Success still looks good on you.”"
    ]
];
?>

<section id="stories" class="content">
    <div class="container">
        <h2 style="text-align:center; margin-bottom:40px; color: white;">Testimonials</h2>

        <div class="stories-grid" id="storiesGrid">
            <?php foreach ($stories as $index => $story): ?>
                <div class="card story-card" onclick="openStory(<?php echo $index; ?>)">
                    <h3><?php echo $story['name']; ?></h3>
                    <h4><?php echo $story['title']; ?></h4>
                    <p><?php echo nl2br($story['short']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php foreach ($stories as $index => $story): ?>
            <div class="card full-story" id="full-<?php echo $index; ?>">
                <h2><?php echo $story['name']; ?></h2>
                <h3><?php echo $story['title']; ?></h3>
                <p><?php echo nl2br($story['full']); ?></p>
                <button class="btn" onclick="closeStory()">Back to Stories</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
function openStory(index) {
    document.getElementById('storiesGrid').style.display = 'none';
    document.getElementById('full-' + index).style.display = 'block';
}

function closeStory() {
    document.getElementById('storiesGrid').style.display = 'grid';
    document.querySelectorAll('.full-story').forEach(story => {
        story.style.display = 'none';
    });
}
</script>

<?php include 'footer.php'; ?>
