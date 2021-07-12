<div class="about">
    <div class="about__img-wrapper">
        <img class="about__img" src="img/img-about/rosie-about.jpg" alt="A photograph of Rosie Piontek" 
             width="314" height="359">
    </div>
    <div class="about__txt-container">

    <?php while ($aboutSectionContent = $resultAbout->fetch()): ?>

        <p class="about__txt"><?php echo $aboutSectionContent['paragraph']; ?></p>

    <?php endwhile; ?>

    </div>
</div>