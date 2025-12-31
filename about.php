<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#f6ae01">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <title>About Us - Proma Africa | Leading Property Survey & Real Estate Experts</title>
    <meta name="description" content="Learn about Proma Africa's mission, vision, and expert team. Discover our story as Tanzania's leading Property Survey and real estate consultancy firm.">
    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/text-justify-updates.css">
    <link rel="stylesheet" href="assets/css/stylesss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #f6ae01;
            --primary-hover: #e29f01;
            --secondary-color: #0056b3;
            --text-dark: #333;
            --text-medium: #555;
            --text-light: #777;
            --bg-light: #f9f9f9;
            --bg-white: #fff;
            --shadow-sm: 0 2px 6px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.1);
            --border-radius-sm: 5px;
            --border-radius-md: 8px;
            --border-radius-lg: 10px;
            --border-radius-xl: 50px;
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.4s ease;
            --spacing-xs: 5px;
            --spacing-sm: 10px;
            --spacing-md: 15px;
            --spacing-lg: 20px;
            --spacing-xl: 30px;
            --spacing-2xl: 40px;
            --spacing-3xl: 60px;
            --container-padding: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }

        /* Enhanced Page Header */
        .page-header {
            height: 60vh;
            min-height: 400px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/images/b4.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(246, 174, 1, 0.1), rgba(0, 86, 179, 0.1));
            animation: gradientShift 8s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }

        .header-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 var(--spacing-lg);
        }

        .header-content h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: var(--spacing-lg);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        .header-content p {
            font-size: clamp(1rem, 2vw, 1.3rem);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.8s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced About Details Section */
        .about-details {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-white);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: var(--spacing-3xl);
            align-items: center;
        }

        .about-image {
            position: relative;
        }

        .about-img {
            width: 100%;
            height: auto;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            transition: transform var(--transition-normal);
        }

        .about-img:hover {
            transform: scale(1.05);
        }

        .about-text h2 {
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .about-text h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .about-text h3 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }

        .about-text p {
            margin-bottom: var(--spacing-lg);
            color: var(--text-medium);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Enhanced Mission Vision Section */
        .mission-vision {
            padding: var(--spacing-3xl) 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .mission-vision::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .mission-vision .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-2xl);
            position: relative;
            z-index: 2;
        }

        .mission, .vision {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            text-align: center;
            transition: all var(--transition-normal);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mission:hover, .vision:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .mission h3, .vision h3 {
            font-size: 1.8rem;
            margin-bottom: var(--spacing-lg);
            color: white;
        }

        .mission p, .vision p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Enhanced Core Values Section */
        .core-values {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-light);
        }

        .core-values h2 {
            text-align: center;
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-3xl);
            position: relative;
        }

        .core-values h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-xl);
        }

        .value-card {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .value-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: var(--spacing-lg);
            transition: transform var(--transition-normal);
        }

        .value-card:hover i {
            transform: scale(1.1);
        }

        .value-card h3 {
            color: var(--text-dark);
            font-size: 1.5rem;
            margin-bottom: var(--spacing-md);
        }

        .value-card p {
            color: var(--text-medium);
            line-height: 1.6;
        }

        /* Enhanced Team Section */
        .team {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-white);
        }

        .team h2 {
            text-align: center;
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .team h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-medium);
            font-size: 1.1rem;
            margin-bottom: var(--spacing-3xl);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-2xl);
            margin-bottom: var(--spacing-3xl);
        }

        .team-member {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .member-image {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform var(--transition-normal);
        }

        .team-member:hover .member-image img {
            transform: scale(1.1);
        }

        .member-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(246, 174, 1, 0.8), rgba(0, 86, 179, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .team-member:hover .member-overlay {
            opacity: 1;
        }

        .member-social {
            display: flex;
            gap: var(--spacing-md);
        }

        .member-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all var(--transition-normal);
        }

        .member-social a:hover {
            background-color: white;
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .member-info {
            padding: var(--spacing-xl);
        }

        .member-info h3 {
            color: var(--text-dark);
            font-size: 1.3rem;
            margin-bottom: var(--spacing-sm);
        }

        .position {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: var(--spacing-md);
        }

        .member-info p {
            color: var(--text-medium);
            line-height: 1.6;
        }

        /* Directors Message */
        .directors-message {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            box-shadow: var(--shadow-md);
            text-align: center;
            position: relative;
        }

        .directors-message h2 {
            color: var(--text-dark);
            font-size: 2rem;
            margin-bottom: var(--spacing-xl);
        }

        .quote-container {
            position: relative;
            font-style: italic;
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--text-medium);
        }

        .quote-icon {
            font-size: 2rem;
            color: var(--primary-color);
            opacity: 0.3;
        }

        .quote-icon.right {
            float: right;
        }

        /* Why Choose Section */
        .why-choose {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-light);
        }

        .why-choose h2 {
            text-align: center;
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-3xl);
            position: relative;
        }

        .why-choose h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-xl);
        }

        .feature-card {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .feature-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: var(--spacing-lg);
            transition: transform var(--transition-normal);
        }

        .feature-card:hover i {
            transform: scale(1.1);
        }

        .feature-card h3 {
            color: var(--text-dark);
            font-size: 1.5rem;
            margin-bottom: var(--spacing-md);
        }

        .feature-card p {
            color: var(--text-medium);
            line-height: 1.6;
        }

        /* Enhanced CTA Section */
        .cta-section {
            padding: var(--spacing-3xl) 0;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('assets/images/b4.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(246, 174, 1, 0.1), rgba(0, 86, 179, 0.1));
            animation: gradientShift 8s ease-in-out infinite alternate;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-xl);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .cta-button {
            display: inline-block;
            padding: 18px 36px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius-xl);
            font-weight: 600;
            font-size: 1.1rem;
            transition: all var(--transition-normal);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(246, 174, 1, 0.3);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-normal);
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* Progress Bar */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background-color: var(--primary-color);
            z-index: 9999;
            width: 0;
            transition: width 0.2s ease-out;
        }

        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-white);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .preloader.preloader-hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px var(--container-padding);
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .logo {
            margin-right: 15px;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        .site-title h1 {
            font-size: 1.5rem;
            margin: 0;
            color: var(--text-dark);
        }

        .hamburger-menu {
            position: relative;
        }

        .menu-icon {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .menu-icon:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .menu-links {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: var(--bg-white);
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding: 80px 20px 20px;
            transition: right 0.3s ease;
            z-index: 1001;
            overflow-y: auto;
        }

        .menu-links.show {
            right: 0;
        }

        .menu-links a {
            padding: 15px;
            color: var(--text-dark);
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .menu-links a:hover,
        .menu-links a.active {
            color: var(--primary-color);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.5rem;
            color: var(--text-dark);
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Footer Styles */
        .footer {
            background-color: #222;
            color: var(--bg-white);
            padding: var(--spacing-3xl) 0 var(--spacing-lg);
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: var(--spacing-2xl);
            margin-bottom: var(--spacing-2xl);
        }

        .footer-logo {
            flex: 1;
            min-width: 250px;
        }

        .footer-logo img {
            max-width: 150px;
            margin-bottom: var(--spacing-md);
        }

        .footer-logo p {
            color: #ccc;
            font-size: 1rem;
        }

        .footer-links {
            flex: 1;
            min-width: 200px;
        }

        .footer-links h4 {
            font-size: 1.2rem;
            margin-bottom: var(--spacing-lg);
            color: var(--bg-white);
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: var(--spacing-sm);
        }

        .footer-links a {
            color: #ccc;
            transition: color var(--transition-normal);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-newsletter {
            flex: 1;
            min-width: 250px;
        }

        .footer-newsletter h4 {
            font-size: 1.2rem;
            margin-bottom: var(--spacing-lg);
            color: var(--bg-white);
        }

        .footer-newsletter p {
            color: #ccc;
            margin-bottom: var(--spacing-md);
        }

        .newsletter-form {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }

        .newsletter-form input {
            flex: 1;
            min-width: 200px;
            padding: 10px 15px;
            border: none;
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
        }

        .newsletter-form button {
            background-color: var(--primary-color);
            color: var(--bg-white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            cursor: pointer;
            transition: background-color var(--transition-normal);
        }

        .newsletter-form button:hover {
            background-color: var(--primary-hover);
        }

        .footer-bottom {
            text-align: center;
            padding-top: var(--spacing-lg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #999;
        }

        /* Responsive Design */
        @media screen and (max-width: 992px) {
            .about-content {
                grid-template-columns: 1fr;
                gap: var(--spacing-2xl);
            }

            .mission-vision .container {
                grid-template-columns: 1fr;
                gap: var(--spacing-xl);
            }

            .page-header {
                background-attachment: scroll;
            }

            .cta-section {
                background-attachment: scroll;
            }
        }

        @media screen and (max-width: 768px) {
            .page-header {
                margin-top: 70px;
                height: 50vh;
                min-height: 300px;
            }

            .values-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                gap: var(--spacing-xl);
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }
        }

        @media screen and (max-width: 480px) {
            .about-text,
            .mission,
            .vision,
            .value-card,
            .feature-card {
                padding: var(--spacing-lg);
            }

            .directors-message {
                padding: var(--spacing-lg);
            }

            .quote-container {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar"></div>

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
                    <a href="about.php" class="active">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="news.php">News & Blogs</a>
                    <a href="contact.php">Contact</a>
                    <a href="#" class="close-btn" id="closeBtn"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <section class="page-header" data-aos="fade-in">
        <div class="header-content">
            <h1>About Proma Africa</h1>
            <p><i>Discover our story, mission, and the team behind our success</i></p>
        </div>
    </section>

    <section id="about-details" class="about-details">
        <div class="container">
            <div class="about-content">
                <div class="about-image" data-aos="fade-right" data-aos-duration="1000">
                    <img src="assets/images/2.png" alt="Proma Africa Team" class="about-img">
                </div>
                <div class="about-text" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <h2>Company Profile: Proma Africa</h2>
                    <h3>Company Overview</h3>
                    <p>Proma Africa is a multifaceted company specialized in Real estate services, (Sale/Purcahse/Lease/Rental), Property Survey, Land administration, Resettlement consultancy. Our clients include Corporations (Banks, Investors, Real Estate Developers, Insurers, Brokers), Private Individuals, Partnerships, all other Businesses, Farming Concerns, Heritage, Government and Institutional Organizations.</p>


                </div>
            </div>
        </div>
    </section>

    <section class="mission-vision">
        <div class="container">
            <div class="mission" data-aos="fade-up" data-aos-duration="800">
                <h3>Our Mission</h3>
                <p>To transform the real estate industry by delivering innovative solutions and expert consultancy, enabling clients to make informed decisions and achieve exceptional results.</p>
            </div>
            <div class="vision" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <h3>Our Vision</h3>
                <p>To be a leading force in transforming property survey, land administration, real estate, and resettlement through innovative technology and expert consultancy—driving efficiency, transparency, and sustainability for all stakeholders.</p>
            </div>
        </div>
    </section>

    <section class="core-values">
        <div class="container">
            <h2 data-aos="fade-up">Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-handshake"></i>
                    <h3>Integrity</h3>
                    <p>We uphold the highest ethical standards in all our operations, ensuring transparency and honesty in every interaction.</p>
                </div>
                <div class="value-card" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Innovation</h3>
                    <p>We continuously seek new and better ways to deliver value to our clients through technological advancement and creative solutions.</p>
                </div>
                <div class="value-card" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Confidentiality</h3>
                    <p>All client information is handled with strict discretion and protected with utmost care to ensure privacy and trust.</p>
                </div>
                <div class="value-card" data-aos="zoom-in" data-aos-delay="400">
                    <i class="fas fa-chart-line"></i>
                    <h3>Excellence</h3>
                    <p>We strive for excellence in every aspect of our business, consistently delivering high-quality services that exceed expectations.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="team">
        <div class="container">
            <h2 data-aos="fade-up">Our Expert Team</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Meet the professionals behind our success</p>
            <div class="team-grid">
                <div class="team-member" data-aos="fade-up" data-aos-delay="200">
                    <div class="member-image">
                        <img src="assets/images/c2.jpg" alt="FRV. HUMPHREY PROTAS">
                        <div class="member-overlay">
                           
                        </div>
                    </div>
                    <div class="member-info">
                        <h3>FRV. Humphrey Protas</h3>
                        <p class="position">Director</p>
                        <p>A key leader at Proma Africa, FRV. Humphrey Protas is instrumental in driving our strategic goals and ensuring our services meet the highest standards.</p>
                    </div>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-delay="300">
                    <div class="member-image">
                        <img src="assets/images/c1.jpg" alt="PRV. BARAKA Masawe">
                        <div class="member-overlay">

                        </div>
                    </div>
                    <div class="member-info">
                        <h3>PRV. Baraka Masawe</h3>
                        <p class="position">Director</p>
                        <p>PRV. Baraka Masawe plays a crucial role in our leadership team, contributing significantly to our growth and success in the real estate sector.</p>
                    </div>
                </div>
            </div>
            <div class="directors-message" data-aos="fade-up" data-aos-delay="400">
                <h2>Word From Our Directors</h2>
                <div class="quote-container">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p>Our goal is to lead the transformation of Property survey, land administration, the real estate industry, and resettlement by leveraging innovative technology and expert consultancy. We strive to enhance efficiency, transparency, and sustainability, delivering exceptional value to all stakeholders.</p>
                    <i class="fas fa-quote-right quote-icon right"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="why-choose">
        <div class="container">
            <h2 data-aos="fade-up">Why Choose Proma Africa</h2>
            <div class="features-grid">
                <div class="feature-card" data-aos="flip-up" data-aos-delay="100">
                    <i class="fas fa-award"></i>
                    <h3>Expert Knowledge</h3>
                    <p>Our team comprises industry experts with extensive experience in Property Survey, land administration, and real estate services.</p>
                </div>
                <div class="feature-card" data-aos="flip-up" data-aos-delay="200">
                    <i class="fas fa-globe-africa"></i>
                    <h3>Local Expertise</h3>
                    <p>With deep understanding of local markets and regulations across Africa, we provide context-specific solutions.</p>
                </div>
                <div class="feature-card" data-aos="flip-up" data-aos-delay="300">
                    <i class="fas fa-tools"></i>
                    <h3>Innovative Approach</h3>
                    <p>We leverage cutting-edge technology and methodologies to deliver accurate, efficient, and forward-thinking services.</p>
                </div>
                <div class="feature-card" data-aos="flip-up" data-aos-delay="400">
                    <i class="fas fa-check-circle"></i>
                    <h3>Proven Track Record</h3>
                    <p>Our portfolio of successful projects demonstrates our capability to deliver exceptional results for diverse clients.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section" data-aos="fade-up">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Get Started?</h2>
                <a href="contact.php" class="cta-button">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Back to top button -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="assets/images/1.png" alt="Proma Africa Logo">
                    <p>Your trusted partner in Property Survey and real estate services.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="news.php">News & Blogs</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                    <h4>Newsletter</h4>
                    <p>Subscribe to our newsletter for the latest updates</p>
                    <form class="newsletter-form" action="subscribe.php" method="POST">
                        <input type="email" name="email" placeholder="Your Email Address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            preloader.classList.add('preloader-hide');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });

        // Enhanced hamburger menu
        const menuIcon = document.getElementById('menuIcon');
        const menuLinks = document.getElementById('menuLinks');
        const closeBtn = document.getElementById('closeBtn');
        
        function toggleBodyScroll(isOpen) {
            document.body.style.overflow = isOpen ? 'hidden' : '';
        }

        menuIcon.addEventListener('click', function() {
            menuLinks.classList.add('show');
            toggleBodyScroll(true);
        });

        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            menuLinks.classList.remove('show');
            toggleBodyScroll(false);
        });

        document.addEventListener('click', function(event) {
            if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target)) {
                menuLinks.classList.remove('show');
                toggleBodyScroll(false);
            }
        });

        // Progress bar
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.querySelector('.progress-bar').style.width = scrolled + '%';
        });

        // Back to top button
        const backToTopButton = document.querySelector('.back-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Interactive value cards
        const valueCards = document.querySelectorAll('.value-card');
        valueCards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'translateY(-15px) scale(1.05)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // Interactive feature cards
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'translateY(-15px) scale(1.05)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // Team member interactions
        const teamMembers = document.querySelectorAll('.team-member');
        
        teamMembers.forEach(member => {
            member.addEventListener('click', function() {
                const hasActiveClass = this.classList.contains('active');
                
                teamMembers.forEach(m => m.classList.remove('active'));
                
                if (!hasActiveClass) {
                    this.classList.add('active');
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
