<?php
// No backend logic yet – structure ready for expansion
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Stories</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <div class="overlay">

        <header>
            <div class="logo">
                <img src="logos.png" alt="Logo">
            </div>
            <nav>
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#stories">Testimonials</a>
            </nav>
        </header>

        <section class="hero" id="home">
            <h1>Making Education Fashionable</h1>
            <p>Rebranding Excellence for Social Impact
            </p>
            <a href="join.php" class="btn">Join Movement</a>

        </section>

        <!-- ABOUT SECTION -->
        <section class="about-section" id="about">
            <div class="about-card">
                <h2>About The Movement</h2>
                <p>
                    MEF is a South African social movement that “rebrands” academic excellence. Its an initiative that
                    uses the glamour of fashion and celebrity culture to make graduation and literacy the ultimate
                    status symbols.
                    Mission: To shift the youth’s perception of education from “boring” to “aspirational”
                    Vision: To see a generation where academic regalia is as trendy as designer streetwear, and where
                    intellectual achievement is celebrated on the red carpet.

                </p>
            </div>
        </section>

        <!-- STORIES SECTION -->
        <section class="stories-section" id="stories">
            <h2>Testimonials</h2>

            <?php
            $stories = [
                [
                    "name" => "Naledi Mokoena",
                    "title" => "From Township Dreamer to Tech Professional",
                    "short" => "Location: Soshanguve, South Africa 
Field of Study: Informatics",
                    "full" => "Naledi grew up sharing textbooks and studying without reliable internet access. Long taxi rides and financial pressure made university feel impossible — but she refused to quit.
She spent late nights in campus labs, learned coding through free online resources, and built small websites for local businesses.
By her final year, she developed a student budgeting app that impressed her lecturers.
Today: Naledi works as a Junior Software Developer in Johannesburg.
Her Message:
“Your background does not define your future. Education upgrades your life.”"
                ],
                [
                    "name" => "Ayesha Daniels",
                    "title" => "The Shy Student Who Became a Leader",
                    "short" => "Location: Cape Town
Field of Study: Business Management",
                    "full" => "In her first year, Ayesha failed a presentation because she was too shy to speak in front of her classmates. She considered changing courses — or quitting.
Instead, she joined a debate club, attended mentorship sessions, and practiced public speaking every week.
Slowly, confidence replaced fear.
Today: She works as a Project Coordinator managing teams and leading meetings confidently.
Her Message:
“Growth starts where comfort ends.”"
                ],
                [
                    "name" => "Thabo Nkosi",
                    "title" => "The Comeback Graduate",
                    "short" => "Location: Gauteng
Field of Study: Marketing",
                    "full" => "After failing two modules due to financial and family pressure, Thabo thought his academic journey was over.
Instead of dropping out, he applied for academic support, rewrote his exams, and studied before sunrise while working part-time.
He graduated one year later than planned — but stronger than ever.
Today: Thabo owns a digital marketing agency serving small businesses.
His Message:
“Delay is not defeat. Success still looks good on you.”"
                ]
            ];
            ?>

            <div class="stories-grid" id="storiesGrid">
                <?php foreach ($stories as $index => $story): ?>
                    <div class="story-card" onclick="openStory(<?php echo $index; ?>)">
                        <h3 class="story-name"><?php echo $story['name']; ?></h3>
                        <h4 class="story-title"><?php echo $story['title']; ?></h4>
                        <p><?php echo nl2br($story['short']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php foreach ($stories as $index => $story): ?>
                <div class="full-story" id="full-<?php echo $index; ?>">
                    <h2 class="full-name"><?php echo $story['name']; ?></h2>
                    <h3 class="full-title"><?php echo $story['title']; ?></h3>
                    <p style="margin-top:20px;">
                        <?php echo nl2br($story['full']); ?>
                    </p>
                    <button onclick="closeStory()">Back to Testimonials</button>
                </div>
            <?php endforeach; ?>

        </section>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Student Stories Platform</p>
            <div class="social-links" style="margin-top:15px;">
                <a href="https://www.facebook.com/kgethi.phakeng">Facebook</a>
                <a href="https://www.linkedin.com/in/mamokgethi-phakeng-702b52104/">Linkedin</a>
                <a href="https://x.com/FabAcademic">Twitter</a>
                <a href="https://mamokgethi.com/">Website</a>
            </div>
        </footer>

    </div>

    <script>
        function openStory(index) {
            document.getElementById('storiesGrid').style.display = 'none';
            document.getElementById('full-' + index).classList.add('active');
        }

        function closeStory() {
            document.getElementById('storiesGrid').style.display = 'grid';
            document.querySelectorAll('.full-story').forEach(story => {
                story.classList.remove('active');
            });
        }
    </script>

</body>

</html>