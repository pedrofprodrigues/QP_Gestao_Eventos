
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
         .titulo {
            position: fixed;
            top: 0%;
            z-index: 1000;
            background-image: url('{{ asset('storage/quinta.png') }}');
            width:100%;
            height:250px;
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        .head{
            position:fixed;
            top: 0%;
            height:270px;
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
            margin-top: 300px;
            justify-content: space-evenly;
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

        .categories {

            margin-bottom: 40px;
            width: 60%;
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
            justify-content: space-evenly;
            gap: 20px;
            margin-bottom: 40px;
        }

        .food-item {
            list-style: none;
            width: calc(25% - 20px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .food-item img {
            width: 100%;

            min-width: 300px;
            height: 300px;
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
            transition: background-color 0.3s;
        }

        .food-item button:hover {
            background-color: #a15443;
        }


         .cart, .client {
            position: fixed;


        }

        .cart {
            left: 80px;
        }
        .client {
            top:550px;
            left: 80px;
        }

        .cart h3, .client h3 {
            font-size: 1.5em;
            color: #1c4f28;
            margin-bottom: 15px;
        }

        #cart-list {
            list-style: none;
            padding: 0;
        }

        #cart-list li {
            margin: 5px 0;
            font-size: 1em;
        }

        .client .mid {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .client .mid label {
            font-size: 1em;
            color: #666;
            margin-bottom: 5px;
        }

        .client .mid input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        .client .mid input:focus {
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


        @media (max-width: 1300px) {
            .food-item {
                width: calc(50% - 20px);
            }

            .cart, .client {
                width: 13%;
            }
        }

        @media (max-width: 480px) {
            .food-item {
                width: 100%;
            }

            .cart, .client {
                width: 90%;
                position: relative;
                margin-bottom: 20px;
            }

            .container {
                margin-top: 20px;
            }
        }
    </style>


</head>
<body>
<div class="head">
    <div class="titulo">
        <h1>Menu</h1>
        <p>Selecione um opção em cada categoria</p>
    </div>
</div>
<div class="container">
    <div>
        <div class="cart">
            <h3>As suas escolhas</h3>
            <ul id="cart-list">
                <li>Nome</li>
            </ul>
        </div>
    </div>
    <div class="categories">
    <h2>Entradas</h2>
    <div class="category">
            @foreach ($appetizers as $appetizer)
            <li class="food-item">
                <img src="{{ asset('storage/uploads/photos/'.$appetizer->photo) }}" 
                     alt="Food" 
                     onclick="openModal('{{ $appetizer->galery }}', '{{ $appetizer->details }}')" />
                <button onclick="addToCart('Entradas', '{{ $appetizer->name }}')">{{ $appetizer->name }}</button>
            </li>
            @endforeach
        </div>
        <h2>Sopas</h2>
        <div class="category">
            @foreach ($soups as $soup)
                <li class="food-item">
                    <img src="{{ asset('storage/uploads/photos/'.$soup->photo) }}"
                         alt="Food"
                         onclick="openModal('{{ $soup->galery }}', '{{ $soup->details }}')" />
                    <button onclick="addToCart('Sopa', '{{$soup->name}}')">{{$soup->name}}</button>
                </li>
            @endforeach
        </div>
        <h2>Prato Carne</h2>
        <div class="category">

            @foreach ($meats as $meat)
                <li class="food-item">
                    <img src="{{ asset('storage/uploads/photos/'.$meat->photo) }}" alt="Food"
                     onclick="openModal('{{ $meat->galery }}', '{{ $meat->details }}')" />
                    <button onclick="addToCart('Carne', '{{$meat->name}}')">{{$meat->name}}</button>
                </li>
            @endforeach
        </div>
        <h2>Prato Peixe</h2>
        <div class="category">

            @foreach ($fishs as $fish)
                <li class="food-item">
                    <img src="{{ asset('storage/uploads/photos/'.$fish->photo)  }}" alt="Food"
                     onclick="openModal('{{ $fish->galery }}', '{{ $fish->details }}')" />
                    <button onclick="addToCart('Peixe', '{{$fish->name}}')">{{$fish->name}}</button>
                </li>
            @endforeach
        </div>
        <h2>Sobremesas</h2>
        <div class="category">

            @foreach ($desserts as $dessert)
                <li class="food-item">
                    <img src="{{ asset('storage/uploads/photos/'.$dessert->photo)  }}" alt="Food"
                     onclick="openModal('{{ $dessert->galery }}', '{{ $dessert->details }}')" />
                    <button onclick="addToCart('Sobremesa', '{{$dessert->name}}')">{{$dessert->name}}</button>
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

let cart = {
    Entradas: "Por escolher",
    Sopa: "Por escolher",
    Carne: "Por escolher",
    Peixe: "Por escolher",
    Sobremesa: "Por escolher",
};

function addToCart(category, item) {
    cart[category] = item;
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = '';

    for (const category in cart) {
        const listItem = document.createElement('li');
        listItem.textContent = `${category}: ${cart[category]}`;
        if (cart[category] === "Por escolher")
        {
            listItem.style.color = "#ba604c";
        }else{
            listItem.style.color = "#1c4f28";
        }
        cartList.appendChild(listItem);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    updateCartDisplay();
});




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

    if (carouselImages.length === 0) {
        console.error('No images to display in the carousel.');
        return;
    }

    // Reset the current index and display the first image
    currentIndex = 0;
    carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;

    // Show modal
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

    currentIndex = (currentIndex + 1) % carouselImages.length; // Cycle to the next image
    const carouselImage = document.getElementById('carouselImage');
    carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;
}

function prevImage() {
    if (carouselImages.length === 0) return;

    currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length; // Cycle to the previous image
    const carouselImage = document.getElementById('carouselImage');
    carouselImage.src = `/storage/uploads/photos/${carouselImages[currentIndex]}`;
}

// Close modal if user clicks outside of it
window.onclick = function (event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        closeModal();
    }
};

</script>

</body>
</html>
