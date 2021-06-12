<nav class="navbar navbar-expand-lg navbar-dark mb-2 py-4 fixed-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="animal-data.php">Fauna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About Me</a>
                </li>
            </ul>
        </div>
        <a class="navbar-brand" href="<?= base_url() ?>"><img src="img/NG-logo-white.png" style="max-width:100px" alt=""></a>
    </div>
</nav>

<script>
    window.onscroll = function() {
        if (window.scrollY > 10) {
            document.querySelector("nav.navbar").classList.add('scrolled');
        } else {
            document.querySelector("nav.navbar").classList.remove('scrolled');
        }
    }
</script>