let categories;
let users;
let userRoles;
let products;

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

function fillInUsers(users) {
  //let categories_select = document.getElementById("categories-select");
  let users_select = document.getElementsByClassName("user-select")

  for (let ii = 0; ii < users_select.length; ii++) {
    let user_select = users_select[ii]
    user_select.options.length = 0;
    for (let ii = 0; ii < users.length; ii++) {
      const name = users[ii].email;
      user_select.add(new Option(name, `${ii}-${name}`));
    }
  }
}

function fillInUserRoles(roles) {
  let roles_select = document.getElementsByClassName("role-select")

  for (let ii = 0; ii < roles_select.length; ii++) {
    let role_select = roles_select[ii]
    role_select.options.length = 0;
    for (let ii = 0; ii < roles.length; ii++) {
      const name = roles[ii].name;
      role_select.add(new Option(name, `${ii}-${name}`));
    }
  }
}

function fillInProducts(products) {
  let products_select = document.getElementsByClassName("product-select")

  for (let ii = 0; ii < products_select.length; ii++) {
    let user_select = products_select[ii]
    user_select.options.length = 0;
    for (let ii = 0; ii < products.length; ii++) {
      const name = products[ii].name;
      user_select.add(new Option(name, `${ii}-${name}`));
    }
  }
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

    updateProducts();
  })

  return false;
}

function editProductOnSubmit(form) {
  const select = document.getElementById('editProduct-product-select');
  let index = 0;
  if (select.value != "") {
    const split_index = select.value.indexOf('-');
    index = select.value.slice(0, split_index);
  }

  const product = products[index];

  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  const nameText = document.getElementById('editProduct-product-name');
  const descriptionText = document.getElementById('editProduct-description-text');
  const categorySelect = document.getElementById('editProduct-categories-select');
  const availableCheckbox = document.getElementById('editProduct-available-checkbox');
  const stockNumber = document.getElementById('editProduct-stock-number');
  const unitPriceNumber = document.getElementById('editProduct-unitprice-number');

  let category = categorySelect.value;
  const idx = category.indexOf('-');
  category = category.slice(idx + 1);

  const data = {
    'id': product['id'],
    'name': nameText.value,
    'description': descriptionText.value,
    'available': availableCheckbox.checked,
    'categories': category,
    'available': availableCheckbox.value == "on",
    'stock': stockNumber.value,
    'unitprice': unitPriceNumber.value,
  }
  console.log(data);
  let addProduct = new Request("/api/v1/product/add");
  fetch(addProduct, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data),
  }).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    updateProducts();
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
    updateCatgories(updateProducts);
  })


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

function updateEditProductsForm(select) {
  index = 0;
  if (select.value != "") {
    const split_index = select.value.indexOf('-');
    index = select.value.slice(0, split_index);
  }

  const product = products[index];

  const upstreamCategoryName = product['category'];
  let categoryIndex = 0;
  for (let ii = 0; ii < categories.length; ii++) {
    if (categories[ii].name == upstreamCategoryName) {
      categoryIndex = ii;
      break;
    }
  }

  const nameText = document.getElementById('editProduct-product-name');
  const descriptionText = document.getElementById('editProduct-description-text');
  const categorySelect = document.getElementById('editProduct-categories-select');
  const availableCheckbox = document.getElementById('editProduct-available-checkbox');
  const stockNumber = document.getElementById('editProduct-stock-number');
  const unitPriceNumber = document.getElementById('editProduct-unitprice-number');

  nameText.value = product['name'];
  descriptionText.value = product['description'];
  categorySelect.value = `${categoryIndex}-${product['category']}`;
  stockNumber.value = product['stock'];
  unitPriceNumber.value = product['unitprice'];

  const availableDate = new Date(product['available']);
  const now = new Date();
  availableCheckbox.checked = now >= availableDate;
}

function updateEditUserForm(select) {
  index = 0;
  if (select.value != "") {
    const split_index = select.value.indexOf('-');
    index = select.value.slice(0, split_index);
  }

  const upstreamRoleName = users[index].rolename
  let roleIndex = 0;
  for (let ii = 0; ii < userRoles.length; ii++) {
    if (userRoles[ii].name == upstreamRoleName) {
      roleIndex = ii;
      break;
    }
  }

  const user = users[index];
  const role = userRoles[roleIndex];

  const roleSelect = document.getElementById('editUser-role-select');
  const displaynameText = document.getElementById('editUser-displayname');
  const activeCheckox = document.getElementById('editUser-active-checkbox');


  roleSelect.value = `${roleIndex}-${role.name}`;
  displaynameText.value = user.displayname;
  activeCheckox.checked = user.active;


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
    updateCatgories();
  })

  return false;
}

function editUserFormOnSubmit(form) {
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  const split_index = dict['user'].indexOf('-');
  const index = dict['user'].slice(0, split_index);
  const user = users[index];

  const role_split_index = dict['role'].indexOf('-');
  const roleIndex = dict['role'].slice(0, role_split_index);
  const role = userRoles[roleIndex];

  const jsonDict = {
    'id': user.id, 'role': role.name, 'displayname': dict['displayname'], 'active': dict['active'] == 'on'
  };

  let editCategory = new Request("/api/v1/user/edit");
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
    updateCatgories();
  })

  return false;

}

function updateCatgories(callback) {
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
      if (callback) {
        callback();
      }
    });
}

function updateUsers(callback) {
  let categoriesRequest = new Request("/api/v1/user/list");
  fetch(categoriesRequest).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
    .then(function(response) {
      users = response
      fillInUsers(users);
      updateEditUserForm(document.getElementById('edit-category-categories-select'))
      if (callback) {
        callback();
      }
    });
}

function updateUserRoles(callback) {
  let categoriesRequest = new Request("/api/v1/userrole/list");
  fetch(categoriesRequest).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
    .then(function(response) {
      userRoles = response
      fillInUserRoles(userRoles);
      if (callback) {
        callback();
      }
    });
}

function updateProducts(callback) {
  let categoriesRequest = new Request("/api/v1/product/list");
  fetch(categoriesRequest).then((response) => {
    if (!response.ok || response.status != 200) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
    .then(function(response) {
      products = response
      fillInProducts(products);
      updateEditProductsForm(document.getElementById('editProduct-product-select'));
      if (callback) {
        callback();
      }
    });
}

function update() {
  updateCatgories(updateProducts);
  updateUserRoles(updateUsers);
}

update();
