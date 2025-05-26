<!DOCTYPE html>
<?php
// Konstante
define('COMPANY_NAME', 'Laced Lifestyle');

// Variabla
$companyYear = 1999;
$currentYear = date("Y");
$yearsInBusiness = $currentYear - $companyYear;

// String funksion
$upperCompanyName = strtoupper(COMPANY_NAME);

// Paraqitja e string funksionev
function yearsInBusiness($startYear) {
    $currentYear = date("Y");
    return $currentYear - $startYear;
}

// Shfaqja e variablave me array
$companyDetails = [
    'name' => COMPANY_NAME,
    'year_founded' => $companyYear,
    'years_in_business' => yearsInBusiness($companyYear)
];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <title>About Us</title>
</head>
<body>
    <header class="header">
        <div class="container1">
            <div class="logo" >
            <img src="images/logo.png" alt="Laced Lifestyle Logo">
            <h1><?php echo COMPANY_NAME; ?></h1>
        </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./Products.php">Products</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="./contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
        
    
    </header>
    
    <article class="QL-z heroComponent jM-z">
        <div class="E">
        <h2 class="F6-z">
                At <?php echo $upperCompanyName; ?>, we believe every step you take should be filled with comfort, confidence, and style. 
                Since our founding in <?php echo $companyYear; ?>, we have been dedicated to bringing you high-quality footwear that blends timeless design with modern innovation.
            </h2>
            <div class="H6-z"><p>Our mission is simple: to provide footwear that inspires and empowers you, no matter where life takes you. We are committed to offering shoes that not only look great but also feel amazing, ensuring you never have to compromise on quality or comfort.<br>
        
        </div>
      </div>
    </article>

    <div class="company-info">
    <h3>Company Information</h3>
    <pre><?php var_dump($companyDetails); ?></pre>
    </div>
    <style>
    .company-info {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background-color:rgb(222, 217, 217);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .company-info h3 {
        text-align: center;
        color: #444;
        margin-bottom: 20px;
    }

    .company-info pre {
        background-color: #2d2d2d;
        color: #f8f8f2;
        padding: 15px;
        border-radius: 8px;
        overflow-x: auto;
        font-size: 14px;
    }

    /* Add styles for rating text */
    .rating-title {
        text-align: center;
        margin: 2rem 0;
        color: #333;
        font-size: 1.5rem;
    }
</style>

        <div class="body-background foto">
            <img class="image-display" src="https://cdn.allbirds.com/image/upload/f_auto,q_auto/cms/v8XWwh4K3Mer3ysAIpcm7/12a38eac5b14202d281e84f3c6c6ec39/ezgif.com-optimize.gif" alt="Optimized GIF">

        </div>

          <div class="Grid">
            <div class="yy">
                <div class="ee">
                    <h3 class="aa">SIMPLICITY IN DESIGN</h3>
                    <p class="ff">No flashy logos. No senseless details. Just the world's most comfortable shoes, made naturally and designed practically. It's that simple.</p>
                </div>
            </div>
            <div class="yy">
                <div class="ee">
                    <h3 class="aa">CONFIDENCE IN COMFORT</h3>
                    <p class="ff">Trying is believing. Give our shoes a shot for 30 days, and if you're not walking on cloud nine, we'll take them back—no questions asked.</p>
                </div>
            </div>
            <div class="yy">
                <div class="ee">
                    <h3 class="aa">MADE FROM NATURE</h3>
                    <p class="ff">The footwear industry often overlooks Mother Nature's materials in favor of cheaper, synthetic alternatives. We think it's time to change that.</p>
                </div>
            </div>
        </div>

        <div class="Gridy Grid--centered">
            
                <h2 class="Typography--secondary-heading Typography--with-margin">The journey to making better things in a better way is a long one, and we're just getting started. Here are a few of our proudest moments so far:</h2>
          </div>
          

          <div class="row">
            <div class="cell">
              <div class="card-container">
                <div class="card-image-container">
                  <div class="aspect-ratio">
                    <img class="card-image" src="https://walkezstore.com/wp-content/uploads/2014/08/Shopping-online-LD-Prod-8-23-14.jpg" alt="Waterfall">
                  </div>
                </div>
                <h3 class="card-title">Growth in Online Presence</h3>
                <p class="card-text">Our online store has flourished, reaching customers from all over the world, and making it easy for everyone to shop our latest collections from the comfort of their homes.</p>
              </div>
            </div>
            <div class="cell">
              <div class="card-container">
                <div class="card-image-container">
                  <div class="aspect-ratio">
                    <img class="card-image" src="https://img.freepik.com/premium-photo/employee-helping-customer-buying-new-shoes_8595-3909.jpg" alt="Pile of shoes">
                  </div>
                </div>
                <h3 class="card-title">Building Strong Relationships</h3>
                <p class="card-text"> Our loyal customers keep coming back, and we've built a community that shares a passion for quality footwear and exceptional service.</p>
              </div>
            </div>
            <div class="cell">
              <div class="card-container">
                <div class="card-image-container">
                  <div class="aspect-ratio">
                    <img class="card-image" src="https://img.uline.com/is/image/uline/HD_5622?$Mobile_Zoom$" alt="Allbirds Box">
                  </div>
                </div>
                <h3 class="card-title">RECYCLED PACKAGING</h3>
                <p class="card-text">We reimagined shoe packaging, using 90% post-consumer recycled cardboard that serves as a shoebox, shopping bag, and mailer all in one.</p>
              </div>
            </div>
          </div>

          <section id="company-milestones">
            <h2 class="section-title">Our Key Milestones</h2>
            <table class="milestones-table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Milestone</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1999</td>
                        <td>Company Founded</td>
                        <td>Founded with a vision to create comfortable, stylish, and sustainable footwear for everyone.</td>
                    </tr>
                    <tr>
                        <td>2005</td>
                        <td>First Store Launch</td>
                        <td>Opened the first retail store in Prishtina City, offering customers a hands-on experience with our products.</td>
                    </tr>
                    <tr>
                        <td>2010</td>
                        <td>Expansion to E-Commerce</td>
                        <td>Launched our online store, enabling customers to enjoy our high-quality footwear from the comfort of their homes.</td>
                    </tr>
                    <tr>
                        <td>2015</td>
                        <td>International Expansion</td>
                        <td>Opened our first international store in Switzerland, expanding our reach globally.</td>
                    </tr>
                    <tr>
                        <td>2020</td>
                        <td>Sustainability Initiative</td>
                        <td>Introduced a fully eco-friendly line of shoes made from sustainable materials, reducing our environmental footprint.</td>
                    </tr>
                    <tr>
                        <td>2022</td>
                        <td>Recycled Packaging</td>
                        <td>Introduced 90% post-consumer recycled packaging for all products sold, furthering our commitment to the environment.</td>
                    </tr>
                    <tr>
                        <td>2023</td>
                        <td>Award-Winning Design</td>
                        <td>Our innovative design won the prestigious 'Footwear of the Year' award, recognizing our commitment to both style and comfort.</td>
                    </tr>
                    <tr>
                        <td>2024</td>
                        <td>Growth in Online Sales</td>
                        <td>2024 marked a record year for our online sales, with a 40% increase in orders, thanks to our enhanced website and seamless shopping experience.</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        
        
        

          <div class="container">
           
          
            <ul class="advantages-list">
              
          
              <li class="advantage-item">
                <div class="advantage-box">
                  <div class="advantage-content">
                    <div class="advantage-image">
                      <img width="60" height="30" alt="Free Shipping" src="https://cdn.media.amplience.net/i/scvl/free-shipping?fmt=auto">
                    </div>
                    <div class="advantage-text">
                      <h5>Free Shipping</h5>
                      <p>Shoe Perks Members get FREE standard shipping on all orders.</p>
                    </div>
                  </div>
                </div>
              </li>
          
              <li class="advantage-item">
                <div class="advantage-box">
                  <div class="advantage-content">
                    <div class="advantage-image">
                      <img width="60" height="30" alt="Same Day Delivery" src="https://cdn.media.amplience.net/i/scvl/same-day-delivery?fmt=auto">
                    </div>
                    <div class="advantage-text">
                      <h5>Same Day Delivery</h5>
                      <p>Eligible items ordered by 1pm CST arrive the same day.</p>
                    </div>
                  </div>
                </div>
              </li>
          
              <li class="advantage-item">
                <div class="advantage-box">
                  <div class="advantage-content">
                    <div class="advantage-image">
                      <img width="60" height="30" alt="Flexible Payment Methods" src="https://cdn.media.amplience.net/i/scvl/points-with-every-purchase?fmt=auto">
                    </div>
                    <div class="advantage-text">
                      <h5>Flexible Payment Methods</h5>
                      <p>Choose from Klarna, ApplePay, PayPal, & all major credit cards.</p>
                    </div>
                  </div>
                </div>
              </li>
          
              <li class="advantage-item">
                <div class="advantage-box">
                  <div class="advantage-content">
                    <div class="advantage-image">
                      <img width="60" height="30" alt="Customer Service" src="https://cdn.media.amplience.net/i/scvl/customer-service-icon_2?fmt=auto">
                    </div>
                    <div class="advantage-text">
                      <h5>Convenient Help Options</h5>
                      <p>Connect with our team your way via chat, email, or phone.</p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <h3 class="rating-title">Rate your experience with us:</h3>
<form method="POST" id="ratingForm" onsubmit="return false;">
  <div class="rating-container">
    <?php for ($i = 1; $i <= 5; $i++): ?>
      <div class="emoji-button">
        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
        <label for="star<?= $i ?>" class="emoji-label"></label>
      </div>
    <?php endfor; ?>
    <div id="message-container" style="text-align: center; font-size: 1.2em; color: green; margin-top: 20px;"></div>
  </div>
</form>

<script>
const stars = document.querySelectorAll('input[name="rating"]');
const labels = document.querySelectorAll('.emoji-label');
const messageContainer = document.getElementById('message-container');

function fillStars(rating) {
  stars.forEach((star, index) => {
    labels[index].style.color = index < rating ? '#f39c12' : '#ccc';
  });
}

stars.forEach(star => {
  star.addEventListener('change', () => {
    const rating = star.value;

    fillStars(rating);

    fetch("rate.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `rating=${rating}`
    })
    .then(response => response.text())
    .then(message => {
      messageContainer.textContent = message; 
    })
    .catch(error => console.error('Error:', error));
  });
});

</script>

  <?php include 'footer.php'; ?>

</body>
</html>