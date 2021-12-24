function productSearchFormOnSubmit(form) {
  searchProducts(form.name.value, form.description.value, form.category.value);
  return false;
}

async function displayProduct(product, container) {
  let card = document.createElement('div');
  card.setAttribute('class', 'card');
  card.setAttribute('style', 'width: 18rem');

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
  cardText.setAttribute('class', 'card-text');
  cardText.innerText = product['description'];

  cardBody.appendChild(cardText);

  // TODO: Link to js function
  let cardLink = document.createElement('p');
  cardLink.setAttribute('class', 'btn btn-primary');
  cardLink.setAttribute('href', '#');
  cardLink.innerText = 'Place order';

  cardBody.appendChild(cardLink);

  container.appendChild(card);
}

async function fetchProducts(name = "", description = "", category = "", callback) {
  let data = {};//{ 'name': name, 'description': description, 'category': category };
  data['name'] = name;
  data['description'] = description;
  data['category'] = category;
  let json = JSON.stringify(data);

  try {
    const response = await fetch(new Request('/api/v1/product/search'), {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: json,
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

async function fetchCategories(callback) {
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

    if (callback) {
      callback();
    }

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
  container.innerHTML = "";
  for (let ii = 0; ii < products.length; ii++) {
    const product = products[ii];
    displayProduct(product, container);
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