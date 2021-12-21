function fillInCategories(categories) {
  let categories_select = document.getElementById("categories-select");

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

  if (form[3].value == "on") {
    form[3].value = 1
  } else {
    console.log(form[3])
  }
  const formData = new FormData(form);

  const dict = {};
  for (const pair of formData) {
    dict[pair[0]] = pair[1];
  }

  dict['available'] = dict['available'] == "on";
  //if (dict['available'] == "on") {
  //  dict['available'] = 1;
  //} else {
  //  dict['available'] = 1;
  //}

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
    //return response.json();
  })
  //.then(function(response) {
  //  console.log(response)
  //});

  console.log(content);

  return false;
}

var a

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
