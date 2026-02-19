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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">


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
            <p>
                Celebrating education. Inspiring futures.
                Making academic achievement something to be proud of.
                Turning learning into a lifestyle, and education into a statement of style.
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
                    status symbols. By showcasing real student stories of overcoming adversity, MEF aims to inspire and empower young
                    people to pursue their education with pride and confidence. We believe that when education is
                    fashionable, success becomes a lifestyle.
                </p>
                <p>
                    <b>Mission:</b>To shift the youth's perception of education from “boring” to “aspirational”. 
                </p>
                <p>
                    <b>Vision:</b> To see a generation where academic regalia is as trendy as designer streetwear, and where
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
            <div class="footer-socials">
                <a href="https://facebook.com/kgethi.phakeng" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="https://twitter.com/@FabAcademic" target="_blank" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>

                <a href="https://linkedin.com/in/mamokgethiphakeng" target="_blank" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>

            <p>&copy; <?php echo date("Y"); ?> Make Education Fashionable. All rights reserved.</p>
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