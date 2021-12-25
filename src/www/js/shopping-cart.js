function productSearchFormOnSubmit(form) {
  searchProducts(form.name.value, form.description.value, form.category.value);
  return false;
}

async function searchProducts(name = "", description = "", category = "") {
  let products = await fetchProducts(name, description, category);

  const container = document.getElementById("products-wrapper");

  let tmpcontainer = document.createElement('div');
  for (let ii = 0; ii < products.length; ii++) {
    const product = products[ii];
    displayProduct(product, tmpcontainer);
  }

  container.innerHTML = tmpcontainer.innerHTML;
}

async function displayProduct(product, container) {
  let card = document.createElement('div');
  card.setAttribute('class', 'card m-1 mx-auto');
  card.setAttribute('style', 'width: 18rem');
  card.setAttribute('productid', product['id']);

  // TODO: Get images
  let img = document.createElement('img');
  img.setAttribute('src', '/assets/placeholder.gif');
  img.setAttribute('class', 'card-img-top');
  img.setAttribute('alt', 'roll');

  card.appendChild(img);

  let cardBody = document.createElement('div');
  cardBody.setAttribute('class', 'card-body');

  card.appendChild(cardBody);

  let cardTitle = document.createElement('h5');
  cardTitle.setAttribute('class', 'card-title');
  cardTitle.innerText = product['name'];

  cardBody.appendChild(cardTitle);

  let cardText = document.createElement('p');
  cardText.setAttribute('class', 'card-subtitle text-muted');
  cardText.innerText = product['description'];

  cardBody.appendChild(cardText);

  let priceText = document.createElement('p');
  priceText.setAttribute('class', 'mb-1');
  priceText.innerText = `Unit price: ${product['unitprice']}`

  cardBody.appendChild(priceText);

  let itemCountInput = document.createElement('input');
  itemCountInput.setAttribute('name', 'itemCount');
  itemCountInput.setAttribute('class', 'card-text');
  itemCountInput.setAttribute('type', 'number');
  itemCountInput.setAttribute('min', 1);
  itemCountInput.setAttribute('max', product['stock']);
  itemCountInput.setAttribute('value', 1);

  cardBody.appendChild(itemCountInput);

  // TODO: Link to js function
  let cardLink = document.createElement('p');
  cardLink.setAttribute('class', 'btn btn-primary card-link mt-1 mb-1');
  cardLink.setAttribute('onclick', 'placeInBasketOnClick(this.parentElement.parentElement)');
  cardLink.innerText = 'Place order';

  cardBody.appendChild(cardLink);

  container.appendChild(card);
}

async function fetchProductsInBasket(name = "", description = "", category = "", callback) {
  let data = { 'name': name, 'description': description, 'category': category };

  try {
    const response = await fetch(new Request('/api/v1/product/search'), {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data),
    });

    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const products = await response.json();

    if (callback) {
      callback();
    }
    return products
  } catch (err) {
    console.error(err);
  }
