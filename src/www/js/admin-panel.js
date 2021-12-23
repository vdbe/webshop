let categories;

function fillInCategories(categories) {
  //let categories_select = document.getElementById("categories-select");
  let categories_select = document.getElementsByClassName("category-select")

  for (let ii = 0; ii < categories_select.length; ii++) {
    let category_select = categories_select[ii]
    category_select.options.length = 0;
    for (let ii = 0; ii < categories.length; ii++) {
      const name = categories[ii].name;
      category_select.add(new Option(name, `${ii}-${name}`));
    }
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

  let category = dict['categories'];
  const idx = category.indexOf('-');
  dict['categories'] = category.slice(idx + 1);
  console.log(dict);


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

function updateEditCategoryForm(select) {
  index = 0;
  if (select.value != "") {
    const split_index = select.value.indexOf('-');
    index = select.value.slice(0, split_index);
  }
  let text_name = document.getElementById('edit-category-category-name');
  let textarea_desc = document.getElementById('edit-category-description-text');
  text_name.value = categories[index].name
  textarea_desc.value = categories[index].description
}

function editCategoryFormOnSubmit(form) {
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  const split_index = dict['categories'].indexOf('-');
  const index = dict['categories'].slice(0, split_index);


  const jsonDict = { 'id': categories[index].id, 'name': dict['name'], 'description': dict['description'] };

  let editCategory = new Request("/api/v1/category/edit");
  fetch(editCategory, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(jsonDict),
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
      categories = response
      fillInCategories(categories);
      updateEditCategoryForm(document.getElementById('edit-category-categories-select'))
    });
}

updateCatgories();
