let categories;
let users;
let userRoles;

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
    updateCatgories();
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

function update() {
  updateCatgories();
  updateUserRoles(updateUsers);
}

update();
