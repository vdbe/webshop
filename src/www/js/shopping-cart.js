function productSearchFormOnSubmit(form) {
  searchProducts(form.name.value, form.description.value, form.category.value);
  return false;
}

async function searchProducts(name = "", description = "", category = "") {
  let products = await fetchProductsInBasket(name, description, category);

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
  card.setAttribute('orderid', product['orderid']);

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
  itemCountInput.setAttribute('min', 0);
  itemCountInput.setAttribute('max', product['stock']);
  itemCountInput.setAttribute('value', product['amount']);

  console.log(product);

  cardBody.appendChild(itemCountInput);

  // TODO: Link to js function
  let cardLink = document.createElement('p');
  cardLink.setAttribute('class', 'btn btn-primary card-link mt-1 mb-1');
  cardLink.setAttribute('onclick', 'changeOrderOnClick(this.parentElement.parentElement)');
  cardLink.innerText = 'Change order';

  cardBody.appendChild(cardLink);

  container.appendChild(card);
}

async function fetchProductsInBasket(name = "", description = "", category = "", callback) {
  let data = { 'name': name, 'description': description, 'category': category };

  try {
    const response = await fetch(new Request('/api/v1/basket/search'), {
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
}

async function changeOrderOnClick(card) {
  let data = { 'id': Number(card.getAttribute('orderid')), 'amount': Number(card.childNodes[1].childNodes[3].value) };

  try {
    const response = await fetch(new Request('/api/v1/basket/edit'), {
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

    const json = await response.json();

    const amountInput = card.childNodes[1].childNodes[3];
    const amount = json['amount'];
    if (amount > 0) {
      amountInput.value = amount
    }

    searchProducts();
  } catch (err) {
    console.error(err);
  }
}

async function update() {
  const params = new URLSearchParams(window.location.search);
  let name = params.get('name');
  let description = params.get('description');
  let category = params.get('category')

  if (!name) {
    name = "";
  }
  if (!description) {
    description = "";
  }
  if (!category) {
    category = "";
  }

  searchProducts(name, description, category);
  //fillInCategories();
}

update();
