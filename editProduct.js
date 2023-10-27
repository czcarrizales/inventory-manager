document.addEventListener('DOMContentLoaded', () => {
    const editProductName = document.getElementById('editProductName')
    const editProductDescription = document.getElementById('editProductDescription')
    const editProductPrice = document.getElementById('editProductPrice')
    const editProductCategory = document.getElementById('editProductCategory')

    function getProductById() {
        const url = window.location.search;
        const urlParams = new URLSearchParams(url)
        const product_id = urlParams.get('product_id')
        axios.get('functions.php?function=getProductById', {
            params: {
                product_id: product_id
            }
        })
        .then(response => {
            const data = response.data.result[0]
            console.log(data.category_id)
            editProductName.value = data.product_name
            editProductDescription.value = data.description
            editProductPrice.value = data.price
            editProductCategory.value = data.category_id
            console.log(response.data.result[0])
        })
        .catch(error => {
            console.log(error)
        })
    }
    getProductById()
})