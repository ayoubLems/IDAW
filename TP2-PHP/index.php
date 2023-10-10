<?php
   require_once('template_header.php');
?>
    <div class="container">
        <header>
            <h1>Mon Site Web Personnel</h1>
            <nav class="menu">
                <ul>
                    <li><a href="index.php" class="active">Accueil</a></li>
                    <li><a href="cv.php">CV</a></li>
                    <li><a href="projets.php">Projets</a></li>
                </ul>
            </nav>
        </header>
        <div class="content">
            <section class="about">
                <h2>À propos de moi</h2>
                <img src="profile.jpg" alt="Ma photo de profil" class="profile-image">
                <p>Bienvenue sur mon site web personnel. Je suis un développeur web passionné par la création de sites web attrayants et fonctionnels.</p>
            </section>
            
            <section class="skills">
                <h2>Mes compétences</h2>
                <ul>
                    <li>Développement web front-end</li>
                    <li>Conception d'interfaces utilisateur</li>
                    <li>Intégration de sites web</li>
                    <li>Optimisation des performances</li>
                </ul>
            </section>

            <section class="contact">
                <h2>Contact</h2>
                <p>Si vous souhaitez me contacter pour discuter de projets potentiels ou pour toute autre question, n'hésitez pas à me contacter à ayoub.lemsoudi@etu.imt-nord-europe.fr</p>
            </section>

            <section class="blog">
                <h2>Blog</h2>
                <div class="blog-post">
                    <h3>Mon Site Web Personnel</h3>
                    <p>Date de publication : 10 janvier 2023</p>
                    <p>Créer un site web attrayant peut sembler intimidant</p>
                    <a href="article.html">Lire la suite</a>
                </div>
                
            </section>

        </div>
    </div>
    <footer>
        <p>&copy; 2023 IMT Nord Europe</p>
    </footer>
</body>
</html>
