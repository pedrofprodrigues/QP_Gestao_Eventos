
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .head{
            position:fixed;
            z-index:1000;
            background-size: cover;
            background-position: center;
            top: 0%;
            background-image: url('{{ asset('storage/quinta.png') }}');
            display: flex;
            height:220px;
            width:100%;
            background-color: #000000;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f8f8;
        }

        .container {
            display: flex;
            margin-top: 250px;
            justify-content: center;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 3em;
            color: #ba604c;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.2em;
            color: #666;
        }

        .button-go {
               width: 100%;
               margin-top: 10px;
               padding: 10px;
               background-color: #015911;
               color: white;
               border: none;
               border-radius: 5px;
               cursor: pointer;
         }

        .button-go:hover {
                background-color: #013d0d;
        }

        .categories {
            margin-bottom: 40px;
            position:relative;
        }

        .categories h2 {
            font-size: 2em;
            color: #1c4f28;
            border-bottom: 2px solid #ba604c;
            margin-bottom: 20px;
            padding-bottom: 5px;
        }

        .category {
            display: flex;
            flex-grow: 1;
            gap: 20px;
            margin-bottom: 40px;
            justify-content: center;
            flex-grow:1;
        }

        .food-item {
            list-style: none;
            flex-grow:1;
            width: calc(25% - 20px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .food-item img {
            width: 100%;
            min-width: 500px;
            height: 500px;
            object-fit: cover;
        }

        .food-item button {
            display: block;
            width: 100%;
            background-color: #ba604c;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
        }

        .food-item button:hover {
            background-color: #a15443;
        }

        .cart {
        position:relative;
        width:400px;
        left: 20px;
        padding: 10px;
        
        }

        .cart table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart td, .cart th {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            white-space: nowrap;
            height:40px; 
        }

        .cart th {
            background-color: #ba604c;
            color: white;
        }

        .total-row {
                font-weight: bold;
                background-color: #f8f8f8;
        }

        .mid {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

         .mid label {
            font-size: 1em;
            color: #666;
            margin-bottom: 5px;
        }

        .mid input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        .mid input:focus {
            outline: none;
            border-color: #ba604c;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            position: relative;
            top:70px;
            margin: auto;
            padding: 20px;
            width: 60%;
            background:#d1d1d1;
            text-align: center;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            color: black;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .carousel-container {
            position: relative;
            max-width: 100%;
            height: 700px; 
            overflow: hidden; 
        }

        .carousel-container img {
            max-width: 100%;
            max-height: 100%;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
            margin: auto;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .carousel-nav.prev {
            left: 10px;
        }

        .carousel-nav.next {
            right: 10px;
        }
         .modal-description {
            margin-top: 20px;
            font-size: 22px;
              font-style: italic;
            color: #333;
            text-align: center;
        }

 .tabs {
      position:relative;
      left:50px;
      width: 100%;
      max-width: 1500px;
      margin: auto;
    }
    .tab-list {
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ba604c;
      margin-bottom: 20px;
    }
    .tab-list li {
      padding: 10px 20px;
      cursor: pointer;
      font-size: 1.2em;
      color: #1c4f28;
      border: 2px solid transparent;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
      transition: background-color 0.3s, border-color 0.3s;
    }
    .tab-list li:hover {
      background-color: #f0f0f0;
    }
    .tab-list li.active {
      background-color: #fff;
      border: 2px solid #ba604c;
      border-bottom: none;
      font-weight: bold;
    }
    /* Tab Content Styles */
    .tab-content {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }
    .tab-content.active {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    </style>


</head>
<body>
<div class="head">
</div>


  <div class="container">


<div class="cart">
    <h3>Resumo do Pedido</h3>
    <table>
        <tr>
            <th>Item</th>
            <th>Escolhido</th>
            <th>Preço (€)</th>
        </tr>
        <tr>
            <td>Entrada</td>
            <td id="appetizer">Por escolher</td>
            <td id="appetizer_price">NA</td>
        </tr>
        <tr>
            <td>Sopa</td>
            <td id="soup">Por escolher</td>
            <td id="soup_price">NA</td>
        </tr>
        <tr>
            <td>Peixe</td>
            <td id="fish">Por escolher</td>
            <td id="fish_price">NA</td>
        </tr>
        <tr>
            <td>Carne</td>
            <td id="meat">Por escolher</td>
            <td id="meat_price">NA</td>
        </tr>
        <tr>
            <td>Sobremesa</td>
            <td id="dessert">Por escolher</td>
            <td id="dessert_price">NA</td>
        </tr>
        <tr class="total-row">
            <td colspan="2">Total</td>
            <td id="total_price">0.00€</td>
        </tr>
        </table>
    <button class="button-go" onclick="sendValue({{$appetizers}},{{$soups}},{{$fishs}},{{$meats}},{{$desserts}})">Confirmar</button>
</div>    


    <div class="tabs">
      <!-- Tab Navigation -->
      <ul class="tab-list">
        <li class="active" data-tab="entradas">Entradas</li>
        <li data-tab="sopas">Sopas</li>
        <li data-tab="peixe">Prato Peixe</li>
        <li data-tab="carne">Prato Carne</li>
        <li data-tab="sobremesa">Sobremesas</li>
      </ul>
      <!-- Tab Contents -->
      <!-- Entradas (Appetizers) -->
      <div id="entradas" class="tab-content active">
        @foreach ($appetizers as $appetizer)
          <li class="food-item">
            <img src="{{ asset('storage/uploads/photos/'.$appetizer->photo) }}"
                 alt="Food"
                 onclick="openModal('{{ $appetizer->galery }}', '{{ $appetizer->details }}')" />
            <button onclick="addToCart('appetizer', '{{ $appetizer->name }}', '{{ $appetizer->price }}')">
              {{ $appetizer->name }} - {{ $appetizer->price }}€
            </button>
          </li>
        @endforeach
      </div>
      <!-- Sopas (Soups) -->
      <div id="sopas" class="tab-content">
        @foreach ($soups as $soup)
          <li class="food-item">
            <img src="{{ asset('storage/uploads/photos/'.$soup->photo) }}"
                 alt="Food"
                 onclick="openModal('{{ $soup->galery }}', '{{ $soup->details }}')" />
            <button onclick="addToCart('soup', '{{ $soup->name }}', '{{ $soup->price }}')">
              {{ $soup->name }} - {{ $soup->price }}€
            </button>
          </li>
        @endforeach
      </div>
      <!-- Prato Peixe (Fish) -->
      <div id="peixe" class="tab-content">
        @foreach ($fishs as $fish)
          <li class="food-item">
            <img src="{{ asset('storage/uploads/photos/'.$fish->photo) }}"
                 alt="Food"
                 onclick="openModal('{{ $fish->galery }}', '{{ $fish->details }}')" />
            <button onclick="addToCart('fish', '{{ $fish->name }}', '{{ $fish->price }}')">
              {{ $fish->name }} - {{ $fish->price }}€
            </button>
          </li>
        @endforeach
      </div>
      <!-- Prato Carne (Meat) -->
      <div id="carne" class="tab-content">
        @foreach ($meats as $meat)
          <li class="food-item">
            <img src="{{ asset('storage/uploads/photos/'.$meat->photo) }}"
                 alt="Food"
                 onclick="openModal('{{ $meat->galery }}', '{{ $meat->details }}')" />
            <button onclick="addToCart('meat', '{{ $meat->name }}', '{{ $meat->price }}')">
              {{ $meat->name }} - {{ $meat->price }}€
            </button>
          </li>
        @endforeach
      </div>
      <!-- Sobremesas (Desserts) -->
      <div id="sobremesa" class="tab-content">
        @foreach ($desserts as $dessert)
          <li class="food-item">
            <img src="{{ asset('storage/uploads/photos/'.$dessert->photo) }}"
                 alt="Food"
                 onclick="openModal('{{ $dessert->galery }}', '{{ $dessert->details }}')" />
            <button onclick="addToCart('dessert', '{{ $dessert->name }}', '{{ $dessert->price }}')">
              {{ $dessert->name }} - {{ $dessert->price }}€
            </button>
          </li>
        @endforeach
      </div>
    </div>
  </div>
<div id="imageModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()"></span>
        <div class="carousel-container">
            <img id="carouselImage" src="" alt="Carousel Image" />
            <button class="carousel-nav prev" onclick="prevImage()">&#10094;</button>
            <button class="carousel-nav next" onclick="nextImage()">&#10095;</button>
        </div>
                <div id="modalDescription" class="modal-description"></div>
    </div>
</div>
</body>

<script>

    const tabs = document.querySelectorAll('.tab-list li');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        // Remove active classes from all tabs and contents
        tabs.forEach(item => item.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked tab and corresponding content
        tab.classList.add('active');
        const tabId = tab.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
      });
    });
 function updateTotalPrice() {
        let prices = [
            parseFloat(document.getElementById("appetizer_price").textContent) || 0,
            parseFloat(document.getElementById("soup_price").textContent) || 0,
            parseFloat(document.getElementById("fish_price").textContent) || 0,
            parseFloat(document.getElementById("meat_price").textContent) || 0,
            parseFloat(document.getElementById("dessert_price").textContent) || 0
        ];
        
        let total = prices.reduce((acc, price) => acc + price, 0);
        document.getElementById("total_price").textContent = total.toFixed(2)+"€";
    }

    function addToCart(category, name, price) {
        document.getElementById(category).textContent = name;
        document.getElementById(category + "_price").textContent = parseFloat(price).toFixed(2);
        updateTotalPrice();
    }

    let currentIndex = 0;
    let carouselImages = [];

    function openModal(carouselString,description) {
        const modal = document.getElementById('imageModal');
        const carouselImage = document.getElementById('carouselImage');
        const modalDescription = document.getElementById('modalDescription');

        if (!modal || !carouselImage) {
            console.error('Modal or carousel element not found in the DOM.');
            return;
        }
        modalDescription.textContent = description;
        carouselImages = carouselString.split(',').map(image => image.trim());

        if (carouselImages.length <= 1) {
            return;
        }

        if (carouselImages.length > 1) {    
            carouselImages =  carouselImages.slice(0, -1);                
        }
        currentIndex = 0;
        carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;
        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function nextImage() {
        if (carouselImages.length === 0) return;

        currentIndex = (currentIndex + 1) % carouselImages.length; 
        const carouselImage = document.getElementById('carouselImage');
        carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;
    }

    function prevImage() {
        if (carouselImages.length === 0) return;

        currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length; 
        const carouselImage = document.getElementById('carouselImage');
        carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;
    }

    window.onclick = function (event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            closeModal();
        }
    };


function sendValue(appetizers, soups, fishs, meats, desserts) {
    let categories = {
        "Entradas": appetizers,
        "Sopa": soups,
        "Peixe": fishs,
        "Carne": meats,
        "Sobremesa": desserts
    };

 let cart = {
            "Entradas": document.getElementById('appetizer')?.textContent,
            "Sopa": document.getElementById('soup').textContent,
            "Peixe": document.getElementById('fish').textContent,
            "Carne": document.getElementById('meat').textContent,
            "Sobremesa": document.getElementById('dessert').textContent
        };

    let options = Object.keys(categories).map(category => {
        let item = categories[category].find(item => item.name === cart[category]);
        return item ? item.id : "none";
    });

    window.opener.receiveValue(options);
    // window.close();
}



    </script>

</body>
</html>
