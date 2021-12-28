function productSearchFormOnSubmit(form) {
  searchProducts(form.name.value, form.description.value, form.category.value);
  return false;
}

async function displayProduct(product, container) {
  let card = document.createElement('div');
  card.setAttribute('class', 'card m-1 mx-auto');
  card.setAttribute('style', 'width: 18rem');
  card.setAttribute('productid', product['id']);

  /*
  // TODO: Get images
  let img = document.createElement('img');
  img.setAttribute('src', '/assets/placeholder.gif');
  img.setAttribute('class', 'card-img-top');
  img.setAttribute('alt', 'roll');

  card.appendChild(img);
  */

  let cardBody = document.createElement('div');
  cardBody.setAttribute('class', 'card-body');

  card.appendChild(cardBody);

  let cardTitle = document.createElement('h5');
  cardTitle.setAttribute('class', 'card-title');
  cardTitle.innerText = product['name'];

  cardBody.appendChild(cardTitle);

  let cardText = document.createElement('p');
  cardText.setAttribute('class', 'card-subtitle text-muted');
  cardText.innerHTML = product['description'];

  cardBody.appendChild(cardText);

  let priceText = document.createElement('p');
  priceText.setAttribute('class', 'mb-1');
  priceText.innerText = `Unit price: ${product['unitprice']}`

  cardBody.appendChild(priceText);

  if (LOGGED_IN) {
    let itemCountInput = document.createElement('input');
    itemCountInput.setAttribute('name', 'itemCount');
    itemCountInput.setAttribute('class', 'card-text');
    itemCountInput.setAttribute('type', 'number');
    itemCountInput.setAttribute('min', 1);
    itemCountInput.setAttribute('max', product['stock']);
    itemCountInput.setAttribute('value', 1);

    cardBody.appendChild(itemCountInput);

    let cardLink = document.createElement('p');
    cardLink.setAttribute('class', 'btn btn-primary card-link mt-1 mb-1');
    cardLink.setAttribute('onclick', 'placeInBasketOnClick(this.parentElement.parentElement)');
    cardLink.innerText = 'Place order';

    cardBody.appendChild(cardLink);
  }

  container.appendChild(card);
}

async function fetchProducts(name = "", description = "", category = "") {
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

    return products
  } catch (err) {
    console.error(err);
  }
}

async function fetchCategories() {
  try {
    const response = await fetch(new Request('/api/v1/category/list'), {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const categories = await response.json();

    return categories
  } catch (err) {
    console.error(err);
  }
}

async function fillInCategories() {
  const categories = await fetchCategories();

  let categories_select = document.getElementsByClassName("category-select")
  for (let ii = 0; ii < categories_select.length; ii++) {
    let category_select = categories_select[ii]
    category_select.options.length = 0;

    category_select.add(new Option('all', ''));
    for (let ii = 0; ii < categories.length; ii++) {
      const name = categories[ii].name;
      category_select.add(new Option(name, `${name}`));
    }
  }

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

async function placeInBasketOnClick(card) {
  let data = { 'id': Number(card.getAttribute('productid')), 'amount': Number(card.childNodes[0].childNodes[3].value) };

  try {
    const response = await fetch(new Request('/api/v1/basket/add'), {
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

    const result = await response.json();

    const stock = result['stock'];
    if (stock > 0) {
      const countInput = card.childNodes[0].childNodes[3];
      countInput.setAttribute('max', stock);
      if (countInput.value > stock) {
        countInput.value = stock;
      }
    } else if (stock == 0) {
      card.remove();
    } else {
      console.error("Failed to add item to basket");
    }
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
  fillInCategories();
}

update();
