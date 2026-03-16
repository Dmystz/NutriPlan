<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NutriPlan Demo</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }
    
    body { 
      background: linear-gradient(237deg, #f0ffdf 0%, #fff0f2 100%); 
      color: #333; 
      line-height: 1.6;
    }

    .container { max-width: 1200px; margin: 0 auto; padding: 1.5rem; }

    /* HEADER */
    .site-header { 
      display: flex; 
      flex-wrap: wrap; 
      justify-content: space-between; 
      align-items: center; 
      margin-bottom: 4rem; 
      padding: 1rem 0;
    }

    .logo-wrapper { display: flex; align-items: center; gap: 0.8rem; }
    .logo { width: 50px; height: 50px; object-fit: contain; }
    
    .logo-text { font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px; }
    .logo-text .span { color: #ea5c2b; }
    .logo-text .logo-text-green { color: #95cd41; }

    .main-nav { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .nav-pill { 
      padding: 0.6rem 1.2rem; 
      border-radius: 50px; 
      font-weight: 600; 
      text-decoration: none; 
      color: #fff; 
      font-size: 0.85rem; 
      transition: all 0.3s ease;
    }
    .nav-pill:hover { opacity: 0.9; transform: translateY(-2px); }
    .nav-green { background: #95cd41; box-shadow: 0 4px 10px rgba(149, 205, 65, 0.2); }
    .nav-orange { background: #ea5c2b; box-shadow: 0 4px 10px rgba(234, 92, 43, 0.2); }

    /* HERO */
    .hero-section { 
      display: flex; 
      flex-wrap: wrap; 
      gap: 4rem; 
      justify-content: center; 
      align-items: center; 
    }

    .hero-text { flex: 1 1 450px; }
    
    /* Warna Headline diperbaiki agar lebih kontras (Golden Brown dibanding Yellow cerah) */
    .headline { 
      font-weight: 800; 
      font-size: clamp(2.5rem, 5vw, 4rem); 
      color: #d4a017; 
      margin-bottom: 1.2rem; 
      line-height: 1.1; 
    }
    
    .subheadline { 
      color: #ea5c2b; 
      font-weight: 600;
      font-size: clamp(1.1rem, 2vw, 1.4rem); 
      margin-bottom: 1rem; 
    }

    .description { 
      margin-bottom: 2.5rem; 
      font-size: 1.05rem; 
      color: #555;
      max-width: 550px;
    }

    .cta-buttons { display: flex; gap: 1.2rem; flex-wrap: wrap; }
    .cta-btn { 
      padding: 0.9rem 2rem; 
      border-radius: 12px; 
      font-weight: 700; 
      text-align: center; 
      text-decoration: none; 
      color: #fff; 
      transition: all 0.3s ease;
    }
    .btn-green { background: #95cd41; box-shadow: 0 6px 15px rgba(149, 205, 65, 0.3); }
    .btn-orange { background: #ea5c2b; box-shadow: 0 6px 15px rgba(234, 92, 43, 0.3); }
    .cta-btn:hover { transform: scale(1.05); }

    /* HERO IMAGES */
    .hero-images { 
      flex: 1 1 400px; 
      display: grid; 
      grid-template-columns: repeat(3, 1fr); 
      gap: 1rem; 
    }
    
    .hero-img { 
      width: 100%; 
      height: 250px; 
      object-fit: cover; 
      border-radius: 1.5rem; 
      grid-column: span 3; 
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    /* Baris kedua gambar kecil */
    .hero-img-small { 
      width: 100%; 
      height: 100px; 
      object-fit: cover; 
      border-radius: 1rem; 
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      border: 3px solid white;
    }

    /* RESPONSIVE */
    @media(max-width:1024px) { 
      .hero-section { flex-direction: column-reverse; text-align: center; } 
      .description { margin-left: auto; margin-right: auto; }
      .cta-buttons { justify-content: center; }
      .hero-images { max-width: 500px; }
    }
    
    @media(max-width:768px) { 
      .site-header { flex-direction: column; gap: 1.5rem; } 
      .cta-buttons { flex-direction: column; width: 100%; } 
    }
  </style>
</head>
<body>

  <div class="container">
    <header class="site-header">
      <div class="logo-wrapper">
        <img src="{{ asset('image-1.png') }}" alt="NutriPlan Logo" class="logo">
        <h1 class="logo-text"><span class="span">Nutri</span><span class="logo-text-green">Plan</span></h1>
      </div>
      <nav class="main-nav">
        <a href="home" class="nav-pill nav-green">Home</a>
        <a href="home" class="nav-pill nav-orange">How It Works</a>
        <a href="home" class="nav-pill nav-green">Recipes</a>
        <a href="home" class="nav-pill nav-orange">Calculator</a>
        <a href="home" class="nav-pill nav-green">Planner</a>
        <a href="home" class="nav-pill nav-orange">Sign Up</a>
      </nav>
    </header>

    <main class="hero-section">
      <div class="hero-text">
        <h2 class="headline">Cook Smart,<br>Waste Less</h2>
        <p class="subheadline">Smart Meal Planning for a Healthier Life</p>
        <p class="description">
          Plan healthier meals based on your BMI, calorie needs, and dietary preferences. 
          NutriPlan helps you create personalized meal plans using BMI analysis, nutrition data, and smart recommendations.
        </p>
        <div class="cta-buttons">
          <a href="home" class="cta-btn btn-green">Calculate Your Plan</a>
          <a href="home" class="cta-btn btn-orange">Explore Recipes</a>
        </div>
      </div>

      <div class="hero-images">
        <img src="{{ asset('NutritionFood2.png') }}" alt="Nutrition food plate" class="hero-img">
        <img src="{{ asset('NutritionFood.png') }}" alt="Healthy meal bowl" class="hero-img-small">
        <img src="{{ asset('NutritionFood3.png') }}" alt="Smoothie bowl" class="hero-img-small">
        <img src="{{ asset('image16.png') }}" alt="Vegetables" class="hero-img-small">
      </div>
    </main>
  </div>

</body>
</html>