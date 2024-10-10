<form action="../includes/create_product.inc.php" method="POST" id="productForm">
    <label for="store_id">Store:</label>
    <select name="store_id" required>
        <option value="">Select Store</option>
        <?php
        $storeCtrl = new StoreCtrl();
        $stores = $storeCtrl->getAllStores();
        foreach ($stores as $store) {
            echo "<option value='{$store['store_id']}'>{$store['store_name']}</option>";
        }
        ?>
    </select>

    <label for="product_id">Product Category:</label>
    <select name="product_id" required>
        <option value="">Select Category</option>
        <?php
        $categoryCtrl = new ProductCategoryCtrl();
        $categories = $categoryCtrl->getAllCategories();
        foreach ($categories as $category) {
            echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
        }
        ?>
    </select>

    <label for="models">Models:</label>
    <div id="model-container">
        <?php
        $modelCtrl = new ModelCtrl();
        $models = $modelCtrl->getAllModels();
        foreach ($models as $model) {
            echo "
            <div class='model-entry'>
                <input type='checkbox' name='model_id[]' value='{$model['model_id']}'> {$model['model_name']}
                <input type='number' name='model_quantity[{$model['model_id']}]' placeholder='Quantity' min='1' disabled>
            </div>";
        }
        ?>
    </div>

    <label for="state_id">State:</label>
    <select name="state_id" required>
        <option value="">Select State</option>
        <?php
        $stateCtrl = new StateCtrl();
        $states = $stateCtrl->getAllStates();
        foreach ($states as $state) {
            echo "<option value='{$state['state_id']}'>{$state['state_name']}</option>";
        }
        ?>
    </select>

    <label for="description">Description:</label>
    <textarea name="description"></textarea>

    <label for="specification">Specification:</label>
    <textarea name="specification"></textarea>

    <button type="submit" name="submit">Add Product</button>
</form>

<script>
// Enable quantity input when model checkbox is selected
document.querySelectorAll("input[type='checkbox'][name='model_id[]']").forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const quantityInput = this.parentElement.querySelector("input[type='number']");
        if (this.checked) {
            quantityInput.disabled = false;
        } else {
            quantityInput.disabled = true;
            quantityInput.value = ''; // Clear quantity if unchecked
        }
    });
});
</script>
