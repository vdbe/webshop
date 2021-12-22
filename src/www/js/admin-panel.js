function fillInCategories(categories) {
  let categories_select = document.getElementById("categories-select");

  categories_select.options.length = 0;
  for (let ii = 0; ii < categories.length; ii++) {
    const name = categories[ii].name;
    categories_select.add(new Option(name, name));
  }
}

function serializeJSON(form) {
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  return JSON.stringify(dict);
}


function addProduct(form) {
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  dict['available'] = dict['available'] == "on";

  let addProduct = new Request("/api/v1/product/add");
  fetch(addProduct, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dict),
  }).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
  })

  return false;
}

function addCategory(form) {
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  let addCategory = new Request("/api/v1/category/add");
  fetch(addCategory, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dict),
  }).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
  })

  updateCatgories();

  return false;
}

function updateCatgories() {
  let categoriesRequest = new Request("/api/v1/category/list");
  fetch(categoriesRequest).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
    .then(function(response) {
      fillInCategories(response);
    });
}

updateCatgories();
