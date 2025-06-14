let cart = [];
const cartCount = document.getElementById("cart-count");


function addProduct(name, price, image) {
    fetch('add_cart.php', {
        method: 'POST',
        body: JSON.stringify({
            name: name,
            price: price,
            image: image
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        upCounterCart();
        
        // Se total de itens for 18 ou mais, recarrega a página para refletir novos preços
        if (data.total_items >= 18) {
            location.reload();
        }
    });
}
function upCounterCart() {
    fetch('counter.php')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById("cart-count");
            cartCount.textContent = data.counter;
        });
}


// Chama na inicialização para sincronizar
upCounterCart();

function searchProducts() {
  const searchInput = document.querySelector('.search-input').value.toLowerCase();
  const productCards = document.querySelectorAll('.product-card');
  
  productCards.forEach(card => {
    const productName = card.querySelector('span:nth-child(3)').textContent.toLowerCase();
    if (productName.includes(searchInput)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}

// Add event listener for real-time search
document.querySelector('.search-input').addEventListener('input', searchProducts);