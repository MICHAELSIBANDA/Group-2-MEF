<?php
// No backend logic yet – structure ready for expansion
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Stories</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            padding-top: 120px;
            font-family: Arial, sans-serif;
            background: url('Prof backpage.jpeg') no-repeat center center/cover;
            background-attachment: fixed;
        }

        .overlay {
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
        }

        .logo img {
            height: 60px;
        }

        nav a {
            margin-left: 40px;
            text-decoration: none;
            color: #1f2937;
            font-weight: 500;
        }

        nav a:hover {
            color: #2563eb;
        }

        section {
            padding: 140px 8%;
        }

        .hero {
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 800px;

        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 200px;
        }

        /* ABOUT SECTION */
        .about-section {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .about-card {
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 60px;
            border-radius: 20px;
            max-width: 900px;
            text-align: center;
        }

        .about-card h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .about-card p {
            line-height: 1.7;
            color: #e5e7eb;
        }

        .stories-section {
            margin-top: 100px;
            color: white;
        }

        .stories-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 50px;
        }

        .stories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .story-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 50px 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: 0.3s ease;
        }

        .story-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.25);
        }

        /* Name CSS */
        .story-name {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Title CSS */
        .story-title {
            font-size: 1.1rem;
            font-style: italic;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .story-card p {
            color: #e5e7eb;
        }

        .full-story {
            display: none;
            max-width: 900px;
            margin: auto;
            background: rgba(0, 0, 0, 0.85);
            padding: 60px;
            border-radius: 20px;
            text-align: center;
            color: white;
        }

        .full-story.active {
            display: block;
        }

        .full-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .full-title {
            font-size: 1.3rem;
            font-style: italic;
            color: #93c5fd;
            margin-bottom: 25px;
        }

        .full-story button {
            margin-top: 30px;
            padding: 10px 20px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        footer {
            background: rgba(0, 0, 0, 0.85);
            color: white;
            text-align: center;
            padding: 60px 8%;
            margin-top: 120px;
        }

        .social-links a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .stories-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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