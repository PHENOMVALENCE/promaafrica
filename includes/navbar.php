<nav class="navbar">
    <div class="container">
        <div class="nav-left">
            <div class="logo">
                <a href="index.php"><img src="assets/images/2.png" alt="Proma Africa Logo"></a>
            </div>
            <div class="site-title">
                <h1>Proma Africa</h1>
                <p></p>
            </div>
        </div>
        <div class="hamburger-menu">
            <div class="menu-icon" id="menuIcon">
                <i class="fas fa-bars"></i>
            </div>
            <div class="menu-links" id="menuLinks">
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="services.php">Services</a>
                <a href="sales.php">Property Sales</a>
                <a href="news.php">News & Blogs</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar Styles */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        padding: 10px 20px;
    }

    .navbar .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 60px;
        width: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .logo:hover img {
        transform: scale(1.05);
    }

    .site-title h1 {
        font-size: 1.5rem;
        margin: 0;
        color: #333;
        font-weight: 700;
        line-height: 1.2;
    }

    .site-title p {
        font-size: 0.85rem;
        margin: 0;
        color: #666;
    }

    .hamburger-menu {
        position: relative;
    }

    .menu-icon {
        font-size: 32px;
        cursor: pointer;
        color: #f6ae01;
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .menu-icon:hover {
        transform: scale(1.1);
    }

    .menu-links {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 5px;
        display: none;
        flex-direction: column;
        min-width: 200px;
        z-index: 10;
    }

    .menu-links.show {
        display: flex;
    }

    .menu-links a {
        padding: 10px 0;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
        text-decoration: none;
    }

    .menu-links a:hover {
        color: #f6ae01;
    }

    /* Responsive Navbar */
    @media (max-width: 768px) {
        .navbar {
            padding: 8px 15px;
        }

        .logo img {
            height: 50px;
        }

        .site-title h1 {
            font-size: 1.2rem;
        }

        .site-title p {
            font-size: 0.75rem;
        }

        .menu-icon {
            font-size: 28px;
            width: 36px;
            height: 36px;
        }
    }

    @media (max-width: 480px) {
        .nav-left {
            gap: 10px;
        }

        .logo img {
            height: 45px;
        }

        .site-title h1 {
            font-size: 1rem;
        }
    }
</style>

<script>
    // JavaScript for hamburger menu toggle
    document.addEventListener("DOMContentLoaded", function () {
        const menuIcon = document.getElementById("menuIcon");
        const menuLinks = document.getElementById("menuLinks");

        menuIcon.addEventListener("click", function (event) {
            event.stopPropagation();
            menuLinks.classList.toggle("show");
        });

        document.addEventListener("click", function (event) {
            if (!menuLinks.contains(event.target) && !menuIcon.contains(event.target)) {
                menuLinks.classList.remove("show");
            }
        });
    });
</script>
