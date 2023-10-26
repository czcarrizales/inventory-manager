document.addEventListener('DOMContentLoaded', () => {
    const companyNameTitle = document.getElementById('companyNameTitle')
    const inventoryTableBody = document.getElementById('inventoryTableBody')
    const sortItemsForm = document.getElementById('sortItemsForm')
    const searchByKeywordForm = document.getElementById('searchByKeywordForm')
    const selectCompaniesForm = document.getElementById('selectCompaniesForm')
    const selectCompaniesDropdown = document.getElementById('selectCompaniesDropdown')
    const selectCategoriesDropdown = document.getElementById('selectCategoriesDropdown')
    const addProductToDatabaseForm = document.getElementById('addProductToDatabaseForm')
    const addProductCategorySelect = document.getElementById('addProductCategorySelect')

    searchByKeywordForm.addEventListener("submit", (event) => {
        event.preventDefault();
        const keywordValue = document.getElementById('keyword').value
        loadData(undefined, undefined, keywordValue)
    })

    selectCompaniesDropdown.addEventListener("change", (event) => {
        event.preventDefault();
        const companyId = selectCompaniesDropdown.value
        loadData(companyId, undefined, undefined)
        getAllCategories(companyId)
    })

    addProductToDatabaseForm.addEventListener("submit", (event) => {
        event.preventDefault()
        console.log('adding to database button pressed')
        const product_name = document.getElementById('addProductName').value
        const description = document.getElementById('addProductDescription').value
        const price = document.getElementById('addProductPrice').value
        const category_id = document.getElementById('addProductCategorySelect').value
        addProductToDatabase(product_name, description, price, category_id)
    })

    function addProductToDatabase(product_name, description, price, category_id) {
        const company_id = selectCompaniesDropdown.value
        let params = new URLSearchParams()
        params.append('function', 'addProductToDatabase')
        params.append('product_name', product_name)
        params.append('description', description)
        params.append('price', Number(price))
        params.append('category_id', category_id)
        params.append('company_id', company_id)
        axios.post('functions.php', params)
            .then(response => {
                console.log(response)
                loadData()
            })
            .catch(error => {
                console.log(error)
            })
    }

    function deleteById(id) {
        let params = new URLSearchParams()
        params.append('function', 'deleteById')
        params.append('id', id)
        axios.post('functions.php', params)
            .then(response => {
                loadData()
            })
    }

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-button')) {
            const itemId = event.target.getAttribute('data-id')
            deleteById(itemId)
        }
    })

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('edit-button')) {
            const product_id = event.target.getAttribute('data-id')
            window.location.href = 'editProduct.php?product_id=' + product_id + '&company_id=' + selectCompaniesDropdown.value
        }
    })

    function getAllCompanies() {
        axios.get('functions.php?function=getAllCompanies')
            .then(response => {
                data = response.data.result
                data.forEach(company => {
                    const option = document.createElement("option")
                    option.text = company.company_name
                    option.value = company.company_id
                    selectCompaniesDropdown.appendChild(option)
                })
                const company_id = selectCompaniesDropdown.value
                loadData()
                getAllCategories(company_id)
            })
    }

    function getAllCategories(company_id) {
        axios.get('functions.php?function=getAllCategories', {
            params: {
                company_id: company_id
            }
        })
            .then(response => {
                for (let i = selectCategoriesDropdown.options.length - 1; i >= 0; i--) {
                    const option = selectCategoriesDropdown.options[i];
                    if (option.value !== "") {
                        selectCategoriesDropdown.remove(i);
                    }
                }
                for (let i = addProductCategorySelect.options.length - 1; i >= 0; i--) {
                    const option = addProductCategorySelect.options[i];
                    addProductCategorySelect.remove(i);
                }
                data = response.data.result
                data.forEach(category => {
                    const addProductCategoryOption = document.createElement("option")
                    addProductCategoryOption.text = category.category_name
                    addProductCategoryOption.value = category.category_id
                    addProductCategorySelect.appendChild(addProductCategoryOption)

                    const selectCategoryOption = document.createElement("option")
                    selectCategoryOption.text = category.category_name
                    selectCategoryOption.value = category.category_id
                    selectCategoriesDropdown.appendChild(selectCategoryOption)
                })
            })
    }

    function loadData(company_id = Number(selectCompaniesDropdown.value), category_id = '', keyword = '') {
        axios.get('functions.php?function=getProducts', {
            params: {
                company_id: company_id,
                category_id: category_id,
                keyword: keyword
            }
        })
            .then(response => {
                inventoryTableBody.innerHTML = ""
                const company_name = response.data.result[0]['company_name'];
                const products = response.data.result[1];
                companyNameTitle.innerHTML = company_name
                products.forEach(product => {
                    const row = document.createElement('tr')
                    row.innerHTML = `
                    <td>${product.product_id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.description}</td>
                    <td>${product.price}</td>
                    <td>${product.category_id}</td>
                    <button class="delete-button" data-id="${product.product_id}">delete</button>
                    <button class="edit-button" data-id="${product.product_id}">edit</button>
                    `
                    inventoryTableBody.appendChild(row)
                })
            })
            .catch(error => {
                console.error(error)
            })
    }

    getAllCompanies()

    sortItemsForm.addEventListener("submit", (event) => {
        event.preventDefault();
        let selectedCategory = selectCategoriesDropdown.value
        if (selectedCategory !== '') {
            selectedCategory = Number(selectedCategory)
        }
        loadData(undefined, selectedCategory, undefined)
    })
})

