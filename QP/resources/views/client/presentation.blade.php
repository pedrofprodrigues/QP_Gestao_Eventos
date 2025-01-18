
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

        /* Responsive Adjustments */
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

    <?php
    //dump($appetizers);
    ?>
    <div class="head">
    <div class="titulo">
        <h1>Menu</h1>
        <p>Selecione um opção em cada categoria</p>
    </div>
</div>
    <div class="container">
        <div>
        <div class="client">
            <h3>As suas informações</h3>
            <div class="mid">
                <label for="client_resp_name">Nome:</label>
                <input type="text" id="client_resp_name" name="client_resp_name" required>
            </div>
            <div class="mid">
                <label for="client_resp_contact">Contacto telefónico:</label>
                <input type="text" id="client_resp_contact" name="client_resp_contact" required>
            </div>
            <div class="mid">
                <label for="client_resp_email">Email:</label>
                <input type="email" id="client_resp_email" name="client_resp_email" required>
            </div>
            <div class="mid">
                <label for="num_person">Adultos:</label>
                <input type="number" id="num_person" name="num_person" min="0" required>
            </div>
            <div class="mid">
                <label for="num_children">Crianças (+3 anos):</label>
                <input type="number" id="num_children" name="num_children" min="0" required>
            </div>
        </div>

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
                        <img src="{{ asset('storage/uploads/photos/'.$appetizer->photo) }}" alt="Food" />
                        <button onclick="addToCart('Entradas', '{{$appetizer->name}}')">{{$appetizer->name}}</button>
                    </li>
                @endforeach
            </div>

            <h2>Sopas</h2>
            <div class="category">
                @foreach ($soups as $soup)
                    <li class="food-item">
                        <img src="{{ asset('storage/uploads/photos/'.$soup->photo) }}" alt="Food" />
                        <button onclick="addToCart('Sopa', '{{$soup->name}}')">{{$soup->name}}</button>
                    </li>
                @endforeach
            </div>
            <h2>Prato Carne</h2>
            <div class="category">

                @foreach ($meats as $meat)
                    <li class="food-item">
                        <img src="{{ asset('storage/uploads/photos/'.$meat->photo) }}" alt="Food" />
                        <button onclick="addToCart('Carne', '{{$meat->name}}')">{{$meat->name}}</button>
                    </li>
                @endforeach
            </div>
            <h2>Prato Peixe</h2>
            <div class="category">

                @foreach ($fishs as $fish)
                    <li class="food-item">
                        <img src="{{ asset('storage/uploads/photos/'.$fish->photo)  }}" alt="Food" />
                        <button onclick="addToCart('Peixe', '{{$fish->name}}')">{{$fish->name}}</button>
                    </li>
                @endforeach
            </div>
            <h2>Sobremesas</h2>
            <div class="category">

                @foreach ($desserts as $dessert)
                    <li class="food-item">
                        <img src="{{ asset('storage/uploads/photos/'.$dessert->photo)  }}" alt="Food" />
                        <button onclick="addToCart('Sobremesa', '{{$dessert->name}}')">{{$dessert->name}}</button>
                    </li>
                @endforeach
            </div>

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

</script>

</body>
</html>
